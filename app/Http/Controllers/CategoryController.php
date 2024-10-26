<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('courses')->latest()->paginate(10);
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


    public function store(StoreCategoryRequest $request)
    {
        $category = new Category($request->validated());
        $category->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $this->deleteAssociatedFile($category->image);
            $image = $request->file('image');

            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $category->image = $fileName;
            }
        $category->save();
        return redirect()->route('category.index')->with('success', 'Category created successfully');
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
        $user_wishlist_ids = $user ? $user->wishlists()->pluck('course_id')->toArray() : [];

        return view('category.show', compact('category', 'creator', 'courses', 'user_wishlist_ids'));
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

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->validated());

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            //$this->deleteAssociatedFile($category->image);
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $category->image = $fileName;
            }
        $category->save();
        return redirect()->route('category.index')->with('success', 'Category updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $this->deleteAssociatedFile($category->image);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }

    private function deleteAssociatedFile(?string $filename)
    {
        if ($filename) {
           $filePath = public_path('images/' . $filename);
           if (file_exists($filePath)) {
            unlink($filePath);
            }
            
        }
    }

}
