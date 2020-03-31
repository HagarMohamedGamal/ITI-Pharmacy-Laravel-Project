
@extends('layouts.app')

@section('content')
<h1>show</h1>


<div class="card">
  <div class="card-header">
  pharmacy Info
  </div>
  <div class="card-body">
    <strong class="card-title">name: </strong><p>{{$pharmacy->name}}</p>
    <strong class="card-title">email: </strong><p>{{$pharmacy->email}}</p>
  </div>
</div>


<div class="card mt-5">
  <div class="card-header">
  pharmacy details Info
  </div>
  <div class="card-body">
    <strong class="card-title">area: </strong><p>{{$pharmacy->area_id}}</p>
    <strong class="card-title">priority: </strong><p>{{$pharmacy->priority}}</p>
    <strong class="card-title">national id: </strong><p>{{$pharmacy->national_id}} </p>
  </div>
</div>


@endsection