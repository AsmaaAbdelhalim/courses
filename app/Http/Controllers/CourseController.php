<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\User;


use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses =Course::all();
        return view('course.index',['data' => $courses]);
    }

    public function index2()
    {
        $courses =Course::all();
        return view('course.index2',['data' => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $users =User::all();
        // return view('course.create',['data' => $users]);
    
        $course = Course::all();
        return view('/course.create',['data' => $course]);
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $course = new Course;
        $course->name = request('name');
        $course->price = request('price');
        //$course->user_id =request('user_id');
        $course->save();
        return  redirect('/course')->with('success','Record has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course =Course::find($id);
        return view('course.show', ['data' => $course]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findorfail($id);
        return view('course.edit', ['data' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = new Course;
        $course = Course::findorfail($id);
        $course->name = request('name');
        $course->price = request('price');
        $course->save();

        return view('course.index', ['data' => $course]);
    }


    // public function usersCourse($id){
    //     $user = User::findorfail($id);
    //     // dd($user);
    //     return view("course.userCourse", ["data"=>$user]);
        
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findorfail($id);
        $course->delete();
        return view ('course.index', ['data' => $course]);
    }


//     public function destroy(Request $request){
//         $id = $request->input('id');
//         Course::find($id)->delete();
// }
}