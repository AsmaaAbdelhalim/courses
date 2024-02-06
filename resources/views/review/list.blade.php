@extends('layouts.admin')

@section('content')

<br><br>
    
    <h1 class="m-0 text-white display-4 text-center"><span class="text-danger">Reviews</span></h1>
    
<div class="container">
    <div class="row">
    <div class="col-lg-10 m-auto py-2">
    <table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>Course</th>
            <th>Review</th>
            <th>Rating</th>
            <th>User</th>
            <th>Created At</th>
            <th>Action</th>
    
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
        <tr>
            <td>{{ $review->id }}</td>
            <td>{{$review->course->name}}</td>
            <td>{{ $review->review }}</td>
            <td>{{ $review->rating }}</td>
            <td>{{ $review->user->first_name }}</td>
            <td>{{ $review->created_at}}</td>

            <td>
                <!-- Action buttons --> 

                view
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $reviews->links('layouts.custom-pagination') }}
</div>
    </div>
    </div>

@endsection