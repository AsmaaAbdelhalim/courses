<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $categories = Category::all();

         /** @var User $user */
        $user = Auth::user();
        $user_wishlist_ids = $user ? $user->wishlists()->pluck('course_id')->toArray() : [];

         //dd($user_wishlist_ids);
        $categories = Category::with('courses')->get();
        $courses = Course::withCount(['lessons', 'enrollment'])
            ->latest()
            ->paginate(12);
      
        return view('course.index',compact(['courses','categories' , 'user_wishlist_ids']));
    }  

    /*
    *
    */

    public function list()
    {
        //$courses = Course::all();

        $courses = Course::withCount(['lessons', 'wishlists', 'enrollment'])->get();
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
    public function store(StoreCourseRequest $request)
    {
        //$validated = $request->validated();
        //$course->fill($validated);

        $course = new Course($request->validated());
        $course->user_id = Auth::id();
          
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
    
            //$teachers = User::where('role', '2');
            //$course->teachers = request('teachers');
            
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




        //        $course->load('reviews');
        //$creator = $course->user;
        //$categories = Category::all();
        //$user = Auth::id();

        
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
    public function update(UpdateCourseRequest $request, string $id)
    {
        $course = Course::findorfail($id);
        $data = $request->validated();

        $this->handleFileUpload($request, $course, 'videos');
        $this->handleFileUpload($request, $course, 'files');
        $this->handleFileUpload($request, $course, 'image');

        $course->update($data);

        // $request->validate([
        //     'videos' => 'required|file|mimes:mp4,mov,avi', // Adjust MIME types as needed
        // ]);
        // $course = Course::findorfail($id);
        // $user_id = Auth::id();
        // $course->user_id = $user_id;
        // $course->name = request('name');
        // $course->price = request('price');
        // $course->category_id =request('category_id');
        // $course->description = request('description');
        // $course->code = request('code');
        // $course->summary = request('summary');
        // $course->description = request('description');
        // $course->requirement = request('requirement');
        // $course->discount = request('discount');
        // $course->numOfHours = request('numOfHours');
        // $course->started_at = request('started_at');
        // $course->finished_at = request('finished_at');
        // $course->duration = request('duration');
        // $course->files = request('files');
        // $course->videos = request('videos');
        // $course->session = request('session');
        // $course->status = request('status');

        // if ($request->hasFile('videos')) {
        //     $video = $request->file('videos');
        //     $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
        //     $video->move(public_path('videos'), $videoName);
        //     $course->videos= $videoName;
        // }

        // if ($request->hasFile('files')) {
        //     $file = $request->file('files');
        //     $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('files'), $fileName);
        //     $course->files = $fileName;
        // }
        
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $fileName);
        //     $course->image = $fileName;
        // }
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
        $this->deleteFile($course->videos);
        $this->deleteFile($course->files);
        $this->deleteFile($course->image);
        $course->delete();
        return view ('course.index');
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
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%");
            })
            ->latest()
            ->paginate(10);

            $user = Auth::user();
            $user_wishlist_ids = $user ? $user->wishlists()->pluck('course_id')->toArray() : [];
    
        return view('course.search', compact('courses', 'user_wishlist_ids'));
    }

    private function handleFileUpload($request, $course, $field)
    {
        if ($request->hasFile($field)) {
            $this->deleteFile($course->$field);

            $file = $request->file($field);
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($field), $fileName);
            $course->$field = $fileName;
        }
    }

    private function deleteFile($fileName)
    {
        if ($fileName) {
            $filePath = public_path($fileName);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
    }

}