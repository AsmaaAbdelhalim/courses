<!-- Display course information -->
<h2>{{ $course->title }}</h2>
<p>{{ $course->description }}</p>

<!-- Display lessons -->
@if ($lessons->count() > 0)
    <h3>Lessons</h3>
    <ul>
        @foreach ($lessons as $lesson)
            <li>{{ $lesson->title }}</li>
        @endforeach
    </ul>
@else
    <p>No lessons found for this course.</p>
@endif
