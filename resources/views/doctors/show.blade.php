@extends('layouts.app')
@section('content')

<div class="card" style="width: 18rem;">
  <div class="card-body">
    <p class="card-text">{{$doctor->name}}</p>
    <p class="card-text">{{$doctor->email}}</p>
    <p class="card-text">{{$doctor->is_baned}}</p>
  </div>
</div>

@endsection