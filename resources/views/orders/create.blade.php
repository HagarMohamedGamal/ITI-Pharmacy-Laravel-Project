@extends('layouts.app')

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

@section('content')

<div class="container-fullwidth mx-5 mt-4">
  <form method="POST" autocomplete="off" action="{{route('orders.store')}}">
    @csrf

    <div class="form-group">
      <label>order user name</label>
      <select class="form-control" id="user" name="user_id">
        <option>Choose Client</option>
        @foreach($clients as $client )
        <option value="{{$client->id}}">{{$client->type->name}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>delivering address</label>
      <select id="delivering_address" name="delivering_address">

      </select>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="is_insured" type="checkbox" value="1" id="is_insured">
      <label class="form-check-label" for="is_insured">
        insured
      </label>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
  </form>
</div>

<script>
  $(document).ready(function() {
    console.log('reed');

    $(document).on('change', '#user', function() {
      $('#delivering_address').empty();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      //  var optionSelected = $("option:selected", this);
      // var valueSelected = this.value;
      console.log('here');

      $.ajax({
          type: "POST",
          url: "/useraddresses/user",
          data: {
            'user_id': $('#user').val()
          },

        })
        .done(function(response) {
          response.forEach(function(item) {
            console.log(item);

            $('#delivering_address').append('<option value="' + item.id + '">' + item.street_name + item.build_no + item.floor_no + '</option>');
          })

        })
    })
  });
</script>
@endsection