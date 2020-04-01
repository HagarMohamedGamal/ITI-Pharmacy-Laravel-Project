
@extends('layouts.app')

@section('content')
<h1>create</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form  method="POST" action="{{route('medicines.store')}}" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    <label for="exampleFormControlInput1">Name</label>
    <input type="text" class="form-control" name="name">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">type</label>
    <input type="text" class="form-control" name="type">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">quantity</label>
      <input type="text" class="form-control" name="quantity">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">price</label>
      <input type="text" class="form-control" name="price">
  </div>

    <button type="submit" class="btn btn-primary mt-5">Submit</button>


</form>


@endsection
