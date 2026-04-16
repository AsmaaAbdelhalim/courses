@extends('layouts.admin')

@section('content')
<h1>Edit Exam</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('exam.update', $exam->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Title:</label>
        <input type="text" name="title" class="form-control"
               value="{{ old('title', $exam->title) }}">
    </div>

    <div class="form-group">
        <label>Duration:</label>
        <input type="number" name="duration" class="form-control"
               value="{{ old('duration', $exam->duration) }}">
    </div>

    <div class="form-group">
        <label>Start:</label>
        <input type="datetime-local" name="start_at" class="form-control"
               value="{{ old('start_at', $exam->start_at) }}">
    </div>

    <div class="form-group">
        <label>End:</label>
        <input type="datetime-local" name="end_at" class="form-control"
               value="{{ old('end_at', $exam->end_at) }}">
    </div>

    <div class="form-group">
        <label>Total Grade:</label>
        <input type="number" name="total_grade" class="form-control"
               value="{{ old('total_grade', $exam->total_grade) }}">
    </div>

    <div class="form-group">
        <label>Passing Grade:</label>
        <input type="number" name="passing_grade" class="form-control"
               value="{{ old('passing_grade', $exam->passing_grade) }}">
    </div>

    <div class="form-group">
        <label>Category:</label>
        <select name="category_id" class="form-control">
            @foreach ($categories as $key => $value)
                <option value="{{ $key }}"
                    {{ old('category_id', $exam->category_id) == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Course:</label>
        <select name="course_id" class="form-control">
            @foreach ($courses as $key => $value)
                <option value="{{ $key }}"
                    {{ old('course_id', $exam->course_id) == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Lesson:</label>
        <select name="lesson_id" class="form-control">
            @foreach ($lessons as $key => $value)
                <option value="{{ $key }}"
                    {{ old('lesson_id', $exam->lesson_id) == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Update Exam</button>
</form>

@endsection