@extends('layouts.app')

@section('content')

<div class="container-fluid">

  @hasanyrole('doctor|super-admin|pharmacy')
  <div align="right">
    <a type="button" href="/orders/create" class="btn btn-success btn-sm">New Order</a>
  </div>
  @endhasanyrole
  <br />
  <div class="table-responsive">
    <table class="table table-bordered table-striped" style="width:100%" id="order_table">
      <thead>
        <tr>
          <th>ID</th>
          <th>user</th>
          <th>Address</th>
          <th>Creation Date</th>
          <th>Doctor</th>
          @role('super-admin')
          <th>pharmacy</th>
          <th>creator</th>
          @endrole
          <th>Insured</th>
          <th>status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>

        </tr>
      </tfoot>
    </table>
  </div>
  <br />
  <br />
</div>

<div id="confirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Confirmation</h2>
      </div>
      <div class="modal-body">
        <h4 align="center" style="margin:0;">Are you sure you want to remove this order?</h4>
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
    $(".select2").select2({});
    if ("{{auth()->user()->hasRole('super-admin')}}") {
      $('#order_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{route('orders.index')}}",
        },

        columns: [{

            data: 'id',
            name: 'id',

          }, {

            data: 'user.type.name',
            name: 'user.type.name',

          },
          {

            data: "Address",
            name: 'Address',
            render: function(data, type, row) {
              return row.address.area.address + ' ,' + row.address.area.name + ' ,' + row.address.street_name;
            },



          },
          {

            data: 'created_at',
            name: 'created_at'
          },
          {
            data: 'doctor.type.name',
            name: 'doctor.type.name',
            render: function(data, type, row) {
              return row.doctor ? row.doctor.type.name : "";
            },

          },
          {
            data: 'pharmacy',
            name: 'pharmacy',

          },
          {
            data: 'creator',
            name: 'creator',

          },
          {
            data: 'is_insured',
            name: 'Insured',
            render: function(data, type, row) {
              return (row.is_insured == "1") ? 'yes' : 'no';


            },

          },
          {
            data: 'status',
            name: 'status'
          },

          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
          }
        ]
      });
    }

    if (!"{{auth()->user()->hasRole('super-admin')}}") {
      $('#order_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{route('orders.index')}}",
        },

        columns: [{

            data: 'id',
            name: 'id',


          }, {

            data: 'user.type.name',
            name: 'user.type.name',

          },
          {

            data: "Address",
            name: 'Address',
            render: function(data, type, row) {
              return row.address.area.address + ' ,' + row.address.area.name + ' ,' + row.address.street_name;
            },



          },
          {

            data: 'created_at',
            name: 'created_at'
          },
          {
            data: 'doctor.type.name',
            name: 'doctor.type.name',
            render: function(data, type, row) {
              return row.doctor ? row.doctor.type.name : "";
            },

          },

          {
            data: 'is_insured',
            name: 'Insured',
            render: function(data, type, row) {
              return (row.is_insured == "1") ? 'yes' : 'no';


            },

          },
          {
            data: 'status',
            name: 'status'
          },

          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
          }
        ]
      });
    }

    $('#order_table tfoot th').each(function() {
      var title = $(this).text();
      $(this).html('<input type="text" size="10" placeholder="Search ' + title + '" />');
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


    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
          $('#medicine_select').val(html.medicine_ids).trigger('change');
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
