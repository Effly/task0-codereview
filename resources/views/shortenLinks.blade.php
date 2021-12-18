<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{route('generate.link')}}" method="post">
    @csrf
    <input name="long_url[]" type="text">
    <input name="tags[]" type="text">
    <br>
    <input name="long_url[]" type="text">
    <input name="tags[]" type="text">
    <br>
    <input type="submit">
</form>
</body>
</html>
