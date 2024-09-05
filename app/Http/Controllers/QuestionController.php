<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::all(); 
        return view('question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
            $courses = Course::where('user_id', Auth::user()->id)->pluck('name', 'id')->prepend('Please select', '');
            $exam = Exam::where('user_id', Auth::user()->id)->pluck('title', 'id')->prepend('Please select', '');

        $correct_options = [
            'option1' => 'Option #1',
            'option2' => 'Option #2',
            'option3' => 'Option #3',
            'option4' => 'Option #4',
            'option5' => 'Option #5'
        ];

        return view('question.create', compact(['correct_options'] , 'courses' , 'exam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
           
            'question' => 'required|string',
            //'image' => 'nullable|image',
            //'video' => 'nullable|string',
            //'level' => 'nullable|string',
            'duration' => 'nullable|integer',
            'total_grade' => 'nullable|integer',
            'passing_grade' => 'nullable|integer',

            //'answers' => 'required',
            //'answers.*.answer_text' => 'required|string',
            //'correct' => 'required',
        ]);
        

        $question = new Question();
        $question->question = $validatedData['question'];
        //$question->image = $validatedData['image'];
        //$question->video = $validatedData['video'];
        //$question->level = $validatedData['level'];
        //$question->duration = $validatedData['duration'];
        //$question->total_grade = $validatedData['total_grade'];
        //$question->passing_grade = $validatedData['passing_grade'];
        //$question->correct_option = $validatedData['correct_option'];
        $question->course_id = $request->course_id;
        $question->exam_id = $request->exam_id;
        $question->user_id = Auth::user()->id;
        $question->save();

        // $answers = $request->input('answers', []);
        // foreach ($answers as $answerData) {
        //     $question->answers()->create([
        //         'answer_text' => $answerData['answer_text'],
        //         'correct' => $answerData['correct'],
        //         'user_id' => Auth::user()->id, // Assuming you're using authentication
        //     ]);
        // } 
        //     foreach ($validatedData['answers'] as $answerData) {
        //     $question->answers()->create([
        //         'answer' => $answerData['answer_text'],
        //         'correct' => $answerData['correct'],
        //         'user_id' => Auth::user()->id
        //     ]);
        // }

        //$question = $validatedData['exam']->questions()->create($validatedData);

        //foreach ($validatedData['answers'] as $answerData) {
        //    $question->answers()->create($answerData);
        //}
        return redirect()->route('question.index')->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
            $courses = Course::get()->pluck('title', 'id')->prepend('Please select', '');
      

        $question = Question::findOrFail($id);

        return view('question.show', compact('question','courses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
