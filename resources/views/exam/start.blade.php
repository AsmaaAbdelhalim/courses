@extends('layouts.app')

@section('content')
<style>
/* Your styles remain the same */
.timer-box {
    position: sticky; top: 10px; z-index: 1000;
    background: #fff3cd; border: 2px solid #ffc107;
    border-radius: 10px; padding: 15px; margin-bottom: 20px;
    font-size: 22px; font-weight: bold; text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
#timer { font-size: 28px; color: #000; }
.question-block.border-danger { border: 2px solid #dc3545 !important; }
</style>

<div class="container">
    <h2 class="mb-4">{{ $exam->title }}</h2>

    {{-- Note: It's better to pass $remainingAttempts from the Controller, but keeping your logic for now --}}
    <div class="alert alert-warning mb-3">
        Attempts Remaining: <strong>{{ $remainingAttempts }}</strong> / 3
    </div> 

    <div id="timer-box" class="timer-box">
        <strong>⏱ Time Left:</strong>
        <span id="timer" class="fw-bold fs-5">00:00</span>
    </div>

    <input type="hidden" id="exam-duration" value="{{ $exam->duration ?? 10 }}">

    <form id="examForm" action="{{ route('exam.submit', $exam->id) }}" method="POST">
        @csrf
        @foreach($questions as $index => $question)
            <div class="card mb-4 question-block">
                <div class="card-body">
                    <h6 class="text-muted">Question {{ $index + 1 }}</h6>
                    <h5 class="mb-3">{{ $question->question }}</h5>

                    @foreach($question->answers as $answer)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}">
                            <label class="form-check-label">{{ $answer->answer }}</label>
                        </div>
                    @endforeach

                    <div class="text-danger small error-msg mt-2" style="display:none;">
                       <strong>Please select an answer</strong>
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary w-100">Submit Exam</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let form = document.getElementById('examForm');
    let examId = "{{ $exam->id }}"; // Get the specific exam ID
    let duration = parseInt(document.getElementById('exam-duration').value) * 60;

    // FIX: Unique key for each exam so timers don't clash
    let storageKey = `exam_end_time_${examId}`;
    let endTime = localStorage.getItem(storageKey);

    if (!endTime) {
        endTime = Date.now() + duration * 1000;
        localStorage.setItem(storageKey, endTime);
    }

    let timerElement = document.getElementById('timer');
    let interval = setInterval(function () {
        let remaining = Math.floor((endTime - Date.now()) / 1000);

        if (remaining <= 0) {
            clearInterval(interval);
            timerElement.innerHTML = "00:00";
            localStorage.removeItem(storageKey);
            alert('⛔ Time is over!');
            form.submit();
            return;
        }

        let minutes = String(Math.floor(remaining / 60)).padStart(2, '0');
        let seconds = String(remaining % 60).padStart(2, '0');
        timerElement.innerHTML = minutes + ':' + seconds;

        if (remaining < 60) {
            timerElement.style.color = 'red';
        }
    }, 1000);

    form.addEventListener('submit', function(e) {
        let valid = true;
        document.querySelectorAll('.question-block').forEach(q => {
            let checked = q.querySelector('input[type="radio"]:checked');
            let error = q.querySelector('.error-msg');

            if (!checked) {
                valid = false;
                error.style.display = 'block';
                q.classList.add('border-danger');
            } else {
                error.style.display = 'none';
                q.classList.remove('border-danger');
            }
        });

        if (!valid) {
            e.preventDefault();
        } else {
            localStorage.removeItem(storageKey);
        }
    });
});
</script>
@endsection