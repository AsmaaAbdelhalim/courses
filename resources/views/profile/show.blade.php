@extends('layouts.app')
@section('content')

<br>
<br>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                @if ($user->avatar)
    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="border-radius: 50%; height: 200px; width: 200px;">
@else
    <img src="{{ asset('images/default-avatar.png') }}"  style="border-radius: 50%; height: 200px; width: 200px;">
@endif
                </div>

                <h3 class="profile-username text-center">{{ $user->first_name }} Profile</h3>

                <p class="text-muted text-center">
                @if($user->role == 'admin')
                    Admin
                @elseif($user->role == 0)
                    Student
                @elseif($user->role == 2)
                    Teacher
                @endif
                  </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                    <b> <i class="fas fa-book mr-1"></i> Enrolled Courses</b> <a class="float-right">

                    @if($user->enrollments->count() > 0)
                    {{ $user->enrollments->count() }}
                    @else
                    No Courses
                    @endif
                  </a>
                  </li>
                  <li class="list-group-item">
                  <i class="fa fa-envelope"></i>
                    <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                  </li>

                  <li class="list-group-item">
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                  <p class="text-muted">{{ $user->city }},{{ $user->country }}</p>
                  </li>
                  <li class="list-group-item">
                  <strong><i class="fas fa-phone-alt mr-1"></i> Phone</strong>
                  <p class="text-muted">{{ $user->phone }}</p>
                  </li>
                </ul>

                <a href="{{route ('edit-profile')}}" class="btn btn-primary btn-block"><b>Edit Profile  <i class="far fa-file-alt mr-1"> </i></b></a>
                <a href="{{route ('change-password')}}" class="btn btn-primary btn-block"><b>Change Password  <i class="fas fa-pencil-alt mr-1"> </i></b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
          </div>
          <!-- /.col -->
          <div class="col-md-9">
           
                   
<h2>Enrolled Courses</h2>
@if($user->enrollments->count() > 0)
                    {{ $user->enrollments->count() }}
@foreach ($enrollments as $enrollment)
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">{{ $enrollment->course->name }}</h5>
        </div>
        <div class="card-body">
            <h6 class="card-title">{{ $enrollment->course->name }}</h6>
            <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="{{ route('course.show', [$enrollment->course->id]) }}" class="btn btn-primary">Go To Course</a>
        </div>
    </div>
@endforeach

                    @else
                    <a href="{{ route('course.index') }}" class="btn btn-primary"><b> No Courses Enrolled Go To Courses To Start </b></a>
                    @endif

                  
                </div>
                <!-- /.tab-content -->
     
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <h1>Wishlist</h1>
  

    <ul>
        @foreach($wishlists as $wishlist)
            <li>{{ $wishlist->course }}</li>
        @endforeach
    </ul>


</div>


@endsection
