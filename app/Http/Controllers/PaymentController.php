<?php

namespace App\Http\Controllers;

//use Exception;
//use Stripe\StripeClient;
use Illuminate\Http\Request;
//use Stripe\Exception\CardException;

use Stripe\Stripe;
//use Stripe\PaymentIntent;

use Stripe\Checkout\Session;

//use Illuminate\View\View;
//use Illuminate\Http\RedirectResponse;
use App\Models\Course;
use App\Models\payment;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Validator;


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
    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('app.st_secret'));

        $courses = course::all();
        $lineItems = [];
        $totalPrice = 0;
        foreach ($courses as $course) {
            $totalPrice += $course->price;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $course->name,
                        'images' => [$course->image],

                    ],
                    'unit_amount' => $course->price * 100,
                ],
                'quantity' => 1,
            ];
        }
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('course.show',[$course->id]),
        ]);

// dd($session);
        return redirect($session->url);
    }
 
    public function success(Request $request)
    {
        $courses = course::all();
        $lineItems = [];
        $totalPrice = 0;
        $course_id = 0;
        foreach ($courses as $course) {
            $totalPrice = $course->price;
            $course_id = $course->id;
        }
        $payment = new payment();
        //$payment->status = 'unpaid';
        $payment->total_price = $totalPrice;
        $payment->session_id = $request->session_id;
        $payment->user_id = auth()->user()->id;
        $payment->course_id = $course->id;
        
        $payment->save();

    return view ('payment.success');
    }

}