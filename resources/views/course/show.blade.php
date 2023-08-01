@extends('layouts.app')

@section('content')

{{$data->name}}
{{$data->price}}


<form action="" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{$data->id}}">

    <button type="submit" class="btn btn-primary">Add to Cart</button>
</form>


@endsection