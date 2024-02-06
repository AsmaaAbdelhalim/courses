@extends('layouts.app')

@section('content')
{{ $enrollment->course->name }}
@foreach($lessons as $lesson)
<li style="color:{{ in_array($lesson->id , $completedLessons) ? 'green' : 'red' }}">
{{ $lesson->title }}
</li>
@endforeach



@endsection