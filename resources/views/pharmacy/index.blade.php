@extends('layouts.app')

@section('content')

<div class="container">
  <h1><strong>Pharmacy</strong></h1>
  <div class="d-flex flex-row-reverse">
    <a class="btn btn-info mb-1" href="{{route('pharmacies.create')}}">Add Pharmacy</a>
  </div>
  <div class="d-flex flex-row-reverse mb-3">
    <a class="btn bg-gradient-danger" href="{{route('pharmacies.readsoftdelete')}}">Show Deleted Pharmacies</a>
  </div>

  <div class="table-responsive">
    <table id="pharmacyIndextable" class="table table-bordered data-table text-center display compact">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Image</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">National ID</th>
          <th scope="col">Area ID</th>
          <th scope="col">priority</th>
          <th scope="col">Action</th>
        </tr>
      </thead>

    </table>
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



</div>


<script type="text/javascript">
  $(document).ready(function() {
    $('#pharmacyIndextable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: "{{ url('/pharmacies') }}",
      columns: [{
          data: 'id',
          name: 'id'
        },
        {
          data: 'avatar',
          name: 'avatar',
          render: function(data, type, full, meta) {
            return "<img src={{ URL::to('/') }}/images/" + data + " width='70' class='img-thumbnail' />";
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
          data: 'area_id',
          name: 'area_id'
        },
        {
          data: 'priority',
          name: 'priority'
        },
        {
          data: 'national_id',
          name: 'national_id'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false
        },
      ]
    });


    let pharmacy_id;

    $(document).on('click', '.delete', function() {
      pharmacy_id = $(this).attr('id');
      $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function() {
      $.ajax({
        url: "/pharmacies/" + pharmacy_id + "/softdelete",
        beforeSend: function() {
          $('#ok_button').text('Deleting...');
        },
        success: function(data) {
          setTimeout(function() {
            $('#confirmModal').modal('hide');
            $('#ok_button').text('OK');
            $('#pharmacyIndextable').DataTable().ajax.reload();
          }, 2000);
        }
      })
    });




  });
</script>

@endsection