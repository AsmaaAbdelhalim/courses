<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all()->sortByDesc('created_at');
        $categories = Category::latest()->paginate(10);
        $categories = Category::withCount('course')->get();

        return view('category.index', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
{
    $user_id = Auth::id();
    $category = new Category();
    $category->user_id = $user_id;
    $category->name = $request->input('name');
    $category->description = $request->input('description');

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $fileName);
        $category->image = $fileName;
    }
    
    $category->save();
    
    return redirect()->route('category.index');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        $courses = $category->courses()->paginate(12);
        $creator = $category->user;

        $user = Auth::user();
        $user_wishlist_ids = [];
        if($user){
        $user_wishlist_ids = $user->wishlists()->pluck('course_id')->all();}
        return view('category.show', compact(['category','creator','courses', 'user_wishlist_ids']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
{
    $category = Category::find($id);
    $category->name = $request->input('name');
    $category->description = $request->input('description');

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $fileName);
        $category->image = $fileName;
    }
    
    $category->save();
    
    return redirect()->route('category.index');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
    /**
     * 
     *
     */

public function courses()
{

    $categories = Category::all();

return view('category.courses', compact('categories'));

}
}
