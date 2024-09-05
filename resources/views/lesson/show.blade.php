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
