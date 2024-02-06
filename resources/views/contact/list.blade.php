@extends('layouts.admin')

@section('content')

<div class="container">
<h1 class="m-0 text-white display-4 text-center"><span class="text-danger">Contacts</span></h1>
    <div class="col-lg-10 m-auto py-2">
    <table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Country</th>
            <th>City</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contacts as $contact)
        <tr>
            <td>{{ $contact->id }}</td>
            <td>{{$contact->name}}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone }}</td>
            <td>{{ $contact->country }}</td>
            <td>{{ $contact->city}}</td>
            <td>{{ $contact->subject }}</td>
            <td>{{ $contact-> message}}</td>
            <td>
                <!-- Action buttons --> 

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $contacts->links('layouts.custom-pagination') }}
</div>
    </div>
@endsection