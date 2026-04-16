<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResultRequest;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Exam;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $result = Result::with('exam.course')->findOrFail($id);
        $result = Result::find($id);
        $user = Auth::user();
        $exam = Exam::find($result->exam_id);
        $course = Course::find($exam->course_id);
        return view('result.show', compact('result','user','exam','course'));
    }
}