@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
    <div class="col-lg-10 m-auto py-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Lesson</h4>
                </div>
                <div class="card-body">
                   <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('lesson.store')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                    <label for="exampleInputTitle" class="form-label">Title</label>
                                    <input type="text"  name="title" class="@error('title') is-invalid @enderror form-control" >
                                    @error('title')
                                    <div class="alert alert-danger mt-1 mb-1">Enter Your Title Correct</div>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputDescription" id="description" class="form-label">Description</label>
                                <input type="text" id="description" name="description" class="@error('description') is-invalid @enderror form-control summernote" >
                                @error('description')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Description</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                    <label for="exampleInputCourse" class="form-label">Course</label>
                                    <select name="course_id" id="course_id" require>
                                        @foreach($courses as $course)
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                        @endforeach
                                    </select>
                            </div>


                            <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image" accept="image/*" class="form-control">
    </div>
    
    <div class="form-group">
        <label for="files">Files</label>
        <input type="file" name="files" id="files" class="form-control" multiple="multiple" accept=".doc,.docx,.pdf,.ppt,.pptx">
    </div>
    <div class="form-group">
        <label for="videos">Videos</label>
        <input type="file" name="videos" id="videos" class="form-control" accept=".mp4, .mov, .ogg">
    </div>

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
  <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });
    </script>
  @endsection