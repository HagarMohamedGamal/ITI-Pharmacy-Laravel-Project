@extends('layouts.app')

@section('content')
<h1 id="top">create</h1>

         <span id="form_result"></span>

<form id="create_form" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <label for="exampleFormControlInput1">Name</label>
    <input type="text" class="form-control" name="name">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">password</label>
    <input type="text" class="form-control" name="password">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">email</label>
    <input type="text" class="form-control" name="email">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">area_id</label>
    <input type="text" class="form-control" name="area_id">
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">priority</label>
    <input type="text" class="form-control" name="priority" rows="3">
  </div>


  <div class="form-group">
    <label for="exampleFormControlInput4">national id</label>
    <input type="text" name="national_id" class="form-control" id="exampleFormControlInput4" value="{{isset($doctor)?$doctor->national_id:''}}">
  </div>

  <div class="">
    <label class="" for="inputGroupFile02"><strong>Choose file</strong></label>
    <input type="file" name="avatar" class="" id="inputGroupFile02">
  </div>

   <br />
   <div class="form-group" align="center">
    <input type="hidden" name="action" id="action" />
    <input type="hidden" name="hidden_id" id="hidden_id" />
    <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
   </div>


</form>

<script type="text/javascript">


 $('#create_form').on('submit', function(event){
  event.preventDefault();
   $.ajax({
    url:"{{ route('pharmacies.store') }}",
    method:"POST",
    data: new FormData(this),
    contentType: false,
    cache:false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     let html = '';
     console.log(data);
      html = '<div class="alert alert-success">';
       html += '<p>' + data.success + '</p>';
      html += '</div>';
     $('#form_result').html(html);

         $(location).attr('href', '#top')
        setTimeout(function(){
         $(location).attr('href', '/pharmacies')
        }, 2000);
     
    },
    error: function(ev)
    {
      console.log(ev.responseText);
      error =JSON.parse(ev.responseText);
      html='<div class="alert alert-warning">'
      $.each( error.errors, function( key, value ) {
        html += "<strong>" + key + "</strong>" + ": " + value  + "<br>" ;
      });

      html += '</div>';
     $('#form_result').html(html);
    }
   })
})
</script>


@endsection