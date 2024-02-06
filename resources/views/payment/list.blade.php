@extends('layouts.admin')

@section('content')
    
<div class="container">
<h1 class="m-0 text-white display-4 text-center"><span class="text-danger">Payments</span></h1>
    <div class="col-lg-10 m-auto py-2">
<table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>User Name</th>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Price</th>
            <th>Payment At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment) 
        
        <tr>
            <td>{{ $payment->id }}</td>
            <td>{{ $payment->user_id }}</td>
            <td>{{ $payment->user->first_name }}
            {{ $payment->user->last_name }}</td> 
            <td>{{ $payment->course_id }}</td>
            <td>{{ $payment->course->name }}</td>
            <td>{{ $payment->total_price }}</td>
            <td>{{ date("F d, Y", strtotime($payment->created_at))}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $payments->links('layouts.custom-pagination') }}
</div>
</div>
@endsection