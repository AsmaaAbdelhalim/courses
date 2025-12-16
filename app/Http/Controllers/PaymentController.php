<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\StorePaymentRequest;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
       
    }
    /**
     * 
     */
     
    public function list(){
        $payments = Payment::latest()->paginate(10);
        return view('payment.list',compact('payments'));
    }

    public function session(Course $course)
    {
        \Stripe\Stripe::setApiKey(config('app.st_secret'));      
        $lineItems = [];
        $total_price = $course->price;
        $lineItems[] = [
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => $course->name,
                'images' => [$course->image],
            ],
            'unit_amount' => $course->price * 100 ,
        ],
        'quantity' => 1,
    ];

    $session = \Stripe\Checkout\Session::create([
        'line_items' => $lineItems,
        'mode' => 'payment',

        //'success_url' => route('success', [urlencode($course->id)], true), 

        'success_url' => route('success', [$course->id], true) ,
       // . "?session_id={CHECKOUT_SESSION_ID}" . "{$course->id}" . "$course->price",
        'cancel_url' => route('course.show', [$course->id]),
        'metadata' => [
            'course_id' => $course->id,
            'user_id' => Auth::id(),
        ],
    ]);
        return redirect($session->url);
    }

    public function success(Course $course)
    {   
        return view('payment.success',compact('course'));
    }

        // Handle the event
        //switch ($event->type) {
            //case 'payment_intent.succeeded':
                //$paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                //Log::debug('Payment succeeded', [$paymentIntent->id]);
                //case 'checkout.session.completed':
                //$checkoutSession = $event->data->object;
                //Log::debug('Checkout session completed', [$checkoutSession->id]);
        //}

    public function webhook()
    {
        // Verify Stripe signature
        //$endpoint_secret = config('app.stripe.webhook_secret');
        $payload = @file_get_contents('php://input');


        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            Log::error('Invalid webhook payload', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        if ($event->type !== 'checkout.session.completed') {
            return response()->json(['message' => 'Unhandled event type'], 200);
        }

        try {

            DB::transaction(function() use ($event) {
                // Create payment record with actual data
                Payment::create([
                    'course_id' => $event->data->object->metadata->course_id,
                    'user_id' => $event->data->object->metadata->user_id,
                    'total_price' => $event->data->object->amount_total,
                    'currency' => $event->data->object->currency,
                    'session_id' => $event->data->object->id,
                    'payment_method' => $event->data->object->payment_method_configuration_details->id ?? null,
                    'payment_intent' => $event->data->object->payment_intent,
                    'payment_status' => $event->data->object->payment_status,
                    'status' => $event->data->object->status,
                    'payment_id' => $event->data->object->id,
                    'country' => $event->data->object->customer_details->address->country ?? null,
                ]);
    
                // Create enrollment with the payment reference
                Enrollment::create([
                    'course_id' => $event->data->object->metadata->course_id,
                    'user_id' => $event->data->object->metadata->user_id,
                    //'payment_id' => $payment->id
                ]);
            });
            return view ('payment.success');
           // return response()->json(['message' => 'Payment processed successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Payment processing failed', ['error' => $e->getMessage()]);
            //return response()->json(['error' => 'Payment processing failed'], 500);
            return redirect()->route('course.show')->with('error', 'Payment processing failed');
        }
    }
}    