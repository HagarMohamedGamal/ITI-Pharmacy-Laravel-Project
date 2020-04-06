
@extends('layouts.app')

@section('content')
<h1 id="top">edit</h1>


         <span id="form_result"></span>
<form id="update_form" method="POST" enctype="multipart/form-data">
<!-- <form  method="post" action="{{route('pharmacies.update', $pharmacy->id)}}" enctype="multipart/form-data"> -->
      @method('PUT')
     @csrf
    <div class="form-group">
    <label for="exampleFormControlInput1">Name</label>
    <input type="text" class="form-control" name="name" value="{{$pharmacy->type->name}}">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">email</label>
    <input type="text" class="form-control" name="email" value="{{$pharmacy->type->email}}">
  </div>

  <div class="form-group">
    <label for="exampleFormControlSelect1">area_id</label>
    <input type="text" class="form-control" name="area_id" value="{{$pharmacy->area_id}}">
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">priority</label>
    <input type="text" class="form-control" name="priority" rows="3" value="{{$pharmacy->priority}}">
  </div>

  <div class="form-group">
    <label for="exampleFormControlInput4">national id</label>
    <input type="text" name="national_id" class="form-control" id="exampleFormControlInput4"  value="{{$pharmacy->national_id}}">
  </div>

  <div class="">
    <label class="" for="inputGroupFile02"><strong>Choose file</strong></label>
    <input type="file" name="avatar" class="" id="inputGroupFile02">
  </div>


    <button type="submit" class="btn btn-primary mt-5">Submit</button>


</form>


<script type="text/javascript">


 $('#update_form').on('submit', function(event){
  event.preventDefault();
   $.ajax({
    url:"{{ route('pharmacies.update', $pharmacy->id) }}",
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