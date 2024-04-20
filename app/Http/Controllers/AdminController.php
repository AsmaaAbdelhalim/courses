<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Review;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * 
     */

    public function dashboard()
    {
        $categories = Category::count();
        $courses = Course::count();
        $enrollments = Enrollment::count();
        $users = User::count();
        $contacts = Contact::count();
        $payments = Payment::count();
        $total_payments = Payment::sum('total_price');
        $reviews = Review::count();
        return view('admin', compact('categories', 'courses', 'enrollments', 'users', 'contacts', 'payments', 'total_payments', 'reviews'));
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
    public function show(string $id)
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
