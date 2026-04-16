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
use Carbon\Carbon;
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

        $courses = Course::with(['category', 'user'])
        ->withCount(['lessons', 'enrollment'])->latest()->paginate(12);
        $categories = Category::with('courses')->get();
        $path = [
            'course' => $this->courseService->getMediaPath('image'),
            'category' => app(\App\Services\CategoryService::class)->getMediaPath('image'),

        ];

        return view('course.index', compact('courses', 'categories', 'user_wishlist_ids', 'path'));
    }

    public function list()
    {
        /** @var User $user */
        $user = Auth::user();
        $user_wishlist_ids = $user ? $user->wishlists()->pluck('course_id')->toArray() : [];

        //'user_wishlist_ids' => auth()->user()?->wishlists()->pluck('course_id')->toArray() ?? []

        $courses = Course::withCount(['lessons', 'enrollment', 'wishlists'])->latest()->paginate(12);
        $categories = Category::with('courses')->get();

        $path = $this->courseService->getMediaPath('image');

        return view('course.list', compact('courses', 'categories', 'user_wishlist_ids' , 'path'));
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
        $categories = Category::with('courses')->get();
        $path = $this->courseService->getMediaPath('image');
        return view('course.show', compact('course', 'path', 'categories'));
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

    public function userCourses()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
          $user = Auth::user();
          $enrollments = $user->enrollments;

          return view('course.userCourses', compact('user','enrollments'));
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $courses = Course::query()
            //->where('active', '=', true)
            ->whereDate('created_at', '<=', Carbon::now())
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%");
            })
            ->latest()
            ->paginate(10);
            $path = [
                'course' => $this->courseService->getMediaPath('image'),
            ];

            $user = Auth::user();
            $user_wishlist_ids = $user ? $user->wishlists()->pluck('course_id')->toArray() : [];
    
        return view('course.search', compact('courses', 'user_wishlist_ids', 'path'));        
    }

}