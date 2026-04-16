<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    private CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('courses')->latest()->paginate(10);
        $path = $this->categoryService->getMediaPath('image');
        return view('category.index', compact('categories', 'path'));
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
        try {
            $category = $this->categoryService->create(
                $request->validated(),
                $request
            );

            return redirect()
                ->route('category.index', $category)
                ->with('success', 'Category created successfully');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create category');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $courses = $category->courses()->paginate(12);
        $creator = $category->user;
        $path = [
            'course' => app(\App\Services\CourseService::class)->getMediaPath('image'),
            'category' => $this->categoryService->getMediaPath('image'),
        ];

        /** @var User $user */
        $user = Auth::user();
        $user_wishlist_ids = $user ? $user->wishlists()->pluck('course_id')->toArray() : [];

        return view('category.show', compact('category', 'creator', 'courses', 'user_wishlist_ids', 'path'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category) 
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category = $this->categoryService->update(
                $category,
                $request->validated(),
                $request
            );

            return redirect()
                ->route('category.index', $category)
                ->with('success', 'Category updated successfully');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
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
