@extends('layouts.app')

@section('content')
    <h1>Exam Submission</h1>
    <p>{{ $message }}</p>
<div class="container">
    <h1 class="mb-4">{{ $exam->title }}</h1>
    <p>Time Remaining: <span id="time-remaining"></span></p>
    
    <form action="{{ route('exams.submit', $exam->id) }}" method="POST">
        @csrf
        @foreach($exam->questions as $index => $question)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Question {{ $index + 1 }}</h5>
                    <p class="card-text">{{ $question->question_text }}</p>
                    @foreach($question->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="option{{ $option->id }}" value="{{ $option->id }}" required>
                            <label class="form-check-label" for="option{{ $option->id }}">
                                {{ $option->option_text }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit Exam</button>
    </form>
</div>

@push('scripts')
<script>

</script>
@endpush
@endsection