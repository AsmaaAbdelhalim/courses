@extends('layouts.admin')
@section('content')
    <h1>{{ $exam->title }}</h1>

    <p><strong>Duration:</strong> {{ $exam->duration }} minutes</p>
    <p><strong>Start Time:</strong> {{ $exam->start_at }}</p>
    <p><strong>Total Grade:</strong> {{ $exam->total_grade }}</p>
    <p><strong>Passing Grade:</strong> {{ $exam->passing_grade }}</p>
    //
    <h4>questions</h4>



    <div class="card">
        <div class="card-header">
    <p><strong>Passing Grade:</strong> {{ $exam->passing_grade }}</p>
            <h3 class="card-title" style="float:none;">{{ $exam->title }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <h3>{{$exam->title}}</h3>
            <div class="questions">
               
                        

            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->



<h1>{{ $exam->title }}</h1>

<div class="row">
    <div class="col-md-6">
        <ul>
            <li><strong>Start Date:</strong> {{ $exam->start_at }}</li>
            <li><strong>Duration:</strong> {{ $exam->duration }} minutes</li>
            <li><strong>Total Grade:</strong> {{ $exam->total_grade }}</li>
            <li><strong>Passing Grade:</strong> {{ $exam->passing_grade }}</li>
            <li><strong>Category:</strong> {{ $exam->category->name }}</li>
            <li><strong>Course:</strong> {{ $exam->course->name }}</li>
        </ul>
    </div>
</div>


    <h2>Questions</h2>


    @if($exam->questions->count() > 0)

        @foreach($exam->questions as $question)
            <li>
                <strong>Question:</strong> {{ $question->question }}

                @if ($question->image)
                    <img src="{{ asset('storage/' . $question->image) }}" alt="{{ $question->question }}" class="img-thumbnail">
                @endif

                @if ($question->video)
                    <iframe width="560" height="315" src="{{ $question->video }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 

                @endif 
                <ul>
                    
                @foreach($question->answers as $answer)
                <li>
                    <input type="radio" name="answer" value="{{ $answer->id }}" id="
                    {{ $answer->id }}" >
                     <label for="{{ $answer->id }}">{{ $answer->answer }}</label>
                     </li>
                     @endforeach
                </ul>
            </li>
        @endforeach
    @else
    <p>No questions found.</p>
    @endif

    <h1>exam</h1>
    <h2>questions</h2>
    <ul>
        @foreach($exam->questions as $question)
            <li>
                <strong>Question:</strong> {{ $question->question }}

                @if ($question->image)
                    <img src="{{ asset('storage/' . $question->image) }}" alt="{{ $question->question }}" class="img-thumbnail">
                @endif

                @if ($question->video)
                    <iframe width="560" height="315" src="{{ $question->video }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
                @endif 
                <ul>
                    @foreach($question->answers as $answer)
                        <li>{{ $answer->answer }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
    <h2>add question</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQuestionModal">
        Add Question
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionModalLabel">Add New Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('question.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="exam_id" value="{{ $exam->id }}">

                        <div class="form-group">
                            <label for="question">{{ __('Question') }}</label>
                            <input type="text" name="question" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="image">{{ __('Image') }}</label>
                            <input type="file" name="image" class="form-control-file">

                        </div>
                        <div class="form-group">
                            <label for="video">{{ __('Video') }}</label>
                            <input type="text" name="video" class="form-control">
                        </div>
                        <div id="answers">
        <div class="form-group answer-group">
            <label for="answer_0">Answer 1</label>
            <input type="text" class="form-control" id="answer_0" name="answers[0][text]" required>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="correct_0" name="answers[0][correct]" value="1">
                <label class="form-check-label" for="correct_0">Correct</label>
            </div>
        </div>
    </div>
    <button type="button" id="addAnswer"  class="btn btn-secondary mt-2">Add Answer</button>                     <button type="submit" class="btn btn-primary">Add Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

document.getElementById('addAnswer').addEventListener('click', function() {
        var answersDiv = document.getElementById('answers');
        var answerCount = answersDiv.children.length;
        var newAnswer = document.createElement('div');
        newAnswer.className = 'form-group answer-group';
        newAnswer.innerHTML = `
            <label for="answer_${answerCount}">Answer ${answerCount + 1}</label>
            <input type="text" class="form-control" id="answer_${answerCount}" name="answers[${answerCount}][text]" required>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="correct_${answerCount}" name="answers[${answerCount}][correct]" value="1">
                <label class="form-check-label" for="correct_${answerCount}">Correct</label>
            </div>
        `;
        answersDiv.appendChild(newAnswer);
    });
    </script>


    @endsection