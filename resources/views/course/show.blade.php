@extends('layouts.app')
@section('content')
@include('layouts.header')
<style>
     .rate {
         float: left;
         height: 46px;
         padding: 0 10px;
         }
         .rate:not(:checked) > input {
         position:absolute;
         display: none;
         }
         .rate:not(:checked) > label {
         float:right;
         width:1em;
         overflow:hidden;
         white-space:nowrap;
         cursor:pointer;
         font-size:30px;
         color:#ccc;
         }
         .rated:not(:checked) > label {
         float:right;
         width:1em;
         overflow:hidden;
         white-space:nowrap;
         cursor:pointer;
         font-size:30px;
         color:#ccc;
         }
         .rate:not(:checked) > label:before {
         content: '★ ';
         }
         .rate > input:checked ~ label {
         color: #ffc700;
         }
         .rate:not(:checked) > label:hover,
         .rate:not(:checked) > label:hover ~ label {
         color: #deb217;
         }
         .rate > input:checked + label:hover,
         .rate > input:checked + label:hover ~ label,
         .rate > input:checked ~ label:hover,
         .rate > input:checked ~ label:hover ~ label,
         .rate > label:hover ~ input:checked ~ label {
         color: #c59b08;
         }
         .star-rating-complete{
            color: #c59b08;
         }
         .rating-container .form-control:hover, .rating-container .form-control:focus{
         background: #fff;
         border: 1px solid #ced4da;
         }
         .rating-container textarea:focus, .rating-container input:focus {
         color: #000;
         }
         .rated {
         float: left;
         height: 46px;
         padding: 0 10px;
         }
         .rated:not(:checked) > input {
         position:absolute;
         display: none;
         }
         .rated:not(:checked) > label {
         float:right;
         width:1em;
         overflow:hidden;
         white-space:nowrap;
         cursor:pointer;
         font-size:30px;
         color:#ffc700;
         }
         .rated:not(:checked) > label:before {
         content: '★ ';
         }
         .rated > input:checked ~ label {
         color: #ffc700;
         }
         .rated:not(:checked) > label:hover,
         .rated:not(:checked) > label:hover ~ label {
         color: #deb217;
         }
         .rated > input:checked + label:hover,
         .rated > input:checked + label:hover ~ label,
         .rated > input:checked ~ label:hover,
         .rated > input:checked ~ label:hover ~ label,
         .rated > label:hover ~ input:checked ~ label {
         color: #c59b08;
         }
</style>  
    <!-- Detail Start -->

  
                         
                        <i class="fas fa-book"></i>
                        <i class="fas fa-star"></i> 
                        <i class="fas fa-laptop"></i>
                        <i class="fas fa-user-graduate"></i> 
                        <i class="fas fa-folder"></i> 
                        <i class="fas fa-file-alt"></i> 
                        <h4 class="text-primary mb-3"><i class="fas fa-check-circle"> </i>
                        <i class="fas fa-users"></i>
                        <i class="fas fa-star"></i>
<div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5">
                        <h6 class="text-primary mb-3"><i class="far fa-clock"></i> {{ $course->created_at->format('Y-m')}}</h6>
                        <h1 class="mb-5">{{$course->name}} Course</h1>
                        <video class="img-fluid rounded w-100 mb-4" controls autoplay>
                        <source src="{{ asset('videos/' . $course->videos) }}" type="video/mp4">
                        </video>

                        <p> <h4>
                    @if($course->price == 0)
                    <span class="text-success">Free</span>
                    @else
                    {{$course->price}} $
                    @endif</h4><p>

                    @if (Auth::check())
        @if ($course->isEnrolledByUser(Auth::user()))
            <p>You are already enrolled in this course.</p>
            <form action="{{ route('unenroll', $course) }}" method="POST">
            {{ csrf_field() }}
                            {{method_field('PUT')}}
                @csrf
                <button type="submit" class="btn btn-info "
            style="width:20%">Unenroll</button>
            </form>
        @else


            <form action="{{ route('enroll', $course) }}" method="POST">
            {{ csrf_field() }}
                            {{method_field('PUT')}}
                @csrf
                <button type="submit" class="btn btn-info "
            style="width:20%">Enroll</button>
            </form>


        @endif
    @else
        <button class="btn btn-danger"><a href="{{ route('login') }}">Please log in to enroll in courses.</a></button>
    @endif
                        <h6><i class="fas fa-check-circle"></i>Requirement<p>{{ $course->requirement }}</p></h6>
                        <h6><i class="fas fa-book"></i>Summary<p>{{ $course->summary }}</p></h6>
                        <h2 class="mb-4">Description</h2>
                        <h4><i class="fas fa-book"></i> 
                        <h6>{{ $course->description }}</h6>
                        <img class="img-fluid rounded w-100 mb-4" src="{{ asset('images/' . $course->image) }}" alt="Image">
                        <a href="{{ asset('files/' . $course->files) }}"> {{ $course->name }} pdf</a>
                               

                        
                        
                    </div>

                    <!-- Comment List -->


                    <div class="mb-5">@if ($course->reviews->count() > 0)
                        <h3 class="text-uppercase mb-4" style="letter-spacing: 5px;">{{ $course->reviews->count() }} Review</h3>
                        @foreach ($course->reviews as $review)
                        <div class="media mb-4">

                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="border-radius: 50%; height: 40px; width: 40px;">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}"  style="border-radius: 50%; height: 40px; width: 40px;">
                                @endif
   
                            <div class="media-body">
                                <h6>{{ $review->user->first_name }} <small><i>{{ $review->created_at }}</i></small></h6>
                                <div class="rated">                
                                 @for($i=1; $i<=$review->rating; $i++)
                                {{-- <input type="radio" id="star{{$i}}" class="rate" name="rating" value="5"/> --}}
                                <label class="star-rating-complete" title="text">{{$i}} stars</label>
                                 @endfor 
                                </div>
                                <p>{{ $review->review }}</p>
                            </div>
                        </div>                  
                        @endforeach
                           
                        @else
                            <p>No reviews yet.</p>
                        @endif
                    </div>


                    <!-- Comment Form -->
                

                                      <!-- Review Form -->
                                      <h2>Add a Review</h2>
                    <div class="bg-secondary rounded p-5">
                        <h3 class="text-uppercase mb-4" style="letter-spacing: 5px;">Add a Review</h3>                        
                        <form action="{{ route('review.store') }}" method="POST">
                        @csrf
                        @method('POST')
                       <input type="hidden" name="course_id" value="{{ $course->id }}">                      
                        <div class="form-group row">
                        <div class="col">
                        <div class="rate">
                            <input type="radio" id="star5" class="rate" name="rating" value="5"/>
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" class="rate" name="rating" value="4"/>
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" class="rate" name="rating" value="2">
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                                <label for="star1" title="text">1 star</label>
                                    </div>
                                         </div>
                                             </div>
                                <div class="form-group">
                                <label for="review">Review:</label>
                                <textarea name="review" id="review" rows="5" cols="30" class="form-control border-0" required></textarea>    
                                </div>
                                <button type="submit" class="btn btn-primary py-md-2 px-md-4 font-weight-semi-bold">Submit Review</button>
                                </form>
                                </div>
                   



                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <!-- Author Bio -->
                    <div class="d-flex flex-column text-center bg-dark rounded mb-5 py-5 px-4">
                        <img src="img/user.jpg" class="img-fluid rounded-circle mx-auto mb-3" style="width: 100px;">
                        <h3 class="text-primary mb-3">John Doe</h3>
                        <h3 class="text-uppercase mb-4" style="letter-spacing: 5px;">Tag Cloud</h3>
                        <p class="text-white m-0">Conset elitr erat vero dolor ipsum et diam, eos dolor lorem, ipsum sit
                            no ut est ipsum erat kasd amet elitr</p>
                    </div>

                    <!-- Search Form -->
                    <div class="mb-5">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" placeholder="Keyword">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary"><i
                                            class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Category List -->
                    <div class="mb-5">
                        <h3 class="text-uppercase mb-4" style="letter-spacing: 5px;">Categories</h3>
                        <ul class="list-group list-group-flush">

                        @foreach($categories as $category)
                           
                           <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                               <a href="{{route ('category.show',[$category->id])}}" class="text-decoration-none h6 m-0">{{$category->name}}</a>
                               <span class="badge badge-primary badge-pill">{{ $category->course->count() }}</span>
                           </li>  @endforeach
                        </ul>
                    </div>

                    <!-- Recent Post -->
                    <div class="mb-5">
                        <h3 class="text-uppercase mb-4" style="letter-spacing: 5px;">Recent Post</h3>
                        <a class="d-flex align-items-center text-decoration-none mb-3" href="">
                            <img class="img-fluid rounded" src="img/blog-80x80.jpg" alt="">
                            <div class="pl-3">
                                <h6 class="m-1">Diam lorem dolore justo eirmod lorem dolore</h6>
                                <small>Jan 01, 2050</small>
                            </div>
                        </a>
                        <a class="d-flex align-items-center text-decoration-none mb-3" href="">
                            <img class="img-fluid rounded" src="img/blog-80x80.jpg" alt="">
                            <div class="pl-3">
                                <h6 class="m-1">Diam lorem dolore justo eirmod lorem dolore</h6>
                                <small>Jan 01, 2050</small>
                            </div>
                        </a>
                        <a class="d-flex align-items-center text-decoration-none mb-3" href="">
                            <img class="img-fluid rounded" src="img/blog-80x80.jpg" alt="">
                            <div class="pl-3">
                                <h6 class="m-1">Diam lorem dolore justo eirmod lorem dolore</h6>
                                <small>Jan 01, 2050</small>
                            </div>
                        </a>
                    </div>

                    <!-- Tag Cloud -->
                    <div class="mb-5">
                        <h3 class="text-uppercase mb-4" style="letter-spacing: 5px;">Tag Cloud</h3>
                        <div class="d-flex flex-wrap m-n1">
                            <a href="" class="btn btn-outline-primary m-1">Design</a>
                            <a href="" class="btn btn-outline-primary m-1">Development</a>
                            <a href="" class="btn btn-outline-primary m-1">Marketing</a>
                            <a href="" class="btn btn-outline-primary m-1">SEO</a>
                            <a href="" class="btn btn-outline-primary m-1">Writing</a>
                            <a href="" class="btn btn-outline-primary m-1">Consulting</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;"></h5>
                <h1>Courses </h1>
            </div>
            @if($course->category)
<div class="row">
    @foreach($course->category->courses as $course)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="cat-item position-relative overflow-hidden rounded mb-2">
                        <img class="img-fluid" style="height: 200px;" src="{{ asset('images/' . $course->image) }}" alt="course Image">
                        <a class="cat-overlay text-white text-decoration-none" href="{{route ('course.show',[$course->id])}}">
                            <h4 class="text-white font-weight-medium">{{ $course->name }}</h4>
                            <span>{{ $course->lessons->count() }} lesson</span>
                        </a>
                    </div>
                </div>@endforeach
                </div>
                @endif

        </div>
    </div>
    <!-- Detail End -->
<!--  -->



{{$course->lessons_count}}

@endsection