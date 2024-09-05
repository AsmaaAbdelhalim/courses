<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions_answers = Answer::all();
        return view('answer.index', compact('questions_answers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {        
        $questions = Question::get()->pluck('question_text', 'id')->prepend('Please select', '');
        return view('answer.create', compact('questions'));
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
                'question_id' => $request->input('question_id'),
                        'answer_text' => $request->input('answer_text'),
                        'correct' => $request->input('correct'),
                        'user_id' => Auth::user()->id, // Assuming you're using authentication
                    ]);                
                    $answer->save();  

    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        //$answer->load('question');

        $questions = Question::get()->pluck('question_text', 'id')->prepend('Please select', '');
        //$answer = Answer::findOrFail($id);

        return view('answer.show', compact('questions', 'answer'));

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
