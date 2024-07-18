<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::all()->sortByDesc('created_at');
        $exams = Exam::latest()->paginate(10);
        return view('exam.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('exam.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'duration' => 'required',
            'start_at' => 'required',
            'total_grade' => 'required',
            'pass_grade' => 'required',
            'user_id' => 'required',
            'course_id' => 'required',
        ]);

        $exam = new Exam();
        $exam->title = $request->title;
        $exam->duration = $request->duration;
        $exam->start_at = $request->start_at;
        $exam->total_grade = $request->total_grade;
        $exam->pass_grade = $request->pass_grade;
        $exam->user_id = $request->user_id;
        $exam->course_id = $request->course_id;
        $exam->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exams = Exam::find($id);
        return view('exam.show', compact('exams'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $exams = Exam::find($id);
        return view('exam.edit', compact('exams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'title' => 'required',
            'duration' => 'required',
            'start_at' => 'required',
            'total_grade' => 'required',
            'pass_grade' => 'required',
        ]);

        $exam = Exam::find($id);
        $exam->title = $request->title;
        $exam->duration = $request->duration;
        $exam->start_at = $request->start_at;
        $exam->total_grade = $request->total_grade;
        $exam->pass_grade = $request->pass_grade;
        $exam->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exam = Exam::find($id);
        $exam->delete();
        return redirect()->route('exam.index');
    }

    /*
    *
    */

    public function addQuestion(Request $request, $examId)
    {
        $question = Question::create([
            'exam_id' => $examId,
            'question_text' => $request->input('question_text'),
            'correct_answer' => $request->input('correct_answer'),
        ]);
    
        return redirect()->route('exam.show', ['examId' => $examId]);
    }

    /*
    *
    */
    public function startExam($examId)
    {
        $exam = Exam::with('questions')->find($examId);
        return view('exam.start', compact('exam'));
    }

    /*
    *
    */
    public function submitExam(Request $request, $examId)
    {
        $exam = Exam::with('questions')->find($examId);
        // Calculate the result based on the submitted answers (not implemented in this example)
    
        
        // For demonstration purposes, we are returning a success message
        return view('exam.submit', ['message' => 'Exam submitted successfully']);
    }

    public function takeExam(Request $request)
{
    // Logic to take the exam, calculate the result, and store the result in the database

    $result = 75; // Example result, calculate the actual result

    if ($result >= 80) {
        // User passed the exam
        // Send certificate via email
        // Redirect user to success page
    } else {
        // User failed the exam
        // Check if user has retake attempts left
        $retakeAttempts = $request->user()->retake_attempts ?? 0;

        if ($retakeAttempts < 3) {
            // User can retake the exam
            $request->user()->update(['retake_attempts' => $retakeAttempts + 1]);
            // Redirect user to retake exam page
        } else {
            // User has used all retake attempts
            // Redirect user to failure page
        }
    }
}
}
