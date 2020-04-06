$(function(){
    table=$("#example1").DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url: '/doctors'
        },
        columns:[
            {
                data: 'id',name: 'id'
            },
            {
                data: 'name',name: 'name'
            },
            {
                data: 'email',name: 'email'
            },
            {
                data: 'national_id',name: 'national_id'
            },
            {
                data: 'pharmacy_id',name: 'pharmacy_id'
            },
            {
                data: 'action',name: 'action'
            },
        ]
    });
    $("button").on("click", "span[id^='del_']" , (ev)=>{
        idName = ev.currentTarget.id;
        doctor = idName.split("_")[1];
        $("div#mypopup button span.delete").removeAttr("id")
        $("div#mypopup button span.delete").attr("id", "delete_"+doctor);
        $('div#mypopup').modal('show');
    });

    $("button").on("click", "span[id^='delete_']" , (ev)=>{
        idName = ev.currentTarget.id;
        doctor = idName.split("_")[1];
        const token = $('meta[name="csrf-token"]').attr('content');
    
        jQuery.ajax({
            url: "doctors/"+doctor,
            type: "delete",
            data: {
                'doctor': doctor,
                '_token': token,
            },
            success: function(e){
            rows = table
                    .rows("tr#"+doctor)
                    .remove()
                    .draw();
            },
            error: function(e){
                console.log("there is an error occured");
            }
        });
    });

    $("button").on("click", "span[class^='ban_']" , (ev)=>{
        idName = ev.currentTarget.className;
        doctor = idName.split("_")[1];
        console.log(doctor);
        
        const token = $('meta[name="csrf-token"]').attr('content');
        console.log(doctor);
    
        jQuery.ajax({
            url: "doctors/"+doctor,
            type: "put",
            data: {
                'doctor': doctor,
                '_token': token,
            },
            success: function(e){
                console.log("success", e.is_baned);
                if(e.is_baned){
                    $("button#ban_color_"+doctor).toggleClass("btn-secondary");
                    $("button#ban_color_"+doctor).toggleClass("btn-dark");
                } else{
                    $("button#ban_color_"+doctor).toggleClass("btn-secondary");
                    $("button#ban_color_"+doctor).toggleClass("btn-dark");
                }
            },
            error: function(e){
                console.log("there is an error occured", e);
            }
        });
    });
});
