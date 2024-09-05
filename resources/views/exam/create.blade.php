

@extends('layouts.admin')  @section('content')
<h1>Create Exam</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{route('exam.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" class="form-control">  

    </div>

    <div class="form-group">
        <label  
 for="duration">Duration (minutes):</label>
        <input type="number" name="duration" id="duration" class="form-control">
    </div>

    <div class="form-group">
        <label for="start_at">Start Date and Time:</label>
        <input type="datetime-local" name="start_at" id="start_at" class="form-control">
    </div>

    <div class="form-group">
        <label for="end_at">End Date and Time:</label>
        <input type="datetime-local" name="end_at" id="end_at" class="form-control">
    </div>

    <div class="form-group">
        <label for="total_grade">Total Grade:</label>
        <input type="number" name="total_grade" id="total_grade" class="form-control">
    </div>

    <div class="form-group">
        <label for="passing_grade">Passing Grade:</label>
        <input type="number" name="passing_grade" id="passing_grade" class="form-control">
    </div>

    <div class="form-group">
        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" class="form-control">
            @foreach ($categories  
 as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="course_id">Course:</label>  

        <select name="course_id" id="course_id" class="form-control">
            @foreach ($courses  
 as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="lesson_id">Lesson:</label>
        <select name="lesson_id" id="lesson_id" class="form-control">
            @foreach ($lessons as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Create Exam</button>
</form>

@endsection