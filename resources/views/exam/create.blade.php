@extends('layouts.app')

@section('content')
    <h1>Create Exam</h1>
    <form method="post" action="{{ route('exam.store') }}">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" id="title"><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description"></textarea><br>
        <label for="duration">duration</label>
        <input type="duration" name="duration" id="duration"><br>
        <button type="submit">Create Exam</button>
    </form>
@endsection