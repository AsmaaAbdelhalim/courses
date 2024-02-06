@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="row"> 
    <div class="col-lg-10 m-auto py-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Lesson</h4>
                </div>
                <div class="card-body">
                   <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('lesson.update',[$lesson->id])}}" method="POST">
                            @csrf
                            @method('put')
                            {{ method_field('PUT') }}

                         <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Title</label>
                                    <input type="text"  name="title" class="@error('title') is-invalid @enderror form-control" >
                                    @error('title')
                                    <div class="alert alert-danger mt-1 mb-1">Enter Your Title Correct</div>
                                    @enderror

                            </div>

                  
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Description</label>
                                <input type="text"  name="description" class="@error('description') is-invalid @enderror form-control" >
                                @error('description')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Description</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Course</label>
                                    <select name="course_id" id="course_id" require>
                                        @foreach($courses as $course)
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                        @endforeach
                                    </select>
                                    

                            </div>
                            <!-- <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Price</label>
                                <input type="text"  name="price" class="@error('price') is-invalid @enderror form-control">
                                @error('price')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Price</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Description</label>
                                <input type="text"  name="description" class="@error('description') is-invalid @enderror form-control" >
                                @error('description')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Description</div>
                                @enderror
                            </div> -->


                            <!-- <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Location</label>
                                <input type="text"  name="location" class="@error('location') is-invalid @enderror form-control"  >
                                @error('location')
                                <div class="alert alert-danger mt-1 mb-1">Please Enter Your Location</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">rate</label>
                                <input type="text"  name="rate" class="@error('rate') is-invalid @enderror form-control"  >
                                @error('rate')
                                <div class="alert alert-danger mt-1 mb-1">Please Enter Your rate</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Image</label>
                                <input type="file"  name="name_img" placeholder="Choose file..." class="@error('file') is-invalid @enderror form-control"  >
                                @error('name_img')
                                <div class="alert alert-danger mt-1 mb-1">Pleace Enter Your Image</div>
                                @enderror
                            </div> -->
                            <button type="submit" class="btn btn-success">Save</button>
                            <a href="/lesson" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                   </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  @endsection