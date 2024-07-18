<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Payment;
use Carbon\Carbon;
//use Illuminate\Pagination\LengthAwarePaginator;


use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $categories = Category::all();

        $user = Auth::user();

        $user_wishlist_ids = [];
        if($user){
        $user_wishlist_ids = $user->wishlists()->pluck('course_id')->all();}
        //dd($user_wishlist_ids);
        $categories = Category::with('courses')->get();
        $courses = Course::all()->sortByDesc('created_at');
        $courses = Course::latest()->paginate(12);
        $courses = Course::withCount('lessons')->get();
        
        $courses = Course::withCount('enrollment')->get();
      
        return view('course.index',compact(['courses','categories' , 'user_wishlist_ids']));
    }  

    /*
    *
    */

    public function list()
    {
        $courses = Course::all();
        $courses = Course::withCount('lessons')->get();
        $courses = Course::withCount('wishlists')->get();
        $courses = Course::withCount('enrollment')->get();
        return view('course.list', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$teachers = User::role('2');
     
        $teachers = User::where('role', '2')->get();
        $categories  = Category ::all();
        return view('course.create', compact('categories','teachers'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $course = new Course;
        $course->user_id = $user_id;
        $course->category_id =request('category_id');
        $course->name = request('name');
        $course->price = request('price');
        $course->description = request('description');
        $course->code = request('code');
        $course->summary = request('summary');
        $course->description = request('description');
        $course->requirement = request('requirement');
        $course->discount = request('discount');
        $course->numOfHours = request('numOfHours');
        $course->started_at = request('started_at');
        $course->finished_at = request('finished_at');
        $course->duration = request('duration');
        $course->session = request('session');
        $course->status = request('status');

        if ($request->hasFile('videos')) {
            $video = $request->file('videos');
            $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('videos'), $videoName);
            $course->videos= $videoName;
        }

        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files'), $fileName);
            $course->files = $fileName;
        }
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $course->image = $fileName;
        }

        $teachers = User::where('role', '2');
        $course->teachers = request('teachers');
        
        $course->save();
        return redirect()->route('course.index')->with('success','Course has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        $creator = $course->user;
        $course = Course::with('reviews')->findOrFail($id);
        $categories = Category::all();
        $user = Auth::id();
        //dd($user, $course->users());
        
        return view('course.show', compact('course','creator','categories','user' ));
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findorfail($id);
        $teachers = User::where('role', '2')->get();
        $categories = Category::all();
        return view('course.edit', compact('course','categories', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findorfail($id);
        $course->user_id = $user_id;
        $course->name = request('name');
        $course->price = request('price');
        $course->category_id =request('category_id');
        $course->description = request('description');
        $course->code = request('code');
        $course->summary = request('summary');
        $course->description = request('description');
        $course->requirement = request('requirement');
        $course->discount = request('discount');
        $course->numOfHours = request('numOfHours');
        $course->started_at = request('started_at');
        $course->finished_at = request('finished_at');
        $course->duration = request('duration');
        $course->files = request('files');
        $course->videos = request('videos');
        $course->session = request('session');
        $course->status = request('status');

        if ($request->hasFile('videos')) {
            $video = $request->file('videos');
            $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('videos'), $videoName);
            $course->videos= $videoName;
        }

        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files'), $fileName);
            $course->files = $fileName;
        }
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $course->image = $fileName;
        }
        $teachers = User::where('role, 2');
        $course->teachers = request('teachers');

        $course->save();

        return redirect()->route('course.index')->with('success','Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findorfail($id);
        $course->delete();
        return view ('course.index', compact('courses'));
    }


    public function getMostEnrolledCourses()
    {
        $mostEnrolledCourses = Course::select('name', 'enrollment_count')
            ->where('category', 'laravel')
            ->orderByDesc('enrollment_count')
            ->limit(4)
            ->get();

        // return $mostEnrolledCourses;
        return view('home', compact('mostEnrolledCourses'));

    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $courses = Course::query()
            //->where('active', '=', true)
            ->whereDate('created_at', '<=', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%");
            })
            ->paginate(10);

        return view('course.search', compact('courses'));
    }

}