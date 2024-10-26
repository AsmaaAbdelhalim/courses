<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Course;
use App\Models\Course_user;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::withCount('questions')->latest()->paginate(10);
        $questions = Question::inRandomOrder()->limit(10)->get();

        foreach ($questions as $question) {
            $question->options = Answer::where('question_id', $question->id)->inRandomOrder()->get();
       

          //  $exams = Exam::withCount('questions')->latest()->paginate(10);
        //$questions = Question::inRandomOrder()->limit(10)->get()->each(function ($question) {
          //  $question->options = Answer::where('question_id', $question->id)->inRandomOrder()->get();
        //});

    //     $questions = Question::inRandomOrder()->limit(10)->get();
    //     foreach ($questions as &$question) {
    //     $question->options = Question::where('id', $question->id)->inRandomOrder()->get();
    //     }



    //         // Retrieve exams with their question count, paginated
    // $exams = Exam::withCount('questions')->latest()->paginate(10);
    
    // // Retrieve 10 random questions
    // $questions = Question::inRandomOrder()->limit(10)->get();
    
    // // Attach random options to each question
    // foreach ($questions as &$question) {
    //     $question->options = Answer::where('question_id', $question->id)->inRandomOrder()->get();
     }   


       return view('exam.index', compact('questions', 'exams'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = Auth::id();
        $courses = Course::where('user_id', $userId)->pluck('name', 'id')->prepend('Please select', '');
        $lessons = Lesson::whereIn('course_id', $courses->keys())->pluck('title', 'id')->prepend('Please select', '');
        $categories = Category::where('user_id', $userId)->pluck('name', 'id')->prepend('Please select', '');
        return view('exam.create', compact('courses', 'lessons', 'categories'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExamRequest $request)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'required',
            'start_at' => 'required',
            'total_grade' => 'required',
            'passing_grade' => 'required',
            'course_id' => 'required',
        ]);

        $exam = new Exam();
        $exam->title = $request->title;
        $exam->duration = $request->duration;
        $exam->start_at = $request->start_at;
        $exam->total_grade = $request->total_grade;
        $exam->passing_grade = $request->passing_grade;
        $exam->user_id = Auth::id();
        $exam->course_id = $request->course_id;
        $exam->category_id = $request->category_id;
        $exam->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        //$exam->load('questions');
        return view('exam.show', compact('exam'));
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
    public function update(UpdateExamRequest $request, string $id)
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
        $exam->end_at = $request->end_at;
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

    /*
    *
    */

    public function startExam($examId)
    {
        $exam = Exam::with('questions')->findOrFail($examId);
        $user = Auth::user();

        if (!$this->canUserStartExam($user, $exam)) {
            return redirect()->back()->with('error', 'You cannot start this exam yet. Please complete the course first.');
        }

            // Check if the user has already passed this exam
        $passedResult = Result::where('user_id', $user->id)
        ->where('exam_id', $exam->id)
        ->where('passed', true)
        ->first();
        if ($passedResult) {
            return redirect()->route('exam.index')->with('error', 'You have already passed this exam.');
        }
        // Check the number of attempts
        $attempts = Result::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->count();

        if ($attempts >= 3) {
            return redirect()->route('exam.index')->with('error', 'You have reached the maximum number of attempts for this exam.');
        }
        $questions = $exam->questions()->inRandomOrder()->get();

        return view('exam.start', compact('exam', 'questions'));
    }

    private function canUserStartExam($user, $exam)
    {
        //$course = $exam->course;
        $courseUser = Course_user::where('user_id', $user->id)
            //->where('course_id', $course->id)
            ->where('course_id', $exam->course_id)
            ->first();
        return $courseUser && $courseUser->completed;
    }
}
