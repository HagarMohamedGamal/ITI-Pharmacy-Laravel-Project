
@extends('layouts.app')

@section('content')
<h1>create</h1>

<form  method="POST" action="{{route('pharmacies.store')}}" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    <label for="exampleFormControlInput1">Name</label>
    <input type="text" class="form-control" name="name">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">email</label>
    <input type="text" class="form-control" name="email">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">area_id</label>
    <select class="form-control" name="area_id">
        @foreach($pharmacies as $pharmacy)
      <option value="{{$pharmacy->area_id}}">{{$pharmacy->area_id}}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">priority</label>
    <input type="text" class="form-control" name="priority" rows="3">
  </div>


  <div class="form-group">
    <label for="exampleFormControlSelect1">national_id</label>
    <select class="form-control" name="national_id">
        @foreach($pharmacies as $pharmacy)
      <option value="{{$pharmacy->national_id}}">{{$pharmacy->national_id}}</option>
      @endforeach
    </select>
  </div>

  <div class="">
    <label class="" for="inputGroupFile02"><strong>Choose file</strong></label>
    <input type="file" name="avatar" class="" id="inputGroupFile02">
  </div>


    <button type="submit" class="btn btn-primary mt-5">Submit</button>


</form>


@endsection