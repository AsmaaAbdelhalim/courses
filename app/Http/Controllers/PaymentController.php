<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

class PaymentController extends Controller
{
    
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function index()
    {        
        $payments = Payment::latest()->paginate(10);
        return view('payment.index',compact('payments'));
    }
     
    public function list(){

    }

    public function session(Request $request, $courseId)
    {
        try{
            $course = Course::findOrFail($courseId);
            $user = Auth::user(); 
            $existingEnrollment = Enrollment::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->first();
                
            if ($existingEnrollment) {
                return redirect()->route('course.show', $course->id)->with('error', 'You are already enrolled in this course.');
            }
            
            if ($course->price == 0) {
                Enrollment::create([
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                ]);
                return redirect()->route('course.show', $course->id)->with('success', 'You have been enrolled in this free course.');
            }
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => $course->price * 100,
                        'product_data' => [
                            'name' => $course->name,
                            'description' => $course->description,
                            'images' => [$course->image],
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success', [$course->id], true),
            'cancel_url' => route('course.show', [$course->id]),
            'metadata' => [
                'course_id' => $course->id,
                'user_id' => Auth::id(),
            ],
        ]);
        return redirect($session->url); 
        } catch (\Exception $e) {
            Log::error('Stripe session creation failed', ['error' => $e->getMessage()]);
            return redirect()->route('course.show', $course->id)->with('error', 'Failed to create payment session.');
        }
    }

    public function success(Course $course)
    {   
        return view('payment.success',compact('course'));
    }


    public function webhook(Request $request)
    {
        $endpoint_secret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        Log::info('Stripe Webhook Received', [
            'has_signature' => !empty($sig_header),
            'payload_length' => strlen($payload),
        ]);

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
            
            Log::info('Stripe Webhook Event Constructed', [
                'event_type' => $event->type,
                'event_id' => $event->id,
            ]);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe Webhook: Invalid payload', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe Webhook: Invalid signature', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Stripe Webhook Error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Webhook processing failed'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            Log::info('Processing checkout.session.completed', [
                'session_id' => $session->id,
                'payment_status' => $session->payment_status,
                'metadata' => $session->metadata ?? null,
            ]);

            // Validate metadata exists
            if (empty($session->metadata) || !isset($session->metadata->course_id) || !isset($session->metadata->user_id)) {
                Log::error('Stripe Webhook: Missing metadata', [
                    'session_id' => $session->id,
                    'metadata' => $session->metadata ?? null,
                ]);
                return response()->json(['error' => 'Missing required metadata'], 400);
            }

            try {
                DB::transaction(function () use ($session) {
                    // Check if payment already exists to prevent duplicates
                    $existingPayment = Payment::where('session_id', $session->id)->first();
                    if ($existingPayment) {
                        Log::warning('Payment already exists', ['session_id' => $session->id]);
                        return;
                    }

                    // Check if enrollment already exists
                    $existingEnrollment = Enrollment::where('user_id', $session->metadata->user_id)
                        ->where('course_id', $session->metadata->course_id)
                        ->first();
                    
                    if ($existingEnrollment) {
                        Log::warning('Enrollment already exists', [
                            'user_id' => $session->metadata->user_id,
                            'course_id' => $session->metadata->course_id,
                        ]);
                    }

                    // Create payment record
                    $payment = Payment::create([
                        'course_id' => $session->metadata->course_id,
                        'user_id' => $session->metadata->user_id,
                        'total_price' => $session->amount_total / 100,
                        'currency' => $session->currency,
                        'session_id' => $session->id,
                        'payment_intent' => $session->payment_intent,
                        'payment_status' => $session->payment_status,
                        'status' => $session->status,
                        'country' => $session->customer_details->address->country ?? null,
                        'payment_id' => $session->id,
                    ]);

                    Log::info('Payment created successfully', [
                        'payment_id' => $payment->id,
                        'session_id' => $session->id,
                    ]);

                    // Create enrollment if it doesn't exist
                    if (!$existingEnrollment) {
                        Enrollment::create([
                            'course_id' => $session->metadata->course_id,
                            'user_id' => $session->metadata->user_id,
                            //'payment_id' => $payment->id,
                        ]);

                        Log::info('Enrollment created successfully', [
                            'user_id' => $session->metadata->user_id,
                            'course_id' => $session->metadata->course_id,
                        ]);
                    } else {
                        // Update existing enrollment with payment_id if not set
                        if (!$existingEnrollment->payment_id) {
                            $existingEnrollment->update(['payment_id' => $payment->id]);
                            Log::info('Updated existing enrollment with payment_id');
                        }
                    }
                });

                Log::info('Webhook processed successfully', ['session_id' => $session->id]);
            } catch (\Exception $e) {
                Log::error('Error processing webhook transaction', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'session_id' => $session->id ?? null,
                ]);
                return response()->json(['error' => 'Failed to process payment'], 500);
            }
        } else {
            Log::info('Unhandled webhook event type', ['event_type' => $event->type]);
        }

        return response()->json(['status' => 'success']);
    }
    
}    