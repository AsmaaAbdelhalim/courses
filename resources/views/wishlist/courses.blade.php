@extends('layouts.app')
@section('content')
@foreach ($wishlists as $wishlist)
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">{{ $wishlist->course->name }}</h5>
        </div>
</div>
@endforeach
@endsection