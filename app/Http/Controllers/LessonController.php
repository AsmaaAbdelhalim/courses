<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;  
use App\Models\Lesson;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Course_user;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

//use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::all();
        return view('lesson.index', compact('lessons'));
    }

    public function show($course_id, $lesson_id)
{
    $user = Auth::user();
    $course = Course::findOrFail($course_id);
    $lesson = Lesson::findOrFail($lesson_id);

    if (!Enrollment::where('user_id', $user->id)->where('course_id', $course_id)->exists()) {
        return redirect()->route('course.show', $course_id)
            ->with('error', 'You need to enroll in this course to view its lessons.');
    }

    // Check if the user is enrolled in the course using the enrollment table
    $isEnrolled = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course_id)
            ->exists();

    if (!$isEnrolled) {
        return redirect()->route('course.show', $course_id)
        ->with('error', 'You need to enroll in this course to view its lessons.');
        }

    // Check if the lesson belongs to the course
    if ($lesson->course_id != $course_id) {
        return redirect()->route('course.show', $course_id)
            ->with('error', 'This lesson does not belong to the specified course.');
    }


    // Update or insert the course_user record
    Course_user::updateOrInsert(
        ['user_id' => $user->id, 'course_id' => $course_id, 'lesson_id' => $lesson->id]
    );

    // Mark the lesson as completed
    $user->lessons()->updateExistingPivot($lesson_id, ['completed' => 1]);

    // Calculate progress
    $totalLessons = $course->lessons->count();
    $completedLessons = $user->lessons->where('course_id', $lesson->course_id)->count();
    $progress = number_format(($completedLessons / $totalLessons) * 100);

    // Get previous and next lessons
    $previousLesson = Lesson::where('course_id', $course_id)
        ->where('id', '<', $lesson->id)
        ->orderBy('id', 'desc')
        ->first();

    $nextLesson = Lesson::where('course_id', $course_id)
        ->where('id', '>', $lesson->id)
        ->orderBy('id')
        ->first();

    // Get only the lessons for the current course
    $lessons = $course->lessons;

    // Get the user's progress for the current course
    //$userProgress = $user->lessons()->where('course_id', $course_id)->first();

    // Calculate the progress percentage
    //$progressPercentage = $userProgress ? ($userProgress->pivot->completed / $totalLessons) * 100 : 0;
     // Check if the user has completed 100% of the lessons
     //$canStartExam = $progress == 100;


    return view('lesson.show', compact('course', 'lessons', 'lesson', 'user', 'previousLesson', 'nextLesson', 'progress'));
}

    /**
     *  
     *
     */
    public function list()
    {
        $lessons = Lesson::all();
        return view('lesson.list', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('lesson.create', compact('courses'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
        $user_id = Auth::id();
        $lesson = new Lesson;
        $lesson->course_id = request('course_id');
        $lesson->title = request('title');
        $lesson->description = request('description');
        $lesson->user_id = $user_id;

        if ($request->hasFile('videos')) {
            $video = $request->file('videos');
            $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('videos'), $videoName);
            $lesson->videos= $videoName;
        }

        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files'), $fileName);
            $lesson->files = $fileName;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $lesson->image = $fileName;
        }

        $lesson->save();
        return redirect()->route('lesson.index')->with('success', 'Lesson created successfully!');
    }

    /**
     * Display the specified resource.
     */
   

   
    /**
     * Remove the specified resource from storage.
     */

    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $courses = Course::all();
        return view('lesson.edit', compact(['lesson','courses']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $user_id = Auth::id();
        $lesson->user_id = $user_id;
        $courses = Course::all();
        $lesson->course_id = request('course_id');
        $lesson->title = request('title');
        $lesson->description = request('description');
        if ($request->hasFile('videos')) {
            $video = $request->file('videos');
            $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('videos'), $videoName);
            $lesson->videos= $videoName;
        }

        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files'), $fileName);
            $lesson->files = $fileName;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $lesson->image = $fileName;
        }

        $lesson->save();

        return redirect()->route('lesson.index', $lesson->id)->with('success', 'Lesson updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
        return redirect()->route('lesson.index')->with('success', 'Lesson deleted successfully!');
    }
}
