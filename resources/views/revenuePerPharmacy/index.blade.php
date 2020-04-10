
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

            </table>
      </div>


      <script type="text/javascript">
      $(document).ready(function() {
           $('#reveueTable').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax": "{{ route('ajaxdata.getdata') }}",
              "columns":[
                  { "data": "id" },
                  { "data": "name" },
                  { "data": "totalOrders" },
                  { "data": "totalRevenue" }
              ]
           });
      });
      </script>
@endsection
