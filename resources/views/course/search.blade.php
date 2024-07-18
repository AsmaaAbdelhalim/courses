@extends('layouts.app')
@section('content')
<!-- Courses End -->
<div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Courses</h5>       
            </div>
    <div class="row">
        @foreach($courses as $course)
        <div class="col-lg-4 col-md-6 mb-4">
                    <div class="rounded overflow-hidden mb-2">
                        
                    <img class="img-fluid" src="{{ asset('images/' . $course->image) }}">
                       <div class="bg-secondary p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="m-0"><i class="fa fa-users text-primary mr-2"></i >
                               
                                {{ $course->enrollment_count }}
                                Students</small>
                                <small class="m-0"><i class="far fa-clock text-primary mr-2"></i>{{ $course->numOfHours }} h</small>
                            </div>
                            <a class="h5" href="{{route ('course.show',[$course->id])}}"><h1>{{$course->name}}</h1></a>
<form action="{{ route('wishlist.remove', $course) }}" method="PUT">
    @csrf
    
    @method('DELETE')
    <button type="submit" class="btn default"><i class="fas fa-heart  text-primary mr-2"></i></button>
</form>  
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
        {{ $courses->links() }}
        </div>
    </div>


    <!-- Courses End -->

@endsection