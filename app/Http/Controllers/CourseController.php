<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use App\Services\CourseService;
use Illuminate\Http\RedirectResponse;

class CourseController extends Controller
{
    private CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $user_wishlist_ids = $user ? $user->wishlists()->pluck('course_id')->toArray() : [];

        //'user_wishlist_ids' => auth()->user()?->wishlists()->pluck('course_id')->toArray() ?? []

        $courses = Course::withCount(['lessons', 'enrollment'])->latest()->paginate(12);
        $categories = Category::with('courses')->get();

        //$courses = Course::with(['category', 'user'])
        //->latest()
        //->paginate(12);
        return view('course.index', compact('courses', 'categories', 'user_wishlist_ids'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $teachers = User::where('role', '2')->get();
        return view('course.create', compact('categories', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request): RedirectResponse
    {
        try {
            $course = $this->courseService->create(
                $request->validated(),
                $request
            );

            return redirect()
                ->route('course.index', $course)
                ->with('success', 'Course created successfully');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create course');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with('reviews', 'user')->findOrFail($id);
        return view('course.show', [
            'course' => $course,
            'categories' => Category::all(),
            'user' => Auth::id(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        $teachers = User::where('role', '2')->get();
        return view('course.edit', compact('course', 'categories', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        try {
            $this->courseService->update(
                $course,
                $request->validated(),
                $request
            );

            return redirect()
                ->route('course.index', $course)
                ->with('success', 'Course updated successfully');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update course');
        }

        return redirect()->route('course.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('course.index')->with('success', 'Course deleted successfully!');
    }
}