@extends('layouts.app')

@section('content')

<div class="container-fluid">

  <div align="right">
    <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Record</button>
  </div>
  <br />
  <div class="table-responsive">
    <table class="table table-bordered table-striped" id="order_table">
      <thead>
        <tr>
          <th width="15%">user_id</th>
          <th width="15%">doctor_id</th>
          <th width="20%">status</th>
          <th width="20%">creator_type</th>
          <th width="30%">Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th width="15%"></th>
          <th width="15%"></th>
          <th width="20%"></th>
          <th width="20%"></th>
          <th width="30%"></th>

        </tr>
      </tfoot>
    </table>
  </div>
  <br />
  <br />
</div>
<div id="formModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Record</h4>
      </div>
      <div class="modal-body">
        <span id="form_result"></span>
        <form method="post" id="sample_form" class="form-horizontal form-inline" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4">user_id</label>
            <div class="col-md-8">
              <input type="text" name="user_id" id="user_id" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">useraddress_id </label>
            <div class="col-md-8">
              <input type="text" name="useraddress_id" id="useraddress_id" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">doctor_id </label>
            <div class="col-md-8">
              <input type="text" name="doctor_id" id="doctor_id" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">is_insured </label>
            <div class="col-md-8">
              <input type="text" name="is_insured" id="is_insured" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">status </label>
            <div class="col-md-8">
              <input type="text" name="status" id="status" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">creator_type </label>
            <div class="col-md-8">
              <input type="text" name="creator_type" id="creator_type" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">pharmacy_id </label>
            <div class="col-md-8">
              <input type="text" name="pharmacy_id" id="pharmacy_id" class="form-control" />
            </div>
          </div>
            <div class="form-group">
                <label class="control-label col-md-4">Medicines </label>
                <select class="form-control select2" multiple="multiple" required id="medicine_select" name="medicine_select[]">
                        @foreach($medicines as $medicine)
                            <option value="{{$medicine['id']}}">{{$medicine['name']}}</option>
                        @endforeach
                </select>
            </div>
          <div class="form-group">
            <label class="control-label col-md-4">Actions </label>
            <div class="col-md-8">
              <input type="text" name="Actions" id="Actions" class="form-control" />
            </div>
          </div>
          <br />
          <div class="form-group" align="center">
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
          </div>
        </form>
      </div>
    </div>
  </div>
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


<script>
  $(document).ready(function() {
       $(".select2").select2({
       });

    $('#order_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{route('orders.index')}}",
      },

      columns: [{

          data: 'user_id',
          name: 'user_id',

        },
        {
          data: 'doctor_id',
          name: 'doctor_id',
        },
        {
          data: 'status',
          name: 'status'
        },
        {

          data: 'creator_type',
          name: 'creator_type'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable:false,
        }
      ]
    });
    $('#order_table tfoot th').each(function() {
      var title = $(this).text();
      $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    // DataTable
    var table = $('#order_table').DataTable();

    // Apply the search
    table.columns().every(function() {
      var that = this;

      $('input', this.footer()).on('keyup change clear', function() {
        if (that.search() !== this.value) {
          that
            .search(this.value)
            .draw();
        }
      });
    });

    $('#create_record').click(function() {
      $('.modal-title').text("Add New Record");
      $('#action_button').val("Add");
      $('#action').val("Add");
      $('#formModal').modal('show');
    });
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#sample_form').on('submit', function(event) {
      event.preventDefault();
      if ($('#action').val() == 'Add') {
        $.ajax({
          url: "{{ route('orders.store') }}",
          method: "POST",
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          dataType: "json",
          success: function(data) {
            var html = '';
            if (data.errors) {
              html = '<div class="alert alert-danger">';
              for (var count = 0; count < data.errors.length; count++) {
                html += '<p>' + data.errors[count] + '</p>';
              }
              html += '</div>';
            }
            if (data.success) {
              html = '<div class="alert alert-success">' + data.success + '</div>';
              $('#sample_form')[0].reset();
              $('#order_table').DataTable().ajax.reload();
            }
            $('#form_result').html(html);
          }
        })
      }

      if ($('#action').val() == "Edit") {
        // id = $('#hidden_id').val();
        $.ajax({
          url: "/orders",
          type: "PUT",
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          dataType: "json",


          success: function(data) {
            var html = '';
            if (data.errors) {
              html = '<div class="alert alert-danger">';
              for (var count = 0; count < data.errors.length; count++) {
                html += '<p>' + data.errors[count] + '</p>';
              }
              html += '</div>';
            }
            if (data.success) {
              html = '<div class="alert alert-success">' + data.success + '</div>';
              $('#sample_form')[0].reset();
              $('#store_image').html('');
              $('#order_table').DataTable().ajax.reload();
            }
            $('#form_result').html(html);
          }

        });
      }



    });
    $(document).on('click', '.edit', function() {
      var id = $(this).attr('id');
      $('#form_result').html('');
      $.ajax({
        url: "/orders/" + id + "/edit",
        dataType: "json",
        success: function(html) {
          $('#user_id').val(html.data.user_id);
          $('#useraddress_id').val(html.data.useraddress_id);
          $('#doctor_id').val(html.data.doctor_id);
          $('#is_insured').val(html.data.is_insured);
          $('#status').val(html.data.status);
          $('#creator_type').val(html.data.creator_type);
          $('#pharmacy_id').val(html.data.pharmacy_id);
          $('#Actions').val(html.data.Actions);
          console.log(html.medicine_ids);
          $('#medicine_select').val( html.medicine_ids).trigger('change');
          $('#hidden_id').val(html.data.id);;
          $('.modal-title').text("Edit New Record");
          $('#action_button').val("Edit");
          $('#action').val("Edit");
          $('#formModal').modal('show');
        }
      })
    });
    var order_id;

    $(document).on('click', '.delete', function() {
      order_id = $(this).attr('id');
      $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function() {
      // console.log(order_id);

      $.ajax({
        url: "/orders/" + order_id,
        method: "DELETE",
        beforeSend: function() {
          $('#ok_button').text('Deleting...');
        },
        success: function(data) {
          setTimeout(function() {
            $('#confirmModal').modal('hide');
            $('#order_table').DataTable().ajax.reload();
          }, 2000);
        }
      })
    });


  });
</script>
@endsection
