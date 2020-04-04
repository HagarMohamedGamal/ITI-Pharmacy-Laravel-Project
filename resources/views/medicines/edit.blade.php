
@extends('layouts.app')

@section('content')
<h1>edit</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form  method="post" action="{{route('medicines.update', $medicine->id)}}" enctype="multipart/form-data">
      @method('PUT')
     @csrf
    <div class="form-group">
    <label for="exampleFormControlInput1">Name</label>
    <input type="text" class="form-control" name="name" value="{{$medicine->name}}">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">type</label>
    <input type="text" class="form-control" name="type" value="{{$medicine->type}}">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">quantity</label>
      <input type="text" class="form-control" name="quantity" value="{{$medicine->quantity}}">
  </div>



    <div class="form-group">
        <label for="exampleFormControlInput1">price</label>
        <input type="text" class="form-control" name="price" value="{{$medicine->price}}">
    </div>


    <button type="submit" class="btn btn-primary mt-5">Submit</button>


</form>





@endsection
