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
        @include('layouts.course')  
        @endforeach
        </div>
        {{ $courses->links() }}
        </div>
    </div>


    <!-- Courses End -->

@endsection