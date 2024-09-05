@extends('layouts.admin')

@section('content')
    <div class="container">
    <div class="row">
    <div class="col-lg-10 m-auto py-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add course</h4>
                </div>
                <div class="card-body">
                   <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('course.store')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
    <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
    </div> 
    <div class="form-group">
        <label for="exampleInputCategory" class="form-label">Category</label>
        <select name="category_id" class="form-select" aria-label="Default select example">
        @foreach($categories as $category)
        <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
        </select>
    </div> 
    <div class="form-group">
        <label for="exampleInputTeachers" class="form-label">Teachers</label>
        <select name="teacher_id" class="form-select" aria-label="Default select example">
        @foreach($teachers as $teacher)
        <option value="{{$teacher->id}}">{{$teacher->first_name}}</option>
        @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="0" class="form-control">
    </div>
    <div class="form-group">
        <label for="discount">Discount</label>
        <input type="number" name="discount" id="discount" value="0" class="form-control">
    </div>
    <div class="form-group">
        <label for="code">Code</label>
        <input type="text" name="code" id="code" class="form-control">
    </div>
    <div class="form-group" >
        <label for="description" id="description">Description</label>
         <textarea id="description" name="description" class="form-control summernote"></textarea>
    </div>
    <div class="form-group">
        <label for="summary">Summary</label>
        <textarea name="summary" id="summary" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="requirement">Requirement</label>
        <textarea name="requirement" id="requirement" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label for="numOfHours">Number of Hours</label>
        <input type="number" name="numOfHours" id="numOfHours" class="form-control">
    </div>
    <div class="form-group">
        <label for="started_at">Started At</label>
        <input type="datetime-local" name="started_at" id="started_at" class="form-control">
    </div>
    <div class="form-group">
        <label for="finished_at">Finished At</label>
        <input type="datetime-local" name="finished_at" id="finished_at" class="form-control">
    </div>
    <div class="form-group">
        <label for="duration">Duration</label>
        <input type="text" name="duration" id="duration" class="form-control">
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
    <div class="form-group">
        <label for="session">Session</label>
        <textarea name="session" id="session" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Create Course</button>
    <a href="/course" class="btn btn-danger">Cancel</a>
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