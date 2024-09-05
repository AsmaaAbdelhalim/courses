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
            <li><strong>Category:</strong> {{ $exam->category }}</li>
            <li><strong>Course:</strong> {{ $exam->course }}</li>
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
                     <label for="{{ $answer->id }}">{{ $answer->answer_text }}</label>
                     </li>
                     @endforeach
                </ul>
            </li>
        @endforeach
    @else
    <p>No questions found.</p>
    @endif

@endsection