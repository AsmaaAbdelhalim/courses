
@extends('layouts.app')
@section('content')




<!-- Courses End -->
<div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">My Wishlist Courses</h5>       
                @if( count($wishlistCourses) > 0)
<strong>( {{ count($wishlistCourses) }} )</strong>
            </div>
    <div class="row">
        @foreach($wishlistCourses as $course)
        @include('layouts.course')
        @endforeach
        </div>
        </div>
    </div>


    <!-- Courses End -->



@else
<p>You have no wishlisted courses</p>


@endif
@endsection