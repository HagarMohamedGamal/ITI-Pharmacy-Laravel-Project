
@extends('layouts.app')

@section('content')
<h1>show</h1>


<div class="card">
  <div class="card-header">
 Medicine Info
  </div>
  <div class="card-body">
    <strong class="card-title">name: </strong><p>{{$medicine->name}}</p>
    <strong class="card-title">email: </strong><p>{{$medicine->type}}</p>
      <strong class="card-title">area: </strong><p>{{$medicine->quantity}}</p>
      <strong class="card-title">priority: </strong><p>{{$medicine->price}}</p>
  </div>
</div>





@endsection
