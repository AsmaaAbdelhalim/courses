<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments =Enrollment::all();
        return view('enrollment.index',['data' => $enrollments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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




   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    // public function destroy(string $id)
    // {
    //     //
    // }

    public function enroll(Course $course)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to enroll in courses.');
        }

        // Check if the user is enrolled in the course
        // Enroll the user in the course
        if ($course->price > 0 && !$course->isEnrolledByUser(Auth::user())) {    

            return redirect()->route('session', $course)
                ->with('error', 'You are not enrolled in this course.');
        }
        
        // Check if the user is already enrolled in the course
        if ($course->isEnrolledByUser(Auth::user())) {
            return redirect()->route('lesson.index', $course)->with('error', 'You are already enrolled in this course.');
        }
        
        // Create a new enrollment record
        $enrollment = new Enrollment();
        $enrollment->user_id = Auth::id();
        $enrollment->course_id = $course->id;
        $enrollment->save();  
        


        return redirect()->route('course.show', $course)->with('success', 'You have successfully enrolled in the course.');
    }
    
    public function unenroll(Course $course)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to unenroll from courses.');
        }
        
        // Check if the user is enrolled in the course
        if (!$course->isEnrolledByUser(Auth::user())) {
            return redirect()->route('course.show', $course)->with('error', 'You are not enrolled in this course.');
        }

        Enrollment::where('user_id', Auth::id())->where('course_id', $course->id)->delete();
        
        return redirect()->route('course.show', $course)->with('success', 'You have successfully unenrolled from the course.');
    }
}




