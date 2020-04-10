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
          <div id="update_ban">
            <div class="card-body">
              <table class="table table-bordered" id="doctorIndextable">
                <thead>
                  <tr>
                    <th>id</th>
                    <th>avatar</th>
                    <th>name</th>
                    <th>email</th>
                    <th>national id</th>
                    @role('pharmacy')
                    @else
                    <th>pharmacy name</th>
                    @endrole
                    <th>created at</th>
                    <th>action</th>
                  </tr>
                </thead>
              </table>
            </div>

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



<script type="text/javascript">
  $(function() {
    if ("{{auth()->user()->hasrole('pharmacy')}}") {
      table = $("#doctorIndextable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '/doctors'
        },
        columns: [{
            data: 'id',
            name: 'id'
          },
          {
            data: 'avatar',
            name: 'avatar',
            render: function(data, type, full, meta) {
              return "<img src={{ URL::asset('/storage/images') }}/" + data + " width='70' class='img-thumbnail' />";
            }
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'email',
            name: 'email'
          },
          {
            data: 'national_id',
            name: 'national_id'
          },
          {
            data: 'created_at',
            name: 'created_at'
          },
          {
            data: 'action',
            name: 'action'
          },
        ]
      });
    } else {
      table = $("#doctorIndextable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '/doctors'
        },
        columns: [{
            data: 'id',
            name: 'id'
          },
          {
            data: 'avatar',
            name: 'avatar',
            render: function(data, type, full, meta) {
              return "<img src={{ URL::asset('/storage/images') }}/" + data + " width='70' class='img-thumbnail' />";
            }
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'email',
            name: 'email'
          },
          {
            data: 'national_id',
            name: 'national_id'
          },
          {
            data: 'pharmacy_id',
            name: 'pharmacy_id'
          },
          {
            data: 'created_at',
            name: 'created_at'
          },
          {
            data: 'action',
            name: 'action'
          },
        ]
      });
    }




    $(document).on('click', '.delete', function() {
      doctor_id = $(this).attr('id');

      const token = $('meta[name="csrf-token"]').attr('content');
      console.log(token);
      $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function() {
      const token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url: "/doctors/" + doctor_id,
        type: "delete",
        data: {
          'id': doctor_id,
          '_token': token,
        },
        beforeSend: function() {
          $('#ok_button').text('Deleting...');
        },
        success: function(data) {
          setTimeout(function() {
            $('#confirmModal').modal('hide');
            $('#ok_button').text('OK');
            $('#doctorIndextable').DataTable().ajax.reload();
          }, 2000);
        }
      })
    });

    $(document).on('click', '.ban', function() {
      doctor_id = $(this).attr('id');

      const token = $('meta[name="csrf-token"]').attr('content');
      console.log(doctor_id);
      $.ajax({
        url: "/doctors/updateajax/" + doctor_id,
        type: "POST",
        data: {
          '_token': token,
        },
        success: function(data) {
          let ban = data.is_baned;
          banclass = ban ? "btn-dark" : "btn-secondary";
          $("button#" + doctor_id).addClass(banclass);
          $('#doctorIndextable').DataTable().ajax.reload();

        },
        error: function(ev) {
          console.log(ev.responseText);
        }
      })
    })



  });
</script>


@endsection