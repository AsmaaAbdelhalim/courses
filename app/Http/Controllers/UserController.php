<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    //
    public function users()
    {

        $users = User::all();
        $user = Auth::user();
        $enrollments = $user->enrollments();
        
        return view('profile.users', compact('users','user','enrollments'));
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
    public function show()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
          $user = Auth::user();
          $enrollments = $user->enrollments;
          $wishlists = $user->wishlists;
          

          return view('profile.show', compact('user','enrollments','wishlists'));
    }

        public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit-Profile', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->city = $request->input('city');
        $user->country = $request->input('country');

    
        if ($request->hasFile('avatar')) {
            // Delete the old avatar file if it exists
            // if ($user->avatar) {
            //     Storage::delete($user->avatar);
            // }
    
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
    
        $user->save();
    
        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function changePassword()
{
   return view('profile.change-password');
}

public function updatePassword(Request $request)
{
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
}


    /**
     *  
     */
    public function editUserRole($user_id)
    {
        $user = User::find($user_id);
        return view('profile.edit-user-role', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUserRole(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $user->role = request('role');
        $user->save();
        return redirect()->route('profile.users')->with('success', 'User role updated successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
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
