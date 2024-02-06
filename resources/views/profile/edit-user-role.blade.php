@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
    <div class="col-lg-10 m-auto py-2">
<h1>Edit User Role</h1>

    <a href="{{ route('profile.users') }}" class="btn btn-secondary">
        Back to Users
    </a>
    <br><br>
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
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $user->id }}</td>
            <td>@if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="border-radius: 50%; height: 40px; width: 40px;">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}"  style="border-radius: 50%; height: 40px; width: 40px;">
                @endif</td>   
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->role }}</td>
        </tr>
    </tbody>
    </table>

    <form action="{{ route('profile.edit-user-role', $user) }}" method="POST">
    @csrf
    @method('PUT')
        <h3><label for="role" class="form-label">Role:</label></h3>
        <select name="role" id="role" class="form-select">
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '1' }}>Admin</option>
            <option value="2" {{ $user->role === 'teacher' ? 'selected' : '2' }}>Teacher</option>
            <option value="0" {{ $user->role === 'user' ? 'selected' : '0' }}>User</option>
        </select>
        <button class="btn btn-secondary" type="submit">Update</button>
    </form>
</div>
</div>
</div>

@endsection

