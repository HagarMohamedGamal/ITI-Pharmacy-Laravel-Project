@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-body">
    <p class="card-text">ID: {{$doctor->id}}</p>
    <p class="card-text">AVATAR: <img src="{{URL::asset("$doctor->avatar")}}" width=200 height=200 alt="nop"></p>
    <p class="card-text">NAME: {{$doctor->type->name}}</p>
    <p class="card-text">EMAIL: {{$doctor->type->email}}</p>
    <p class="card-text">NATIONAL ID: {{$doctor->national_id}}</p>
    <p class="card-text">PHARMACY NAME: {{$doctor->pharmacy->type->name}}</p>
    <p class="card-text">IS BANED: {{$doctor->is_baned}}</p>
  </div>
</div>

@endsection