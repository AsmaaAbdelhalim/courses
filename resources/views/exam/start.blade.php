@extends('layouts.app')

@section('content')
    <h1>Start Exam: {{ $exam->title }}</h1>
    @foreach($exam->questions as $question)
        <p>{{ $question->question_text }}</p>
        <!-- Display question options here -->
    @endforeach
    <form method="post" action="{{ route('exam.submit', ['examId' => $exam->id]) }}">
        @csrf
        <!-- Include form inputs for submitting exam answers -->
        <button type="submit">Submit Exam</button>
    </form>
@endsection