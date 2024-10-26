<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Course;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews= Review::all();
        return view('review.index',compact('reviews'));
    }

    public function list()
    {
        $reviews = review::latest()->paginate(10);
        return view('review.list', compact('reviews'));
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
        $validatedData = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|max:255',
        ]);

        $review = new Review;
        $review->rating = $validatedData['rating'];
        $review->review = $validatedData['review'];

        $review->course_id = $request->course_id;
        $review->user_id = Auth::user()->id;

        $review->save();

        return redirect()->back()->with('success', 'Review created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $review = Review::findOrFail($id);

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|max:255',
            // Add any other validation rules for your review fields
        ]);

        $review = Review::findOrFail($id);
        $review->rating = $validatedData['rating'];
        $review->comment = $validatedData['comment'];
        // Update any other review fields here

        $review->save();

        return redirect()->back()->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}