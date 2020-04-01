$(function(){
$("button").on("click", "span[id^='delete_']" , (ev)=>{
    idName = ev.currentTarget.id;
    doctor = idName.split("_")[1];
    const token = $('meta[name="csrf-token"]').attr('content');
   
    jQuery.ajax({
        url: "doctors/"+doctor,
        type: "DELETE",
        data: {
            'doctor': doctor,
            '_token': token,
        },
        success: function(e){
          console.log(e, "jjj");
        },
        error: function(e){
            console.log("there is an error occured");
        }
    });
});

});
