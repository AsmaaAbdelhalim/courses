@extends('layouts.admin')

@section('content')

<br><br>
    <div class="">
    <h1 class="m-0 text-white display-4 text-center"><span class="text-danger">Hotels</span></h1>
    </div>

<div class="container">
    <div class="row">

        @foreach ($data as $item)
        
                  <h4 class="card-title">name{{$item->name}}</h4>
                  
                  <h5><b>Price : </b>EGP {{$item->price}}</h4>
            <a
            href="{{route ('course.show',[$item->id])}}"
             class="btn btn-info "
            style="width:10%;">
              Details
            </a>
            <a
            href="{{route ('course.edit',[$item->id])}}"
             class="btn btn-info "
            style="width:10%;">
             edit
            </a>
            <form action="{{route('course.destroy',[$item->id])}}" method='POST'> 
                @csrf
                @method('DELETE')
                        <button type="submit" class="btn btn-danger"  style="width:10%;">Delete</button> 
                      </form>
        </div>
    </div>

    @endforeach
    </div>
    </div>
    @endsection