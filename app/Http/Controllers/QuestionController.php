<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
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
        return view('question.create', compact('courses' , 'exam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $validatedData = $request->validated();
        return DB::transaction(function () use ($validatedData) {
            $question = Question::create($validatedData);
            foreach ($validatedData['answers'] as $answer) {
                $question->answers()->create([
                    'answer'  => $answer['answer'],
                    'correct' => !empty($answer['correct']),
                    'user_id' => auth()->id(),
                ]);
            }
            $question->load('answers');
            $html = view('exam.partials.question', compact('question'))->render();
            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        });
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
    public function edit(Question $question)
    {
      //$question = Question::with('answers')->findOrFail($id);
        return response()->json([
            'success' => true,
            'question' => $question->load('answers')
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $validated = $request->validated();
        return DB::transaction(function () use ($validated, $question) {
            $question->update($validated);
            $question->answers()->delete();
            foreach ($validated['answers'] as $ans) {
                $question->answers()->create([
                    'answer'  => $ans['answer'],
                    'correct' => !empty($ans['correct']),
                    'user_id' => auth()->id()
                ]);
            }
            $question->load('answers');
            $html = view('exam.partials.question', compact('question'))->render();
            return response()->json([
                'success' => true, 
                'html'    => $html
            ]);
        });
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(['success' => true]);
    }
}