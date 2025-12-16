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
use App\Services\LessonService;

class LessonController extends Controller
{
    private LessonService $lessonService;
    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::all();
        return view('lesson.index', compact('lessons'));
    }
    /**
     * Display the specified resource.
     */
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
        /** @var User $user */
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
        
        try {
            $lesson = $this->lessonService->create($request->validated(), $request);
            return redirect()->route('lesson.index', $lesson);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create lesson');
        }
        return redirect()->route('lesson.index')->with('success', 'Lesson created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $courses = Course::all();
        return view('lesson.edit', compact(['lesson','courses']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        try{
            $lesson = $this->lessonService->update($lesson, $request->validated(), $request);
            return redirect()->route('lesson.index', $lesson);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update lesson');
        }
        

        return redirect()->route('lesson.index', $lesson->id)->with('success', 'Lesson updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lesson.index')->with('success', 'Lesson deleted successfully!');
    }
}