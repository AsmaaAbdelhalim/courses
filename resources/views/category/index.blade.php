@extends('layouts.admin')

@section('content')

<br><br>
    
    <h1 class="m-0 text-white display-4 text-center"><span class="text-danger">categories</span></h1>
    
    <a href="{{route('category.create')}}" class="btn btn-primary btn-lg m-2">Add Category</a>

<div class="container">
    <div class="row">
    <div class="col-lg-10 m-auto py-2">
    <table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
         <th>Description</th>
            <th>Image</th>
            <th>Created By</th>
            <th>Num of courses</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td><img src="{{ asset('images/' . $category->image) }}" alt="Category Image" width="100" height="100"></td>
       
            <td>{{$category->user->first_name}}</td>
            <td>{{$category->course_count}}</td>
            <td>
                <!-- Action buttons --> 
                <a
            href="{{route ('category.show',[$category->id])}}"
             class="btn btn-info">
              Details
            </a>
                        <a href="{{route ('category.edit',[$category->id])}}" class="btn btn-primary">Edit</a>
                <form action="{{route('category.destroy',[$category->id])}}" method="POST" class="d-inline">
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
    </div>
    @endsection