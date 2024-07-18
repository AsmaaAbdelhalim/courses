<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Question::all()->pluck('question_text', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('answers.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'answer_text' => 'required',
            ]);
            $answer = Answer::create([
                'question_id' => $request->question_id,
                'answer_text' => $request->answer_text,
                ]);
                return redirect()->route('answers.index')
                ->with('success', trans('global.answerCreated'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        $answer->load('question');
        return view('answers.show', compact('answer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
