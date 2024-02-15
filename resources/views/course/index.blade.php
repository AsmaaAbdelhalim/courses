
@extends('layouts.app')
@section('content')
@include('layouts.header')
    <!-- Category Start -->

    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Subjects</h5>
                <h1>Explore Top Subjects</h1>
            </div>
            <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="cat-item position-relative overflow-hidden rounded mb-2">
                        <img class="img-fluid" src="{{ asset('images/' . $category->image) }}" alt="Category Image">
                        <a class="cat-overlay text-white text-decoration-none" href="{{route ('category.show',[$category->id])}}">
                            <h4 class="text-white font-weight-medium">{{ $category->name }}</h4>
                            <span>{{ $category->course->count() }} Courses</span>
                        </a>
                    </div>
                </div>@endforeach
                </div>
            </div>
        </div>
    
    
    <!-- Category End -->
        
    
    <!-- Courses End -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Courses</h5>
                @foreach ($categories as $category)
                <h1>{{ $category->name }}</h1>
            </div>

    <div class="row">
        @foreach ($category->courses->take(6) as $course)
        <div class="col-lg-4 col-md-6 mb-4">
                    <div class="rounded overflow-hidden mb-2">
                    <img class="img-fluid" src="{{ asset('images/' . $course->image) }}">
                        <div class="bg-secondary p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="m-0"><i class="fa fa-users text-primary mr-2"></i>
                               
                                {{ $course->enrollment_count }}
                                Students</small>
                                <small class="m-0"><i class="far fa-clock text-primary mr-2"></i>{{ $course->numOfHours }} h</small>
                            </div>
                            <a class="h5" href="{{route ('course.show',[$course->id])}}"><h1>{{$course->name}}</h1></a>
                            @if (Auth::check())
        @if(in_array( $course->id , $user_wishlist_ids))

<form action="{{ route('wishlist.remove', $course) }}" method="PUT">
    @csrf
    @method('DELETE')
    <button class="btn default"><i class="fas fa-heart text-primary mr-2"></i></button>
</form>
@else
    <form action="{{ route('wishlist.add', $course) }}" method="POST">
    @csrf
    <button class="btn default"><i class="far fa-heart text-primary mr-2"></i></button>
</form>
@endif
@else
<a href="{{ route('login') }}"><i class="far fa-heart"></i></a>
@endif
<div class="border-top mt-4 pt-4">
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0"><i class="fa fa-star text-primary mr-2"></i><small>({{$course->reviews()->count()}})</small></h6>
                                    <h5 class="m-0">
                                        @if($course->price == 0)
                                        <span class="text-success">Free</span>
                                        @else
                                        {{$course->price}} $
                                        @endif
                                    </h5>

                                    

                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                        
        @endforeach
        </div>
        </div>
    </div>
@endforeach

    <!-- Courses End -->
@endsection 
    
    

  