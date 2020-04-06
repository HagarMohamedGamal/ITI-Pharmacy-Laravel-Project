@extends('layouts.app')
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <form method="POST" action="{{route('areas.update', $areas->id)}}" enctype="multipart/form-data">
    @method('PUT')
     @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Name</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="{{$areas->name}}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Address</label>
            <input type="text" name="address" class="form-control" id="exampleFormControlInput1" value="{{$areas->address}}">
        </div>
        <button class="btn btn-success m-3" type="submit">Submit New Post</button>
    </form>
</div>

@endsection