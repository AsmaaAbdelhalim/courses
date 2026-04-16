<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $stats = DB::table('categories')->selectRaw('
            (SELECT COUNT(*) FROM categories) as categories,
            (SELECT COUNT(*) FROM courses) as courses,
            (SELECT COUNT(*) FROM enrollments) as enrollments,
            (SELECT COUNT(*) FROM users) as users,
            (SELECT COUNT(*) FROM contacts) as contacts,
            (SELECT COUNT(*) FROM payments) as payments,
            (SELECT SUM(total_price) FROM payments) as total_payments,
            (SELECT COUNT(*) FROM reviews) as reviews
        ')->first();
        return view('admin', compact('stats'));
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
