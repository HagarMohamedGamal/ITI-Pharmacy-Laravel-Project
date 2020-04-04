@extends('layouts.app')
@section('content')

<div class="card" style="width: 18rem;">
  <div class="card-body">
    <p class="card-text">ID: {{$doctor->id}}</p>
    <p class="card-text">AVATAR: {{$doctor->avatar}}</p>
    <p class="card-text">NAME: {{$doctor->type->name}}</p>
    <p class="card-text">EMAIL: {{$doctor->type->email}}</p>
    <p class="card-text">NATIONAL ID: {{$doctor->national_id}}</p>
    <p class="card-text">PHARMACY NAME: {{$doctor->pharmacy_name}}</p>
    <p class="card-text">IS BANED: {{$doctor->is_baned}}</p>
  </div>
</div>

@endsection