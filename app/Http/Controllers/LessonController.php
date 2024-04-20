<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;  
use App\Models\Lesson;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Course_user;
//use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$course = Course::find($course_id);
        //$lessons = $course->lessons;
        $lessons = Lesson::all();
        
        return view('lesson.index', compact('lessons',
        //'course'
    ));
    }


    public function show($course_id, $lesson_id)
    {
        // Check if the user is enrolled in the course
        $user = Auth::user();
        $course = Course::findOrFail($course_id);
        $lessons = Lesson::where('course_id', $course_id)->get();
        $lesson = Lesson::find($lesson_id);
        
        // if (!$course->enrollment(Auth::user())) {
        //     return redirect()->route('course.show', $course_id)->with('error', 'You are not enrolled in this course.');
        // }
        if($user && $lesson)
        {
            Course_user::updateOrInsert(
                ['user_id' => $user->id, 'course_id' => $course_id, 'lesson_id' => $lesson->id],
            );
        }
        else
        {
            return redirect()->back()->with('error', 'You have not completed this lesson yet.');
        } 

        $userCourse = $user->lessons()->where('lesson_id', $lesson_id)->first();
        $userCourse -> pivot-> update(['completed' => 1,]);

        $totalLessons = $course->lessons->count();
        $completedLessons = $user->lessons->where('course_id', $lesson->course_id)->count();
        $progress = number_format(( $completedLessons / $totalLessons ) * 100 ) ;
     

        
        $previousLesson = Lesson::where('course_id', $lesson->course_id)
        ->where('id', '<', $lesson->id)
        ->orderBy('id', 'desc')
        ->first();

        $nextLesson = Lesson::where('course_id', $lesson->course_id)
        ->where('id', '>', $lesson->id)
        ->orderBy('id')
        ->first();

        return view('lesson.show', compact('course', 'lessons','lesson','user', 'previousLesson' ,'nextLesson' ,'userCourse','progress'));
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
    public function store(Request $request)
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
            $lesson->videos = $videoName;
        }

        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files'), $fileName);
            $lesson->files = $fileName;
        }

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $lesson->images = $fileName;
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
    public function update(Request $request, string $id)
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

        if ($request->hasFile('images')) {
            $image = $request->file('images');
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
