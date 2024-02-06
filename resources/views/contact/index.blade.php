@extends('layouts.app')
@section('content')
  
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-10 offset-1 mt-5">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-white"> Contact US </h3>
                    </div>
                    <div class="card-body">
  
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif
                     
                        <form method="POST" action="{{ route('contact.store') }}" id="contactUSForm">
                            {{ csrf_field() }}
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Country:</strong>
                                        <input type="text" name="country" class="form-control" placeholder="Country" value="{{ old('country') }}">
                                        @if ($errors->has('country'))
                                            <span class="text-danger">{{ $errors->first('') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>City:</strong>
                                        <input type="text" name="city" class="form-control" placeholder="City" value="{{ old('city') }}">
                                        @if ($errors->has('city'))
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Phone:</strong>
                                        <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ old('phone') }}">
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Subject:</strong>
                                        <input type="text" name="subject" class="form-control" placeholder="Subject" value="{{ old('subject') }}">
                                        @if ($errors->has('subject'))
                                            <span class="text-danger">{{ $errors->first('subject') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Message:</strong>
                                        <textarea name="message" rows="3" class="form-control">{{ old('message') }}</textarea>
                                        @if ($errors->has('message'))
                                            <span class="text-danger">{{ $errors->first('message') }}</span>
                                        @endif
                                    </div>  
                                </div>
                            </div>
                     
                            <div class="form-group text-center">
                                <button class="btn btn-success btn-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



     <!-- Contact Start -->
     <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Contact</h5>
                <h1>Contact For Any Query</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form bg-secondary rounded p-5">
                        <div id="success"></div>
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif
                    <form method="POST" action="{{ route('contact.store') }}" name="sentMessage" id="contactForm" novalidate="novalidate">
                            {{ csrf_field() }}
                        
                            <div class="control-group">
                                <input type="text" class="form-control border-0 p-4" name="name" id="name" placeholder="Your Name" required="required" data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                                @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control border-0 p-4" name="email" id="email" placeholder="Your Email" required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                                @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                 @endif
                            </div>
                            <div class="control-group">
                                <input type="phone" class="form-control border-0 p-4" name="phone" id="phone" placeholder="Your phone" required="required" data-validation-required-message="Please enter your phone" />
                                <p class="help-block text-danger"></p>
                                @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                 @endif
                            </div>
                            <div class="control-group">
                                <input type="country" class="form-control border-0 p-4" name="country" id="country" placeholder="Your country" required="required" data-validation-required-message="Please enter your country" />
                                <p class="help-block text-danger"></p>
                                @if ($errors->has('country'))
                                            <span class="text-danger">{{ $errors->first('country') }}</span>
                                 @endif
                            </div>
                            <div class="control-group">
                                <input type="city" class="form-control border-0 p-4" name="city" id="city" placeholder="Your city" required="required" data-validation-required-message="Please enter your city" />
                                <p class="help-block text-danger"></p>
                                @if ($errors->has('city'))
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                 @endif
                            </div>
                            <div class="control-group">
                                <input type="text" class="form-control border-0 p-4" name="subject" id="subject" placeholder="Subject" required="required" data-validation-required-message="Please enter a subject" />
                                <p class="help-block text-danger"></p>
                                @if ($errors->has('subject'))
                                            <span class="text-danger">{{ $errors->first('subject') }}</span>
                                @endif
                            </div>
                            <div class="control-group">
                                <textarea class="form-control border-0 py-3 px-4" rows="5" name="message" id="message" placeholder="Message" required="required" data-validation-required-message="Please enter your message"></textarea>
                                <p class="help-block text-danger"></p>
                                @if ($errors->has('message'))
                                            <span class="text-danger">{{ $errors->first('message') }}</span>
                                 @endif
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary py-3 px-5" type="submit" id="sendMessageButton">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
