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
              <a href="{{route('useraddresses.create')}}" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add user address</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered" id="useraddress">
              <thead>
                  <tr>
                      <th>Id</th>
                      <th>area id</th>
                      <th>street name</th>
                      <th>building no.</th>
                      <th>floor no.</th>
                      <th>flat no.</th>
                      <th>is main</th>
                      <th>client id</th>
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
    $('#useraddress').DataTable();
</script>

@endsection
