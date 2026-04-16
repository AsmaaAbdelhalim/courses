@extends('layouts.admin')

@section('content')

<br><br>

<h1 class="m-0 text-white display-4 text-center">
<span class="text-danger">Exams</span>
</h1>

<a href="{{ route('exam.create') }}" class="btn btn-primary btn-lg m-2">
Add Exam
</a>

<div class="container">

<div class="row">

<div class="col-lg-10 m-auto py-2">

<table class="table table-bordered text-center">

<thead>

<tr>

<th>ID</th>

<th>Title</th>

<th>Course</th>

<th>Category</th>

<th>Duration</th>

<th>Total Grade</th>

<th>Passing Grade</th>

<th>Questions</th>

<th>Created By</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

@foreach($exams as $exam)

<tr>

<td>{{ $exam->id }}</td>

<td>{{ $exam->title }}</td>

<td>{{ $exam->course->name ?? '-' }}</td>

<td>{{ $exam->course->category->name ?? '-' }}</td>

<td>{{ $exam->duration }} min</td>

<td>{{ $exam->total_grade }}</td>

<td>{{ $exam->passing_grade }}</td>

<td>{{ $exam->questions->count() }}</td>

<td>{{ $exam->user->first_name ?? '-' }}</td>

<td>

<a href="{{ route('exam.show',$exam->id) }}" class="btn btn-info btn-sm">
Details
</a>

<a href="{{ route('exam.edit',$exam->id) }}" class="btn btn-primary btn-sm">
Edit
</a>

<form action="{{ route('exam.destroy',$exam->id) }}" method="POST" class="d-inline">

@csrf
@method('DELETE')

<button type="submit" class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

@endsection