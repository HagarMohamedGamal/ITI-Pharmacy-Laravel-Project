
@extends('layouts.app')

@section('content')
<h1>index</h1>
<a class="btn btn-info btn-lg btn-block mb-5" href="{{route('medicines.create')}}">Add Medicine</a>
<table class="table table-dark text-center">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Type</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>

    </tr>
  </thead>
  <tbody>
      @foreach($medicines as $medicine)
        <tr>
        <th scope="row">{{$medicine->id}}</th>
        <td>{{$medicine->name}}</td>
        <td>{{$medicine->type}}</td>

        <td>{{$medicine->quantity}}</td>


        <td>
            <a class="btn btn-success btn-sm" href="{{route('medicines.show', [ 'medicine' => $medicine->id ])}}">Show</a>
            <a class="btn btn-warning btn-sm" href="{{route('medicines.edit', [ 'medicine' => $medicine->id ])}}">Update</a>
            <a class="btn btn-danger btn-sm"  data-toggle="modal" data-target="#exampleModalLong{{$medicine->id}}">Delete</a>



            <div class="modal text-danger" id="exampleModalLong{{$medicine->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Medicine</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-dark">
                            <p>Are you sure you want to delete this post?</p>
                        </div>
                        <div class="modal-footer text-white">
                            <form class="" action="{{route('medicines.destroy', ['medicine' => $medicine->id])}}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">Yes</button>
                            </form>
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
