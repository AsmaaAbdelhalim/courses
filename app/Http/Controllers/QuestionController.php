<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;

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
        Log::info($request->validated());
        $question = Question::create([
            'exam_id' => $request->validated('exam_id'),
            'course_id' => $request->validated('course_id'),
            'question' => $request->validated('question'),
            'image' => $request->validated('image'),
            'video' => $request->validated('video'),
            'user_id' => Auth::id()
        ]);
        foreach ($request->answers as $answerData) {
            Answer::create([
                'exam_id' => $request->validated('exam_id'),
                'course_id' => $request->validated('course_id'),
                'question_id' => $question->id,
                'answer' => $answerData['answer'],
                'correct' => isset($answerData['correct']) ? 1 : 0,
                'user_id' => Auth::id()
            ]);
        }
        if($request->hasfile('image'))
        {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
            $question->image = $filename;
            $question->save();
            Storage::delete($question->video);
            }
            if($request->hasfile('video'))
            {
                $video = $request->file('video');
                $filename = time().'.'.$video->getClientOriginalExtension();
                $video->move(public_path('videos'), $filename);
                $question->video = $filename;
                $question->save();
                Storage::delete($question->image);
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
