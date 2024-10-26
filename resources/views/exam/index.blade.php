@extends('layouts.admin')  @section('content')

<h1>My Exams</h1>

<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Duration</th>
            <th>Start Time</th>
            <th>Total Grade</th>
            <th>Passing Grade</th>
            <th>Questions</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($exams as $exam)
            <tr>
                <td>{{ $exam->title }}</td>
                <td>{{ $exam->duration }} minutes</td>
                <td>{{ $exam->start_at }}</td>
                <td>{{ $exam->total_grade }}</td>
                <td>{{ $exam->passing_grade }}</td>
                <td>{{ $exam->questions->count() }} </td>
                <td>{{ $exam->created_at->format('Y-m-d H:i:s') }}</td>
                <td>
                    <a href="{{ route('exam.show', $exam->id) }}" class="btn btn-primary">View</a>
                    <a href="{{ route('exam.edit', $exam->id) }}" class="btn btn-warning">Edit</a> 

                    <form action="{{ route('exam.destroy', $exam->id) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this exam?')">Delete</button> 

                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<h2>Questions</h2>

<div class="questions-list">
    @foreach ($questions as $question)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $question->question }}</h5>
                <div>
                    <a href="{{ route('question.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('question.destroy', $question->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this question?')">Delete</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Answers:</h6>
                <form action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <ul class="list-group">
                        @foreach ($question->answers as $answer)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <input type="radio" name="correct_answer" id="answer_{{ $answer->id }}" value="{{ $answer->id }}" {{ $answer->correct ? 'checked' : '' }}>
                                    <label for="answer_{{ $answer->id }}">{{ $answer->answer }}</label>
                                </div>
                                @if ($answer->correct)
                                    <span class="badge badge-success">Correct</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <button type="submit" class="btn btn-primary btn-sm mt-2">Update Correct Answer</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Exams</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Duration</th>
                <th>Total Grade</th>
                <th>Passing Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exams as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->duration }} minutes</td>
                    <td>{{ $exam->total_grade }}</td>
                    <td>{{ $exam->passing_grade }}</td>
                    <td>
                        <a href="{{ route('exam.show', $exam->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('exam.edit', $exam->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('exam.destroy', $exam->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <a href="{{ route('exam.start', $exam->id) }}" class="btn btn-success">Start Exam</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $exams->links() }}
</div>
@endsection
