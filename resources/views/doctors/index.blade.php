@extends('layouts.app')
@section('content')
<h1>Doctors Data</h1>
<a href="{{route('doctors.create')}}" class="btn btn-primary m-5">Create Doctor</a>
<div class="container">
<table class="table">
    <thead class="thead-dark">
        <tr>
        <th scope="col">name</th>
        <th scope="col">email</th>
        <th scope="col">is_baned</th>
        <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($doctors as $doctor)
            <tr>
            <td>{{$doctor->name}}</td>
            <td>{{$doctor->email}}</td>
            <td>{{$doctor->is_baned}}</td>
            
            
                <td><a href="{{route('doctors.show', ['doctor' => $doctor->id])}}" class="btn btn-primary btn-success">View</a>
                <a href="{{route('doctors.edit', ['doctor' => $doctor->id])}}" class="btn btn-primary btn-warning">Edit</a>
                

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-danger" data-toggle="modal" data-target="#exampleModal_{{$doctor->id}}">
                Delete
            </button></td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal_{{$doctor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deleteing Doctor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this doctor?!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><span id="delete_{{$doctor->id}}">Close</span></button>
                    <form action="{{route('doctors.destroy', ['doctor' => $doctor->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary delete_{{$doctor->id}}">Confirm Delete</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
        @endforeach
        <tbody>
    </table>
</div>
@endsection
