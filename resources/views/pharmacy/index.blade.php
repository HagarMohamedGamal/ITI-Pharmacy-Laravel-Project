@extends('layouts.app')

@section('content')
<h1><strong>Pharmacy</strong></h1>
  <div class="d-flex flex-row-reverse">
    <a class="btn btn-info mb-1" href="{{route('pharmacies.create')}}">Add Pharmacy</a>
  </div>
  <div class="d-flex flex-row-reverse mb-3">
    <a class="btn bg-gradient-danger" href="{{route('pharmacies.readsoftdelete')}}">Show Deleted Pharmacies</a>
  </div>
<table id="mytable" class="table table-bordered data-table text-center display compact">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Image</th>
      <th scope="col">National ID</th>
      <th scope="col">Area ID</th>
      <th scope="col">priority</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

      @foreach($pharmacies as $pharmacy)
        <tr id="{{$pharmacy->id}}">
        <th scope="row">{{$pharmacy->id}}</th>
        <td>{{$pharmacy->type ? $pharmacy->type->name :"no" }}</td>
        <td>{{$pharmacy->type ? $pharmacy->type->email : "no"}}</td>
        <th scope="col"><img src="{{asset('/storage/'.$pharmacy->avatar)}}" width="30px" height="30px"></th>
        <td>{{$pharmacy->national_id}}</td>
        <td>{{$pharmacy->area_id}}</td>
        <td>{{$pharmacy->priority}}</td>
        <td>
            <a class="btn btn-success btn-sm" href="{{route('pharmacies.show', [ 'pharmacy' => $pharmacy->id ])}}">Show</a>
            <a class="btn btn-warning btn-sm" href="{{route('pharmacies.edit', [ 'pharmacy' => $pharmacy->id ])}}">Update</a>
            <a class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#exampleModalLong{{$pharmacy->id}}">Delete</a>
       


<div class="modal text-danger" id="exampleModalLong{{$pharmacy->id}}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark">
        <p>Are you sure you want to delete this Pharmacy?</p>
      </div>
      <div class="modal-footer text-white">

            <button class="btn btn-danger softDeleteRecord" id="{{ $pharmacy->id }}" data-id="{{ $pharmacy->id }}" data-toggle="modal" data-target="#exampleModalLong{{$pharmacy->id}}">Yes</button>
          
        <a type="button" class="btn btn-secondary" data-dismiss="modal">No</a>
      </div>
    </div>
  </div>
</div>


          
        </td>
        </tr>
      @endforeach
  </tbody>
</table>
 


@endsection