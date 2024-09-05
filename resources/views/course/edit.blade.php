@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
    <div class="col-lg-10 m-auto py-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Course</h4>
                </div>
                <div class="card-body">
                   <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('course.update',[$course->id])}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{method_field('PUT')}} 
                            <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Name</label>
                                    <input type="text"  name="name" class="@error('name') is-invalid @enderror form-control" value="{{$course->name}}">
                                    @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">Enter Your Name Correct</div>
                                    @enderror
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
                                <label for="exampleInputPrice" class="form-label">Price</label>
                                <input type="text"  name="price" class="@error('price') is-invalid @enderror form-control"value="{{$course->price}}">
                                @error('price')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Price</div>
                                @enderror
                            </div>
                            <div class="form-group">
                            <label for="exampleInputDiscount" class="form-label">Discount</label>
                                <input type="text"  name="price" class="@error('discount') is-invalid @enderror form-control"value="{{$course->discount}}">
                                @error('discount')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Discount</div>
                                @enderror
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputCode" class="form-label">Code</label>
                                <input type="text"  name="code" class="@error('code') is-invalid @enderror form-control"value="{{$course->code}}">
                                @error('code')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Code</div>
                                @enderror
                            </div>

                            <div class="form-group">
                            <label for="exampleInputSummary" class="form-label">Summary</label>
                                <input type="text"  name="summary" class="@error('summary') is-invalid @enderror form-control"value="{{$course->summary}}">
                                @error('summary')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Summary</div>
                                @enderror
                            </div>
                            <label for="exampleInputRequirement" class="form-label">Requirement</label>
                                <input type="text"  name="requirment" class="@error('requirement') is-invalid @enderror form-control"value="{{$course->requirement}}">
                                @error('requirement')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Requirement</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDescription" class="form-label">Description</label>
                                <input type="text"  name="description" class="@error('description') is-invalid @enderror form-control" value="{{$course->description}}">
                                @error('description')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Description</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputImage" class="form-label">Image</label>
                                <input type="file"  name="image" class="@error('image') is-invalid @enderror form-control" value="{{$course->image}}">
                                @error('image')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Image</div>
                                @enderror
                            </div>
   

                            <div class="form-group">
                                <label for="exampleInputNumOfHours" class="form-label">Number of Hours</label>
                                <input type="number" name="numOfHours" class="@error('numOfHours') is-invalid @enderror form-control" id="exampleInputNumOfHours" value="{{$course->numOfHours}}">
                                @error('numOfHours')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Number Of Hours</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputStarted_at" class="form-label">Started At</label>
                                <input type="datetime-local" name="started_at" class="@error('started_at') is-invalid @enderror form-control" id="exampleInputStarted_at" value="{{$course->started_at}}">
                                @error('started_at')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Started At</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFinished_at" class="form-label">Finished At</label>
                                <input type="datetime-local" name="finished_at" class="@error('finished_at') is-invalid @enderror form-control" id="exampleInputFinished_at" value="{{$course->finished_at}}">
                                @error('finished_at')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Finished At</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDuration" class="form-label">Duration</label>
                                <input type="text" name="duration" class="@error('duration') is-invalid @enderror form-control" id="exampleInputDuration" value="{{$course->duration}}">
                                @error('duration')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Duration</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputRate" class="form-label">Rate</label>
                                <input type="text" name="rate" class="@error('rate') is-invalid @enderror form-control" id="exampleInputRate" value="{{$course->rate}}">
                                @error('rate')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Rate</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <lable for="exampleInputFiles">Files</label>
                                <input type="file" name="files[]" multiple class="@error('files') is-invalid @enderror form-control" id
                                    ="exampleInputFiles">
                                @error('files')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Files</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputVideos">Videos</label>
                                <input type="file" name="videos[]" multiple class="@error('videos') is-invalid @enderror form-control" id
                                    ="exampleInputVideos">
                                @error('videos')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Videos</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputSession">Session</lable>
                                <input type="text" name="session" class="@error('session') is-invalid @enderror form-control" id="example
                                    InputSession">
                                @error('session')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Session</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCategory">Category</label>
                                <input type="text" name="category" class="@error('category') is-invalid @enderror form-control" id="example
                                    InputCategory">
                                @error('category')

                                <div class="alert alert-danger mt-1 mb-1">Enter Your Category</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputLessons">Lessons</label>
                                <input type="text" name="lessons" class="@error('lessons') is-invalid @enderror form-control" id="example
                                    InputLessons">
                                @error('lessons')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Lessons</div>
                                @enderror
                            </div>                  
                            <button type="submit" class="btn btn-success">Update</button>
                            <!-- //<a href="/custhotel" class="btn btn-danger">Cancel</a> -->
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
