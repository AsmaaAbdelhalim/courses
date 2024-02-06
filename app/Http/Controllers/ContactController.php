<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contact.index');
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
        

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->phone = $request->phone;
        $contact->message = $request->message;
        $contact->country = $request->country;
        $contact->city = $request->city;
        //$contact->user_id = Auth::user()->id;
        $contact->save();
        Contact::create($request->all());
  
        return redirect()->back()
                         ->with(['success' => 'Thank you for contact us. we will contact you shortly.']);
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

        public function list()
    {
        $contacts = Contact::all()->sortByDesc('created_at');
        $contacts = Contact::latest()->paginate(10);
        return view('contact.list', compact('contacts'));
    }

    public function showContactForm()
    {
        return view('contact');
    }

    public function submitContactForm(Request $request)
    {
        // Process the submitted form data
        // Send email, store data in the database, etc.

        // Redirect the user back to the contact form with a success message
        return redirect()->route('contact.form')->with('success', 'Message sent successfully!');
    }
}
