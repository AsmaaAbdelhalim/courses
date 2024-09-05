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
//////////////////////////

<h2>Questions</h2>

<table class="table">
    <thead>
        <tr>
            <th>Question</th>
            <th>Options</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($questions as $question)
            <tr>
                <td>{{ $question->question }}</td>
                <td>
                    <ul>
                        @foreach ($question->options as $option)
                            <li>{{ $option->option }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ route('question.edit', $question->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('question.destroy', $question->id) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button 
 type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this question?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table> 




@endsection