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
    <form method="POST" action="
        {{isset($doctor)?route('doctors.update', ['doctor'=>$doctor->id]):route('doctors.store')}}" enctype="multipart/form-data">
        @csrf
        @isset($doctor)
        @method('PUT')
        @endisset
        <div class="form-group">
            <label for="exampleFormControlInput1">name</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="{{isset($doctor)?$doctor->type->name:''}}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput2">email</label>
            <input type="text" name="email" class="form-control" id="exampleFormControlInput2" value="{{isset($doctor)?$doctor->type->email:''}}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput2">password</label>
            <input type="text" name="password" class="form-control" id="exampleFormControlInput2" value="{{isset($doctor)?$doctor->type->email:''}}">
        </div>
        <select class="form-control" name="pharmacy_id">
            @foreach($pharmacies as $pharmacy)
            <option value="{{$pharmacy->id}}" {{(isset($doctor))?($doctor->pharmacy_id == $pharmacy->id)? 'selected':'' : ''}}>{{$pharmacy->type->name}}</option>
            @endforeach
        </select>
        <div class="form-group">
            <label for="exampleFormControlInput4">national id</label>
            <input type="text" name="national_id" class="form-control" id="exampleFormControlInput4" value="{{isset($doctor)?$doctor->national_id:''}}">
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="is_baned" id="exampleRadios1" value="1" {{isset($doctor)?$doctor->is_baned? "checked":'':''}}>
            <label class="form-check-label" for="exampleRadios1">
                True
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="is_baned" id="exampleRadios2" value="0" {{isset($doctor)?$doctor->is_baned? "":'checked':''}}>
            <label class="form-check-label" for="exampleRadios2">
                False
            </label>
        </div>
        <div class="form-group">
            <input type="file" name="avatar" value="{{isset($doctor)?$doctor->avatar:''}}">
        </div>
        <button class="btn btn-success m-3" type="submit">Submit New Post</button>
    </form>
</div>

@endsection