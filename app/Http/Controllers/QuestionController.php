<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
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
        return view('question.create', compact('courses' , 'exam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'question' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*.text' => 'required|string|max:255',
            'answers.*.correct' => 'sometimes|boolean',
        ]);

        $question = new Question();
        $question->exam_id = $validatedData['exam_id'];
        $question->question = $validatedData['question'];
        $question->user_id = Auth::id();
        $question->save();

        foreach ($validatedData['answers'] as $index => $answerData) {
            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->answer = $answerData['text'];
            $answer->correct = isset($answerData['correct']) ? 1 : 0;
            $answer->user_id = Auth::id();
            $answer->save();
        }

}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::findOrFail($id);
        $courses = Course::pluck('title', 'id')->prepend('Please select', '');
        
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
