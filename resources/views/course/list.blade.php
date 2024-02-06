@extends('layouts.admin')

@section('content')

<br><br>
    
    <h1 class="m-0 text-white display-4 text-center"><span class="text-danger">Courses</span></h1>

    <a href="{{route('course.create')}}" class="btn btn-primary btn-lg m-2">Add Course</a>

<div class="container">
    <div class="row">
    <div class="col-lg-10 m-auto py-2">
    <table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Created By</th>
            <th>Num of lessons</th>
            <th>Lessons</th>
            <th>Num of user enrolled</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
        <tr>
            <td>{{ $course->id }}</td>
            <td>{{ $course->name }}</td>
            <td>{{ $course->price }}</td>
            <td>{{ $course->user->name }}</td>
            <td>{{ $course->lesson_count }}</td>
            <td>{{ $course->lesson_title }}</td>
            <td>{{ $course->enrollment_count }}</td>
            <td>{{ $course->category_id }}</td>
            <td>
                <!-- Action buttons --> 
                <a
            href="{{route ('course.show',[$course->id])}}"
             class="btn btn-info ">
              Details
            </a>
                <a href="{{route ('course.edit',[$course->id])}}" class="btn btn-primary">Edit</a>
                <form action="{{route('course.destroy',[$course->id])}}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

       
    </div>
    </div>
    @endsection