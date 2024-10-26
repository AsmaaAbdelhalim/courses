<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

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
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::latest()->take(12)->get();
        $courses = Course::latest()->take(12)->get();
        $recentFreeCourses = Course::where('price', 0)->latest()->take(8)->get();
        
        $user_wishlist_ids = Auth::check() ? Auth::user()->wishlists()->pluck('course_id')->all() : [];
        return view('home', compact('categories', 'courses', 'recentFreeCourses', 'user_wishlist_ids' ));       
    } 
}
