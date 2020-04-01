
@extends('layouts.app')

@section('content')

<div class="w-90 container-fullwidth mx-5 mt-4">
  <div class="card">
    <div class="card-header">
     <span class="font-weight-bold">Order Info</span>
    </div>
    <div class="card-body">
      <p class=" card-text"><span class="font-weight-bold">id:-</span> {{$order->id}}</p>
      <p class=" card-text"><span class="font-weight-bold">order user name:-</span> {{$order->order_user_name}}</p>
      <p class=" card-text"><span class="font-weight-bold">doctor name:-</span> {{$order->doctor_name}}</p>
      <p class=" card-text"><span class="font-weight-bold">delivering address:-</span> {{$order->delivering_address}}</p>
      <p class=" card-text"><span class="font-weight-bold">status:-</span> {{$order->status}}</p>
      <p class=" card-text"><span class="font-weight-bold">creator type:-</span> {{$order->creator_type}}</p>
      <p class=" card-text"><span class="font-weight-bold">assigned pharmacy name:-</span> {{$order->assigned_pharmacy_name}}</p>
      <p class=" card-text"><span class="font-weight-bold">action:-</span> {{$order->Actions}}</p>
      <p class=" card-text"><span class="font-weight-bold">is insured:-</span> {{$order->is_insured}}</p>
      <p class=" card-text"><span class="font-weight-bold">created at:-</span> {{$order->created_at}}</p>
      <p class=" card-text"><span class="font-weight-bold">updated at:-</span> {{$order->updated_at}}</p>
    
    </div>
  </div>  
</div>
@endsection
