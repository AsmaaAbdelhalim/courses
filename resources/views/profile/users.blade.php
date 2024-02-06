@extends('layouts.admin')
@section('content')


<div class="container">
    <div class="row">
    <div class="col-lg-10 m-auto py-2">
        <h1>Users</h1>
    <table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Created at</th>
            <th>Role</th>
            <th>Num of courses</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td> @if ($user->avatar)
    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="border-radius: 50%; height: 40px; width: 40px;">
@else
    <img src="{{ asset('images/default-avatar.png') }}"  style="border-radius: 50%; height: 40px; width: 40px;">
@endif
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td>@if($user->role == 'admin')
                    Admin
                @elseif($user->role == 0)
                    Student
                @elseif($user->role == 2)
                    Teacher
                @endif
            </td>
            <td>
            @if($user->enrollments->count() > 0)
                    {{ $user->enrollments->count() }}
                    @else
                    No Courses
                    @endif
             </td>
        
            <td>
                <!-- Action buttons --> 
               <a href="">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
    </div>
    </div>
@endsection
