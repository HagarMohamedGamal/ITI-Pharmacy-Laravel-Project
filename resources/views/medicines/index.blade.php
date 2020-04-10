@extends('layouts.app')
@section('content')
<div class="container">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Medicine Table</h3>
                        <a href="javascript:void(0)" class="btn btn-info float-right" id="create_model"><i class="fas fa-plus"></i>Create medicine</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered datatable" id="medicine_table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>type</th>
                                    <th>price</th>

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
<!-- Modal -->
<div id="delete_medicine_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deleteing Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this medicine?!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dangar" id="confirm_delete"><span class="delete">Confirm</span></button>
                <button type="button" class="btn btn-defualt" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Create Medicine  Modal -->
<div class="modal" id="CreateMedicineModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Medicine Create</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Product was added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="Name">Price:</label>
                    <input type="text" class="form-control" name="price" id="price">
                </div>
                <div class="form-group">
                    <label for="Name">Type:</label>
                    <input class="form-control" name="type" id="type">

                </div>


            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitCreateMedicineForm">Create</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Product Modal -->
<div class="modal" id="EditMedicineModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Medicine Edit</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Medicine was added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditMedicineModalBody">

                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitEditMedicineForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var medicine_id;

    function editMedicine(id) {
        medicine_id = id;
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        // id = $(this).data('id');
        $.ajax({
            url: "medicines/" + id + "/edit",
            method: 'GET',
            // data: {
            //     id: id,
            // },
            success: function(result) {
                console.log(result);
                $('#EditMedicineModalBody').html(result.html);
                $('#EditMedicineModal').show();
            }
        });
    }
    $(document).ready(function() {
        // init datatable.
        $(".select2").select2({});
        $('#medicine_table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 5,
            // scrollX: true,
            "order": [
                [0, "desc"]
            ],
            ajax: "{{ route('get-medicines-datatable') }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'price',
                    name: 'price'
                },

                {
                    data: 'Actions',
                    name: 'Actions',
                    orderable: false,
                    serachable: false,
                    sClass: 'text-center'
                },
            ]
        });
    });

    // Create product Ajax request.
    $('#create_model').click(function(e) {

        $('#name').val("");
        $('#price').val("");

        $('#type').val("");
        $('#CreateMedicineModal').modal('show');

    });

    $('#SubmitCreateMedicineForm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('medicines.store') }}",
            method: 'post',
            data: {
                name: $('#name').val(),
                price: $('#price').val(),
                type: $('#type').val(),

            },
            success: function(result) {
                if (result.errors) {
                    $('.alert-danger').html('');
                    $.each(result.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>' + value + '</li></strong>');
                    });
                } else {
                    $('.alert-danger').empty();
                    $('.alert-success').show();
                    $('.datatable').DataTable().ajax.reload();
                    setInterval(function() {
                        $('.alert-success').hide();
                        $('#CreateMedicineModal').modal('hide');
                        location.reload();
                    }, 2000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var errors = xhr.responseJSON.errors;
                $('.alert-danger').empty();
                $('.alert-danger').show();
                if (errors.hasOwnProperty("name")) {
                    $('.alert-danger').append('<strong><li>' + errors.name[0] + '</li></strong>');

                }
                if (errors.hasOwnProperty("type")) {
                    $('.alert-danger').append('<strong><li>' + errors.type[0] + '</li></strong>');

                }
                if (errors.hasOwnProperty("price")) {
                    $('.alert-danger').append('<strong><li>' + errors.price[0] + '</li></strong>');

                }
                $('.alert-danger').append('<strong><li>' + errors.message + '</li></strong>');
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        });
    });

    // Get single product in EditModel
    $('.modelClose').on('click', function() {
        $('#EditMedicineModal').hide();
    });


    // Update product Ajax request.
    $('#SubmitEditMedicineForm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "medicines/" + medicine_id + "/update",
            method: 'post',
            data: {
                name: $('#editName').val(),
                price: $('#editPrice').val(),
                type: $('#editType').val(),

            },
            success: function(result) {
                console.log(result);
                if (result.errors) {
                    $('.alert-danger').html('');
                    $.each(result.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>' + value + '</li></strong>');
                    });
                } else {
                    $('.alert-danger').hide();
                    $('.alert-success').show();
                    $('.datatable').DataTable().ajax.reload();
                    setInterval(function() {
                        $('.alert-success').hide();
                        $('#EditMedicineModal').hide();
                    }, 2000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var errors = xhr.responseJSON.errors;
                $('.alert-danger').empty();
                $('.alert-danger').show();
                if (errors.hasOwnProperty("name")) {
                    $('.alert-danger').append('<strong><li>' + errors.name[0] + '</li></strong>');

                }
                if (errors.hasOwnProperty("type")) {
                    $('.alert-danger').append('<strong><li>' + errors.type[0] + '</li></strong>');

                }
                if (errors.hasOwnProperty("price")) {
                    $('.alert-danger').append('<strong><li>' + errors.price[0] + '</li></strong>');

                }
                if (xhr.responseJSON.hasOwnProperty("message")) {
                    $('.alert-danger').append('<strong><li>' + xhr.responseJSON.message + '</li></strong>');
                }
            }
        });
    });



    // Delete product Ajax request.
    var deleteID;

    function deleteMedicine(id) {
        deleteID = id;
        $('#delete_medicine_modal').modal('show');;
    }

    $('#confirm_delete').click(function(e) {
        e.preventDefault();
        var id = deleteID;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "medicines/" + id + "/delete",
            method: 'DELETE',
            success: function(result) {
                setInterval(function() {
                    $('#medicine_table').DataTable().ajax.reload();
                    $('#delete_medicine_modal').hide();
                    location.reload();
                    s
                }, 1000);
            }
        });
    });
</script>
@endsection