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
    <form method="post" action="/areas">
        @csrf
        <label for="name"> name </label>
        <input type="text" name="name">
        <br>
        <label for="address">address</label>
        <input type="text" name="address">
        <button type="submit">Submit</button>
    </form>
</body>

</html>