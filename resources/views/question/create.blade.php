@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<!-- Content Row -->
        <div class="card shadow">
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">{{ __('create question') }}</h1>
                    <a href="{{ route('question.index') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('Go Back') }}</a>
                </div>
            </div>
            <div class="card-body">
            <form action="{{ route('question.store') }}" method="POST">

@csrf

<div class="form-group">
    <label for="course_id">Course:</label>
    <select name="course_id" id="course_id" class="form-control" required>
        @foreach ($courses as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="exam_id">Exam:</label>
    <select name="exam_id" id="exam_id" class="form-control" required>
        @foreach ($exam as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="question">Question:</label>
    <textarea name="question" id="question" class="form-control"
required></textarea>
</div>
    <button type="submit" class="btn btn-primary">Create Question</button>
</form>
               
            </div>
        </div>
    

    <!-- Content Row -->

</div>
@endsection