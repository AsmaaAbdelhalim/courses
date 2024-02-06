@extends('layouts.admin')

@section('content')

<br><br>
   
    <h1 class="m-0 text-white display-4 text-center"><span class="text-danger">enrollments </span></h1>
    

<div class="container">
    <div class="row">

    <table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>User Name</th>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Enrollment At</th>
            <th>progress</th>
            <th>Action</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item) 
        
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->user_id }}</td>
            <td>{{ $item->user->first_name }}
            {{ $item->user->last_name }}</td> 
            <td>{{ $item->course_id }}</td>
            <td>{{ $item->course->name }}</td>
            <td>{{ date("F d, Y", strtotime($item->created_at))}}</td>
            <td>
                {{ $item->progress }}</td>
            <td>
                <!-- Action buttons --> 
                <a href="{{ route('enrollment.show', $item->id) }}">View Enrollment</a>


                <a
            href="{{route ('course.show',[$item->id])}}"
             class="btn btn-info "
            style="width:10%;">
              Details
            </a>
                <a href="{{route ('course.edit',[$item->id])}}" class="btn btn-primary">Edit</a>
                <form action="{{route('course.destroy',[$item->id])}}" method="POST" class="d-inline">
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