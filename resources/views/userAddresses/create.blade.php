<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="post" action="/useraddresses">
        @csrf
        <label for="exampleInputEmail1">area</label>
        <select name="area_id" class="form-control">
            @foreach($areas as $area)
            <option value="{{$area->id}}">{{$area->address}}</option>
            @endforeach
        </select>
        <br>
        <label for="street_name"> street_name </label>
        <input type="text" name="street_name">
        <br>
        <label for="build_no"> build_no </label>
        <input type="text" name="build_no">
        <br>
        <label for="floor_no">floor_no</label>
        <input type="text" name="floor_no">
        <br>
        <label for="flat_no">flat_no</label>
        <input type="text" name="flat_no">
        <br>
        <h2>thats your main address ?</h2>
        <input type="radio" name="is_main" value="1">
        <label for="male">yes</label><br>
        <input type="radio"  name="is_main" value="0">
        <label for="female">no</label><br>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>

</html>