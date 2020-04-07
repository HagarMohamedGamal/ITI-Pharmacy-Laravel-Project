$(function () {
    table = $("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/doctors'
        },
        columns: [
            {
                data: 'id', name: 'id'
            },
            {

                data: 'name', name: 'name'
            },
            {
                data: 'email', name: 'email'

            },
            {
                data: 'national_id', name: 'national_id'
            },
            {
                data: 'pharmacy_id', name: 'pharmacy_id'
            },
            {
                data: 'action', name: 'action'
            },
        ]
    });





    $(document).on('click', '.delete', function () {
        doctor_id = $(this).attr('id');

        const token = $('meta[name="csrf-token"]').attr('content');
        console.log(token);
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function () {
        const token = $('meta[name="csrf-token"]').attr('content');
        console.log(doctor);
    
        jQuery.ajax({
            url: "/doctors/"+doctor,
            type: "put",
            data: {
                'id': doctor_id,
                '_token': token,
            },
            beforeSend: function () {
                $('#ok_button').text('Deleting...');
            },
            success: function (data) {
                setTimeout(function () {
                    $('#confirmModal').modal('hide');
                    $('#ok_button').text('OK');
                    $('#example1').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });


});


