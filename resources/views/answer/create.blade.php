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
                    <h1 class="h3 mb-0 text-gray-800">{{ __('create option') }}</h1>
                    <a href="{{ route('answer.index') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('Go Back') }}</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('answer.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="question">{{ __('question') }}</label>
                        <select class="form-control" name="question_id" id="question">
                            @foreach ($questions as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="answer_text">{{ __('answer text') }}</label>
                        <input type="text" class="form-control" id="answer_text" placeholder="{{ __('answer text') }}" name="answer_text" value="{{ old('answer_text') }}" />
                    </div>

                    <div class="form-group">
                        <label for="correct">{{ __('is correct') }}</label>
                        <input type="checkbox" class="form-control" id="is_correct" name="correct">
                        </div>

                    <button type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    

    <!-- Content Row -->

</div>
@endsection