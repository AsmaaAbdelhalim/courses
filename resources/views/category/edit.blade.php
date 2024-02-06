@extends('layouts.admin')
@section('content')
@section('css')
    <style>
        select optgroup {
            text-indent: 0.5em;
            margin: 0;
            padding: 0;
            border: 2px solid red;
        }
    </style>
@show
<div class="animated fadeIn">
    <div class="row">
        <div class="col-lg-10 m-auto py-2">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Edit Category</strong>
                </div>
                <div class="card-body">
                    <!-- Credit Card -->
                    <div id="pay-invoice">
                        <div class="card-body">
    <form action="{{route('category.update',[$category->id])}}" method="POST" enctype="multipart/form-data">
     @csrf
     @method('put')

     <div class="container">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Category Name</label>
      <input type="text" class="form-control" id="name"  name="name" placeholder="category_name">
    </div>
    <div class="form-group col-md-12">
      <label for="description">Description</label>
      <textarea 
      class="form-control" id="description" name="description" placeholder="description"></textarea>
    </div>
        <div class="form-group has-success">
         <label for="status" class="control-label mb-6">Category Image</label>
         <input type="file" name="image" id="image" class="form-control">
          </div>
          <br>
        <button type="submit" class="btn btn-lg btn-success">Update</button>
        <a href="/course" class="btn btn-lg btn-danger">Cancel</a>
          </div>
          </form>
           </div>
            </div>
            </div>
            </div> 
        </div>
    </div>


@endsection
