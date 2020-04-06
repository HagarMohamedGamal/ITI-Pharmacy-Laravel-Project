<!DOCTYPE html>
 
<html lang="en">
<head>
<title>Install DataTables in Laravel - Tutsmake.com</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>
      <body>
         <div class="container">
               <h2>Laravel DataTable - Tuts Make</h2>
            <table class="table table-bordered" id="pharmacy_datatable">
               <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Image</th>
                    <th scope="col">National ID</th>
                    <th scope="col">Area ID</th>
                    <th scope="col">priority</th>
                    <th scope="col">Action</th>
                  </tr>
               </thead>
            </table>
         </div>
   <script>
   $(document).ready( function () {
    $('#pharmacy_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('/pharmacies/users-list') }}",
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'avatar', name: 'avatar' },
                    { data: 'area_id', name: 'area_id' },
                    { data: 'priority', name: 'priority' },
                    { data: 'national_id', name: 'national_id' },
                    { data: 'action', name: 'action' },
                 ]
        });
     });
  </script>
   </body>
</html>