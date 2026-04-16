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
use App\Models\CourseUser;
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
        $lessons = Lesson::with('course')->latest()->paginate(10);
        $path = $this->lessonService->getMediaPath('image');
        return view('lesson.index', compact('lessons', 'path'));
    }
    /**
     * Display the specified resource.
     */
    public function show($course_id, $lesson_id)
    {
        $user = Auth::user();
        $course = Course::with('lessons')->findOrFail($course_id);
        $lesson = $course->lessons()->findOrFail($lesson_id);

        if (!$user->enrollments()->where('course_id', $course_id)->exists()) {
            return redirect()->route('course.show', $course_id)
                ->with('error', 'You must enroll in this course first.');
        }

        $user->lessons()->syncWithoutDetaching([
            $lesson->id => [
                'completed' => true,
                'course_id' => $lesson->course_id 
            ]
        ]);

        $progress = $user->courseProgress($course_id);
        $previousLesson = $lesson->previous();
        $nextLesson = $lesson->next();

        $path =[
            'image' => $this->lessonService->getMediaPath('image'),
            'videos' => $this->lessonService->getMediaPath('videos'),
        ];

        return view('lesson.show', compact('course', 'lesson', 'user', 'previousLesson', 'nextLesson', 'progress', 'path'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::orderBy('name')->get();
        return view('lesson.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
        try {
            $this->lessonService->create($request->validated(), $request);
            return redirect()->route('lesson.index')->with('success', 'Lesson created!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create lesson');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $courses = Course::orderBy('name')->get();
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
        

        return redirect()->route('lesson.index')->with('success', 'Lesson updated successfully!');
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