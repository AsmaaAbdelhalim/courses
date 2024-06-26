@extends('layouts.admin')

@section('content')

<br><br>
    
    <h1 class="m-0 text-white display-4 text-center"><span class="text-danger">lessons</span></h1>

    <a href="{{route('lesson.create')}}" class="btn btn-primary btn-lg m-2">Add Lesson</a>

<div class="container">
    <div class="row">
    <div class="col-lg-10 m-auto py-2">
    <table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Course</th>
            <th>Created By</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lessons as $lesson)
        <tr>
            <td>{{ $lesson->id }}</td>
            <td>{{ $lesson->title }}</td>
            <td>{{ $lesson->course->name }}</td>
            <td>{{$lesson->user->first_name}}</td>
            <td>
                <!-- Action buttons --> 
                <a
            href=""
             class="btn btn-info ">
              Details
            </a>
                <a href="{{route ('lesson.edit',[$lesson->id])}}" class="btn btn-primary">Edit</a>
                <form action="{{route('lesson.destroy',[$lesson->id])}}" method="POST" class="d-inline">
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