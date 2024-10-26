@extends('layouts.app')
@section('content')
    <!-- Header Start -->

            <img src="{{ asset('images/' . $category->image) }}" position="relative"; width="100%"; height= "350px"; padding-bottom="56.25%"; >
    <!-- Category Start -->
    
 <!-- End -->
    <div class="container">
@if($category->courses->count() > 0)
    
       <!-- Courses End -->
       <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Courses</h5>       
                <h1>{{ $category->name }}</h1>
            </div>
    <div class="row">
    @foreach($category->courses as $course)
    @include('layouts.course')

    @endforeach
    </div>
    </div>
    </div>


    <!-- Courses End -->
 
    
    

@else
    <p>No courses found in this category.</p>
@endif
</div>
{{ $courses->links('layouts.custom-pagination')}}
@endsection 


    