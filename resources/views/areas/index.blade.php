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
            <a href="{{route('areas.create')}}" class="btn btn-info float-right"><i class="fas fa-plus"></i>Add Area</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered" id="areas">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Actions</th>
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
<script>
  $(document).ready(function() {
        $('#areas').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: "{{ url('/areas') }}",
          columns: [{
              data: 'id',
              name: 'id'
            },
            {
              data: 'name',
              name: 'name'
            },
            {
              data: 'address',
              name: 'address'
            },
            {
              data: 'action',
              name: 'action'
            },
          ]
        });
      })
</script>

@endsection