@extends('layouts.app')

@section('content')
<h1>show</h1>


<div class="card">
  <div class="card-header">
    Area Info
  </div>
  <div class="card-body">
    <strong class="card-title">Name: </strong>
    <p>{{$areas->name}}</p>
    <strong class="card-title">Address: </strong>
    <p>{{$areas->address}}</p>
  </div>
</div>

@endsection