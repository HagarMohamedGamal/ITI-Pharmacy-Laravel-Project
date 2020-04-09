@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-body">
    <p class="card-text">AVATAR: <img src="{{($client->avatar) ? URL::asset("$client->avatar") :  URL::asset("storage/avatars/default.jpg")}}" width=200 height=200 alt="nop"></p>
    <p class="card-text">NAME: {{$client->type->name}}</p>
    <p class="card-text">EMAIL: {{$client->type->email}}</p>
    <p class="card-text">NATIONAL ID: {{$client->national_id}}</p>
    <p class="card-text">BIRTHDAY: {{$client->birth_day}}</p>
    <p class="card-text">MOBILE: {{$client->mobile}}</p>
    <p class="card-text">GENDER: {{$client->gender}}</p>
  </div>
</div>

@endsection