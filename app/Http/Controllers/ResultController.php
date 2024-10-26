<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $results = Result::where('user_id', $user->id)->get();
        return view('result.index', compact('results','user'));
        }
    public function show($id)
    {
        $result = Result::find($id);
        $user = Auth::user();
        return view('result.show', compact('result'));
    }

    public function submitExam(Request $request, $examId)
    {
        $exam = Exam::with('questions.answers')->findOrFail($examId);
        $user = Auth::user();

        // Check if the user has already passed this exam
        $existingResult = Result::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->where('passed', true)
            ->first();

        if ($existingResult) {
            return redirect()->route('exam.index')->with('error', 'You have already passed this exam.');
        }

        // Check the number of attempts
        $attempts = Result::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->count();

        if ($attempts >= 3) {
            return redirect()->route('exam.index')->with('error', 'You have reached the maximum number of attempts for this exam.');
        }

        // Process the exam
        $studentAnswers = $request->input('answers');
        $correctAnswers = 0;
        $totalQuestions = $exam->questions->count();

        foreach ($exam->questions as $question) {
            $correctAnswer = $question->answers->where('correct', 1)->first();
            if (isset($studentAnswers[$question->id]) && $studentAnswers[$question->id] == $correctAnswer->id) {
                $correctAnswers++;
            }
        }

        $score = ($correctAnswers / $totalQuestions) * 100;
        $passed = $score >= $exam->passing_grade;

        // Create the result
        $result = Result::create([
            'user_id' => $user->id,
            'exam_id' => $exam->id,
            'score' => $score,
            'correct_answers' => $correctAnswers,
            'passed' => $passed,
        ]);

        if ($passed) {
            return $this->generateCertificate($result);
        }

        return redirect()->route('exam.index')->with('info', 'Exam submitted. Your score: ' . $score . '%');
    }

    private function generateCertificate($result)
    {
        // Generate a certificate PDF
        // $pdf = \App\Models\Result::make('dompdf.wrapper');
        // $pdf->loadView('certificates.exam-passed', ['result' => $result]);
        // $pdf->save('certificates/' . $result->id . '.pdf');
            // Logic to generate or retrieve the certificate
    // This could be a PDF generation or a view that displays the certificate
            $user = Auth::user();
            $exam = $result->exam;
            $course = $exam->course;

            return view('result.show', compact('user', 'exam', 'result', 'course'));
       // return response()->download('certificates/' . $result->id . '.pdf');
    }
}