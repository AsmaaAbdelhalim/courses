<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Stripe\Stripe;
//use Stripe\Checkout\Session;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\payment;
//use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentController extends Controller
{
    public function index()
    {
       
    }
    /**
     * 
     */
     
    public function list(){
        $payments = Payment::all()->sortByDesc('created_at');
        $payments = Payment::latest()->paginate(10);
        return view('payment.list',compact('payments'));
    }


    public  function checkout($courseId)
    {
        $course = Course::find($courseId);
        return view('payment.checkout',compact('course'));
    }
    public function session(Request $request, $courseId)
    {
        \Stripe\Stripe::setApiKey(config('app.st_secret'));      

    $course = Course::findOrFail($courseId);
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

        'success_url' => route('success', [$course->id], true) . "?session_id={CHECKOUT_SESSION_ID}" . "{$course->id}" . "$course->price",
        'cancel_url' => route('course.show', [$course->id]),

        'metadata' => [
            'course_id' => $course->id,
            'user_id' => auth()->user()->id,
        ],
    ]);



    
    return redirect($session->url);
    }

    public function success(Request $request, $courseId)
    {   
        $course = Course::find($courseId);
    return view('payment.success',compact('course'));
    }

    public function webhook(Request $request)
    {
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        //Log::debug('Webhook event', [$event->type]);

        // Handle the event
        switch ($event->type) {
            //case 'payment_intent.succeeded':
                //$paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                //Log::debug('Payment succeeded', [$paymentIntent->id]);
                case 'checkout.session.completed':
                $checkoutSession = $event->data->object;
                Log::debug('Checkout session completed', [$checkoutSession->id]);
        }

        

        //create payment
        $payment = new Payment();
        $payment->course_id = $event->data->object->metadata->course_id;
        $payment->user_id = $event->data->object->metadata->user_id;
        $payment->total_price = $event->data->object->amount_total;
        $payment->currency = $event->data->object->currency;
        $payment->session_id = $event->data->object->id;

        $payment->payment_method = $event->data->object->payment_method;
            $payment->payment_intent = $event->data->object->payment_intent;
            $payment->payment_status = $event->data->object->payment_status;
            $payment->status = $event->data->object->status;
            $payment->payment_id = $event->data->object->payment_id;
            $payment->country = $event->data->object->country;
        $payment->save();

            $enrollment = Enrollment::create([
                'course_id' => $event->data->object->metadata->course_id,
                'user_id' => $event->data->object->metadata->user_id,
            ]); 
            $enrollment->save(); 
        }
    }    