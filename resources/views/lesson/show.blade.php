@extends('layouts.app')
@section('content')
<style>
      html {
         user-select: none;      
      }



@media print {
  html, body {
    display: none;
  }
}
   </style>


    <div class="container">
    <h1>{{ $course->name }} Course</h1>
    <h3>{{ $lesson->title }} Lesson</h3>
    <p>progress:{{ $progress }}%</p>
            <video width="800" height="400" controls
            src="{{ asset('videos/' . $lesson->videos) }}">
            </video>
            <h4>Lesson Description</h4>
            <p>{{ $lesson->description }}</p>

            <img class="img-fluid" style="height: 300px; width: 400px;" src="{{ asset('images/' . $lesson->image) }}">


            <div class="d-flex justify-content-between">
        @if ($previousLesson)
            <a href="{{ route('lesson', ['course_id' => $course->id, 'lesson_id' => $previousLesson->id]) }}" class="btn btn-primary">Previous Lesson</a>
        @endif

        @if ($nextLesson)
            <a href="{{ route('lesson', ['course_id' => $course->id, 'lesson_id' => $nextLesson->id]) }}" class="btn btn-primary">Next Lesson</a>
        @endif
            
</div><form action="" method="post">
                @csrf
                <button type="submit" class="btn btn-success">Mark Completed</button>
            </form>
    </div>

 <script>

document.addEventListener("visibilitychange", () => {
  if (document.hidden) {
    playingOnHide = !audio.paused;
    audio.pause();
  } else {
    // Resume playing if audio was "playing on hide"
    if (playingOnHide) {
      audio.play();
    }
  }
});

</script>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $course->title }}</h1>
    <h2>{{ $lesson->title }}</h2>

    <div class="progress mb-4">
        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ $progress }}%</div>
    </div>

    <div class="row">
        <div class="col-md-8">
            @if($lesson->videos)
                <video width="100%" controls>
                    <source src="{{ asset('videos/' . $lesson->videos) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif

            @if($lesson->image)
                <img src="{{ asset('images/' . $lesson->image) }}" alt="{{ $lesson->title }}" class="img-fluid mb-3">
            @endif

            <div class="lesson-description">
                {!! $lesson->description !!}
            </div>

            @if($lesson->files)
                <div class="mt-3">
                    <a href="{{ asset('files/' . $lesson->files) }}" class="btn btn-primary" download>Download Resources</a>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <h3>Course Lessons</h3>
            <ul class="list-group">
                @foreach($lessons as $lesson)
                    <li class="list-group-item {{ $lesson->id == $lesson->id ? 'active' : '' }}">
                    <a href="{{ route('lesson', ['course_id' => $course->id, 'lesson_id' => $lesson->id]) }}" class="text-decoration-none {{ $lesson->id == $lesson->id ? 'text-white' : 'text-dark' }}">
                    {{ $lesson->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-4">
        @if($previousLesson)
            <a href="{{ route('lesson', ['course_id' => $course->id, 'lesson_id' => $previousLesson->id]) }}" class="btn btn-secondary">Previous Lesson</a>
        @endif

        @if($nextLesson)
            <a href="{{ route('lesson', ['course_id' => $course->id, 'lesson_id' => $nextLesson->id]) }}" class="btn btn-primary float-right">Next Lesson</a>
        @endif
    </div>
</div>
@endsection