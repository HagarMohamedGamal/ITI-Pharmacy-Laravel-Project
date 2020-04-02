@extends('layouts.app')
@section('content')
<div class="container">

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">DataTable with default features</h3>
              <a href="{{route('doctors.create')}}" class="btn btn-info float-right"><i class="fas fa-plus"></i>Create Doctor</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">avatar</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">national id</th>
                    <th scope="col">pharmacy name</th>
                    <th scope="col">is_baned</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                    <tr>
                        <td>{{$doctor->id}}</td>
                        <td>{{$doctor->avatar}}</td>
                        <td>{{$doctor->name}}</td>
                        <td>{{$doctor->email}}</td>
                        <td>{{$doctor->national_id}}</td>
                        <td>{{$doctor->pharmacy_name}}</td>
                        <td>{{$doctor->is_baned}}</td>
                        <td>
                            <a href="{{route('doctors.show', ['doctor' => $doctor->id])}}" class="btn btn-primary btn-success"><i class="fas fa-eye"></i></a>
                            <a href="{{route('doctors.edit', ['doctor' => $doctor->id])}}" class="btn btn-primary btn-warning"><i class="fas fa-edit text-white"></i></a>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-danger" data-toggle="modal" data-target="#exampleModal_{{$doctor->id}}">
                            <i class="fas fa-trash"></i>
                            </button>
                        </td>
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
                <tfoot>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">avatar</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">national id</th>
                    <th scope="col">pharmacy name</th>
                    <th scope="col">is_baned</th>
                    <th scope="col">Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

</div>
@endsection
