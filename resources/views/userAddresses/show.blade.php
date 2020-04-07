@extends('layouts.app')

@section('content')
<h1>show</h1>


<div class="card">
  <div class="card-header">
    User Address Info
  </div>
  <div class="card-body">
    <strong class="card-title">area_id: </strong>
    <p>{{$address->area_id}}</p>
    <strong class="card-title">street_name: </strong>
    <p>{{$address->street_name}}</p>
    <strong class="card-title">build_no: </strong>
    <p>{{$address->build_no}}</p>
    <strong class="card-title">floor_no: </strong>
    <p>{{$address->floor_no}}</p>
    <strong class="card-title">flat_no: </strong>
    <p>{{$address->flat_no}}</p>
    <strong class="card-title">is_main: </strong>
    <p>{{$address->is_main}}</p>
    <strong class="card-title">client_id: </strong>
    <p>{{$address->client->type->name}}</p>
  </div>
</div>

@endsection