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
            <table class="table table-bordered" id="example1">
              <thead>
                  <tr>
                      <th>id</th>
                      <th>name</th>
                      <th>email</th>
                      <th>national id</th>
                      <th>pharmacy name</th>
                      <th>action</th>
                  </tr>
              </thead>
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



<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('/js/doctors.js')}}"></script>

@endsection
