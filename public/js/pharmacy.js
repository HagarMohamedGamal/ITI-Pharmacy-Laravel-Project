
  $(function() {
    mytable=$('#mytable').DataTable();
    mydeletetable=$('#mydeletetable').DataTable();

    $("button.softDeleteRecord").click(function(ev){
    let id = ev.target.dataset.id;
    console.log(ev.target.dataset.id)
    jQuery.ajax(
    {
            url: "/pharmacies/"+id+"/softdelete",
            success: function (response){
              console.log(response);
              rows = mytable
                  .rows("tr#"+id)
                  .remove()
                  .draw();
            },
            response: function(){
              console.log("Respooooonse");
            }
        });
    })

    $("button.permDeleteRecord").click(function(ev){
    let id = ev.target.dataset.id;
    const token = $('meta[name="csrf-token"]').attr('content');
    console.log(ev.target.dataset.id)
    jQuery.ajax(
    {
            url: "/pharmacies/"+id,
            type: "delete",
            data: {
                'id': id,
                '_token': token,
            },
            success: function (response){
              console.log(response);
              rows = mydeletetable
                  .rows("tr#"+id)
                  .remove()
                  .draw();
            },
            response: function(){
              console.log("Respooooonse");
            }
        });


    });

  });
