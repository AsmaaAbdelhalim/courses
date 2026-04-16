@extends('layouts.admin')

@section('content')

<br><br>

<h1 class="m-0 text-white display-4 text-center">
    <span class="text-danger">Results</span>
</h1>

<div class="container">
<div class="row">
<div class="col-lg-12 m-auto py-2">

<table class="table table-bordered text-center">
<thead>
<tr>
    <th>ID</th>
    <th>Student</th>
    <th>Course</th>
    <th>Exam</th>
    <th>Score</th>
    <th>Percentage</th>
    <th>Status</th>
    <th>Attempts</th>
    <th>Date</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>
@foreach($results as $result)
<tr>
    <td>{{ $result->id }}</td>

    <td>{{ $result->user->first_name }} {{ $result->user->last_name }}</td>

    <td>{{ $result->exam->course->name }}</td>

    <td>{{ $result->exam->title }}</td>

    <td>
        {{ $result->score }} /
        {{ $result->exam->total_grade }}
    </td>

    <td>

    @php
    $exam = $result->exam;
    $percentage = $exam->total_grade > 0
        ? round(($result->score / $exam->total_grade) * 100, 2)
        : 0;
@endphp

<p>{{ $percentage }}%</p>
    </td>

    <td>
        @if($result->passed)
            <span class="badge bg-success">Passed</span>
        @else
            <span class="badge bg-danger">Failed</span>
        @endif
    </td>

    <td>{{ $result->attempts }}</td>

    <td>{{ $result->created_at->format('Y-m-d') }}</td>

    <td>
        <a href="{{ route('result.show', $result->id) }}"
           class="btn btn-info btn-sm">
           View
        </a>

        @if($result->passed)
        <a href="{{ route('certificate.download', $result->id) }}"
           class="btn btn-success btn-sm">
           <i class="fas fa-download"></i>
           Download Certificate
        </a>
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>

</div>
</div>
</div>

@endsection