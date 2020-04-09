
@extends('layouts.app')

@section('content')
      <div class="container m-5 mx-auto">
          <table id="reveueTable" class="table table-bordered data-table text-center display">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">name</th>
                  <th scope="col">total Orders</th>
                  <th scope="col">total Revenue</th>


                </tr>
              </thead>

              <tfoot>
                <tr>
                  <th ></th>
                  <th ></th>
                  <th ></th>
                  <th ></th>

                </tr>
              </tfoot>

            </table>
      </div>


      <script type="text/javascript">
    $(document).ready(function() {
       $('#reveueTable').DataTable({
              "processing": true,
              "responsive": true,
              "searchable": false,


              "ajax": "{{ route('ajaxdata.getAllData') }}",
              "columns":[
                  { "data": "id" },
                  { "data": "name" },
                  { "data": "totalOrders" },
                  { "data": "totalRevenue" }
              ]
           });

      $('#reveueTable tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
      });
      var table = $('#reveueTable').DataTable();
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
      $("#reveueTable_filter").css("visibility","hidden");

    });
      </script>
@endsection
