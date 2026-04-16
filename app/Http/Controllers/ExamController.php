<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\SubmitExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{       
    protected $maxAttempts = 3;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::withCount('questions')->latest()->paginate(10);
        return view('exam.index', compact('exams'));
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
        Exam::create($request->validated());
        return redirect()->route('exam.index')->with('success', 'Exam created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        $course = $exam->course;
        return view('exam.show', compact('exam', 'course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $userId = Auth::id();
        $courses = Course::where('user_id', $userId)->pluck('name', 'id')->prepend('Please select', '');
        $lessons = Lesson::whereIn('course_id', $courses->keys())->pluck('title', 'id')->prepend('Please select', '');
        $categories = Category::where('user_id', $userId)->pluck('name', 'id')->prepend('Please select', '');

        return view('exam.edit', compact('exam'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $exam->update($request->validated());
        return redirect()->route('exam.index')->with('success', 'Exam updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
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
        $exam = Exam::withCount('questions')->findOrFail($examId);
        $user = Auth::user();

        $redirect = $this->checkExamEligibility($user, $exam);
        if ($redirect) return $redirect;

        $attemptsCount = Result::where('user_id', $user->id)->where('exam_id', $examId)->count();
        $remainingAttempts = $this->maxAttempts - $attemptsCount;

        session()->forget("exam_{$examId}_submitted");

        $questions = $exam->questions()->with('answers')->inRandomOrder()->get();

        return view('exam.start', compact('exam', 'questions', 'remainingAttempts'));
    }
 
    public function submitExam(SubmitExamRequest $request, $examId)
    {
        $exam = Exam::with('questions.answers')->findOrFail($examId);
        $user = Auth::user();

        // 1. Security Guard
        $redirect = $this->checkExamEligibility($user, $exam, $request);
        if ($redirect) return $redirect;

        // 2. Calculation Logic
        $studentAnswers = $request->validated()['answers'];
        $correctCount = 0;
        $totalQuestions = $exam->questions->count();

        foreach ($exam->questions as $question) {
            $correctId = $question->answers->firstWhere('correct', 1)?->id;
            if (isset($studentAnswers[$question->id]) && $studentAnswers[$question->id] == $correctId) {
                $correctCount++;
            }
        }

        $score = ($totalQuestions > 0) ? round(($correctCount / $totalQuestions) * $exam->total_grade) : 0;
        $passed = $score >= $exam->passing_grade;

        // 3. Database Transaction
        return DB::transaction(function () use ($user, $exam, $score, $correctCount, $passed, $request) {
            $attempts = Result::where('user_id', $user->id)->where('exam_id', $exam->id)->count();

            $result = Result::create([
                'user_id'         => $user->id,
                'exam_id'         => $exam->id,
                'score'           => $score,
                'correct_answers' => $correctCount,
                'attempts'        => $attempts + 1,
                'passed'          => $passed,
                'certificate'     => $passed,
                'code'            => $passed ? strtoupper(uniqid('CERT-')) : null,
            ]);

            $request->session()->put("exam_{$exam->id}_submitted", true);

            return redirect()->route('result.show', $result->id)
                ->with($passed ? 'success' : 'error', $passed ? 'You passed! 🎉' : 'Try again! 💪');
        });
    }

    private function checkExamEligibility($user, $exam, $request = null)
    {
        if ($user->courseProgress($exam->course_id) < 100) {
            return redirect()->route('course.show', $exam->course_id)->with('error', 'Complete course first.');
        }

        // Optimized DB Check
        $results = Result::where('user_id', $user->id)->where('exam_id', $exam->id)->get();
        $attempts = $results->count();
        $lastResult = $results->sortByDesc('created_at')->first();
        $hasPassed = $results->where('passed', true)->isNotEmpty();

        if ($hasPassed) {
            return redirect()->route('result.show', $lastResult->id)->with('info', 'Already passed.');
        }

        if ($attempts >= $this->maxAttempts) {
            return redirect()->route('result.show', $lastResult->id)->with('error', 'Max attempts reached.');
        }

        if ($request && $request->session()->has("exam_{$exam->id}_submitted")) {
            return redirect()->route('result.show', $lastResult?->id ?? 0)->with('error', 'Already submitted.');
        }

        return null;
    }
}