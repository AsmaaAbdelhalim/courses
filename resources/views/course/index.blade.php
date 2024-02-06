
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
<!-- <div>
    ('category.index')</div> -->
    <!-- Course List Start -->
    
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Courses</h5>
                <h1>Our Popular Courses</h1>
            </div>
            <div class="row">
              @foreach ($courses as $course)
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
                            <div class="border-top mt-4 pt-4">
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0"><i class="fa fa-star text-primary mr-2"></i> number_format($course->review->rating , 1) <small>({{$course->reviews()->count()}})</small></h6>
                                    <h5 class="m-0">
                                        @if($course->price == 0)
                                        <span class="text-success">Free</span>
                                        @else
                                        {{$course->price}} $
                                        @endif
                                    </h5>

                                    @if (Auth::check())
        @if ($course->wishlists(Auth::user()))
        <form action="{{ route('wishlist.add', $course) }}" method="POST">
    @csrf
    <button type="submit"><i class="fas fa-heart text-red">add</i></button>
</form>

@else
<form action="{{ route('wishlist.remove', $course) }}" method="PUT">
    @csrf
    
    @method('DELETE')
    <button type="submit"><i class="fas fa-heart text-gray">remove</i></button>
</form>
@endif
@else
<a href="{{ route('login') }}"><i class="fas fa-heart text-gray"></i></a>
@endif



                               </div>
                            </div>
                        </div>
                    </div>
                </div>@endforeach
</div>
</div>
</div>

        
    
    <!-- Courses End -->
    
    @foreach ($categories as $category)
    <h2>{{ $category->name }}</h2>

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
                            <div class="border-top mt-4 pt-4">
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0"><i class="fa fa-star text-primary mr-2"></i> number_format($course->review->rating , 1) <small>({{$course->reviews()->count()}})</small></h6>
                                    <h5 class="m-0">
                                        @if($course->price == 0)
                                        <span class="text-success">Free</span>
                                        @else
                                        {{$course->price}} $
                                        @endif
                                    </h5>

                                    @if (Auth::check())
        @if(in_array( $course->id , $user_wishlist_ids))
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
<style>
    .favorite-button {
  cursor: pointer;
  border: 0;
  color: red;
}

.favorite-button .favorite__icon {
  height: 30px;
  width: 30px;
  opacity: 0;
  transition: opacity 0.3s, transform 0.3s;
  transform: scale(.6);
  position: absolute;
}

.fas.fa-heart{
  opacity: 1;
  transform: scale(1);
  border: 0;
  color: red;
}

.far.fa-heart {
  opacity: 1;
  transform: scale(1);
  border: 0;
  color: red;
}
    </style>    
<form action="{{ route('wishlist.remove', $course) }}" method="PUT">
    @csrf
    @method('DELETE')
    <button  ><i class="fas fa-heart"></i></button>
</form>
@else
    <form action="{{ route('wishlist.add', $course) }}" method="POST">
    @csrf
    <button ><i class="far fa-heart"></i></button>
</form>
@endif
@else
<a href="{{ route('login') }}"><i class="fas fa-heart favorite__icon favorite--enable"></i></a>
@endif





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
    
    

  