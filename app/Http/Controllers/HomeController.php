<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
// use App\Models\User;
// use App\Models\Lesson;
// use App\Models\Course_user;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $categories = Category::orderBy('created_at', 'desc')->take(12)->get();;

        $courses = Course::orderBy('created_at', 'desc')->take(12)->get();
        
        $recentFreeCourses = Course::where('price', 0)->orderBy('created_at', 'desc')->take(8)->get();

    return view('home', compact('categories', 'courses', 'recentFreeCourses', ));
    
    }

    // public function nav()
    // {
    //     $categories = Category::all();
    //     $courses = Course::all();
    //     return view('layouts.app', compact('categories','courses') );
    // }

 
}
