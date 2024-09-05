<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\payment;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    ]);

    
    return redirect($session->url);
    }

    public function success(Request $request, $courseId)
    {
        $payment = Payment::where('session_id', $request->session_id)->first();

        $course = Course::findOrFail($courseId);
        $total_price = $course->price; 

    $payment = Payment::create([
        'currency' => 'usd',
        'session_id' => $request->session_id, 

        'user_id' => auth()->user()->id,
        'course_id' => $courseId,
        'total_price' => $total_price,
    ]);

    $payment->save();

    $enrollment = Enrollment::create([
        'user_id' => Auth::id(),
        'course_id' => $courseId,
        
         
    ]); 
    $enrollment->save(); 

    return view('payment.success');
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

        Log::debug('Webhook event', [$event->type]);

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                Log::debug('Payment succeeded', [$paymentIntent->id]);
        }
        // Update payment record and create enrollment
        $payment = Payment::where('session_id', $paymentIntent->id)->first();
        if ($payment) {
            $payment->status = 'success';
            $payment->save();

            // Create enrollment (assuming Enrollment model)
            $enrollment = Enrollment::create([
                'user_id' => Auth::id(), // Replace with your user ID retrieval logic
                'course_id' => $request->course_id, // Assuming course ID is available

                 
            ]); 
            $enrollment->save(); 
        }
    }
    // Handle other Stripe events here if needed
        
    }