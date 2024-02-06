@extends('layouts.app')
@section('content')

<div class="col-md-9">
           
                   
           <h2>Enrolled Courses</h2>
           @if($user->enrollments->count() > 0)
                              <strong>( {{ $user->enrollments->count() }} )</strong>
           @foreach ($enrollments as $enrollment)
               <div class="card">
                   <div class="card-header">
                       <h5 class="m-0">{{ $enrollment->course->name }}</h5>
                   </div>
                   <div class="card-body">
                       <h6 class="card-title">{{ $enrollment->course->name }}</h6>

                       <img class="img-fluid" src="{{ asset('images/' . $enrollment->course->image) }}">

                       <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                       <a href="{{ route('course.show', [$enrollment->course->id]) }}" class="btn btn-primary">Go To Course</a>
                   </div>
               </div>
           @endforeach
           
                               @else
                               <a href="{{ route('course.index') }}" class="btn btn-primary"><b> No Courses Enrolled Go To Courses To Start </b></a>
                               @endif
           
                             
                           </div>

    </div>

@endsection