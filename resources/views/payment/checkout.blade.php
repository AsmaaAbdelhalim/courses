@extends('layouts.app')
@section('content')
<div class="container">
    





<form action="{{ route('payment.store') }}" method="POST">

<form action="/session" method="POST">

    

                                <a href="{{ url('/course') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Go To Courses</a>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">

                                <input type='hidden' name="course_id" value="{{ $course->name }}">
                               
    <input type="hidden" name="amount" value="{{ $course->price }}">


    </form>                            <button class="btn btn-success" type="submit" id="checkout-live-button"><i class="fa fa-money"></i> Checkout</button>
</form>
@endsection<form action="/session" method="POST">
                                <a href="{{ url('/course') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i>Go To Courses </a>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type='hidden' name="amount" value="{{ $course->price }}"> 
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type='hidden' name="course_id" value="{{ $course->name }}">
                                <button class="btn btn-success" type="submit" id="checkout-live-button"><i class="fa fa-money"></i> Checkout</button>
                                </form>