
@section('content')
    <h1>Wishlist Courses</h1>


   
    <h2>My Wishlist</h2>
    <ul>
        @foreach($user->wishlists as $wishlist)
            <li>{{ $wishlist->course->name }}</li>
        @endforeach
    </ul>
