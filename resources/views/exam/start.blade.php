@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $exam->title }}</h1>
    <p><strong>Duration:</strong> {{ $exam->duration }} minutes</p>
    <p><strong>Total Grade:</strong> {{ $exam->total_grade }}</p>
    <p><strong>Passing Grade:</strong> {{ $exam->passing_grade }}</p>

    <form action="{{ route('exam.submit', $exam->id) }}" method="POST">
        @csrf
        
        <h2>Questions</h2>
        @foreach ($questions as $question)
            <div class="mb-3">
                <p><strong>{{ $loop->iteration }}. {{ $question->question }}</strong></p>
                
                @foreach ($question->answers as $answer)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="answer{{ $answer->id }}" value="{{ $answer->id }}">
                        <label class="form-check-label" for="answer{{ $answer->id }}">
                            {{ $answer->answer }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Submit Exam</button>
    </form>
</div>
@endsection


@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $exam->title }} Exam</h1>
    <p>Time Remaining: {{ $exam->duration }} minutes<span id="time-remaining"></span></p>
    <form action="{{ route('result.store') }}" method="post">
        @csrf
        @foreach($questions as $index => $question)
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title">Question {{ $index + 1 }} :</h6>
                    <h5 class="card-text">{{ $question->question }}</h5>
                    @foreach($question->answers as $answer)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="answer{{ $answer->id }}" value="{{ $answer->id }}">
                            <label class="form-check-label" for="answer{{ $answer->id }}">
                                {{ $answer->answer }}
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
    // ... (timer script remains unchanged) 
</script>
@endpush
@endsection