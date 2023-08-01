edit



<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Hotel</h4>
                </div>
                <div class="card-body">
                   <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('course.update',[$data->id])}}" method="POST">
                            {{ csrf_field() }}
                            {{method_field('PUT')}}
                            <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Name</label>
                                    <input type="text"  name="name" class="@error('name') is-invalid @enderror form-control" value="{{$data->name}}">
                                    @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">Enter Your Name Correct</div>
                                    @enderror

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Price</label>
                                <input type="text"  name="price" class="@error('price') is-invalid @enderror form-control"value="{{$data->price}}">
                                @error('price')
                                <div class="alert alert-danger mt-1 mb-1">Enter Your Price</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Update</button>
                            <!-- //<a href="/custhotel" class="btn btn-danger">Cancel</a> -->
                        </form>
                    </div>
                   </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
