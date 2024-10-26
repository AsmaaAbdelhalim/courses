<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        /** @var User $user */
        $user = Auth()->User();
        $user_wishlist_ids = $user->wishlists()->pluck('course_id')->all();
        $wishlistCourses = Course::whereIn('id', $user_wishlist_ids)->get();
        //dd($wishlistCourses);
        //dd($user_wishlist_ids);
//dd($wishlistCourses);
        return view('wishlist.index', compact('wishlistCourses','user', 'user_wishlist_ids'));

    }
 
    public function addToWishlist(Course $course)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add to wishlist.');
        }
        if ($wishlist = Wishlist::where('user_id', Auth::id())->where('course_id', $course->id
        )->first())
        {
            return redirect()->back()->with('error', 'Course already in wishlist.');
        }
      
        // if (Wishlist::where('user_id', Auth::id())->where('course_id', $course->id)->exists()) {
        //     return redirect()->back()->with('error', 'Course already in wishlist.');
        // }

        Wishlist::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
        ]);
        return redirect()->back()->with('success', 'Course added to wishlist successfully.');
        }

        

    public function removeFromWishlist(Course $course)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to remove from wishlist.');
        }
        
        Wishlist::where('user_id', Auth::id())->where('course_id', $course->id)->delete();

        return redirect()->back()->with('success', 'Course removed from wishlist successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $userId)
        {
            //
        }
    
        
        

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
