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
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/add" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="file" name="document">
    <input type="text" name="name" value="name">
    <input type="text" name="spec_no" value="spec_no">
    <input type="text" name="revision" value="rev">
    <input type="text" name="revision_summary" value="revision_summary">
    <input type="text" name="revision_date" value="2016/09/04">

    <input type="text" name="category_no" value="category_no">
    <input type="text" name="category_name" value="category_name">
    <input type="submit" value="submit">
</form>
</body>
</html>