
@extends('layouts.app')

@section('content')
<h1>show</h1>


<div class="card">
  <div class="card-header">
 Medicine Info
  </div>
  <div class="card-body">
    <strong class="card-title">name: </strong><p>{{$medicine->name}}</p>
    <strong class="card-title">type: </strong><p>{{$medicine->type}}</p>
      <strong class="card-title">price: </strong><p>{{$medicine->quantity}}</p>
      <strong class="card-title">quantity: </strong><p>{{$medicine->price}}</p>
  </div>
</div>





@endsection
