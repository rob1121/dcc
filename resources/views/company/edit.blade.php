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

<form action="/update/{{$spec->id}}" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="file" value="{{$spec->document}}" name="document">
    <input type="text" value="{{$spec->name}}" name="name">
    <input type="text" value="{{$spec->spec_no}}" name="spec_no">
    <input type="text" value="{{$spec->companySpecRevision->last()->revision}}" name="revision">
    <input type="text" value="{{$spec->companySpecRevision->last()->revision_summary}}" name="revision_summary">
    <input type="text" value="{{$spec->companySpecRevision->last()->revision_date}}" name="revision_date">

    <input type="text" value="{{$spec->companySpecCategory->category_no}}" name="category_no">
    <input type="text" value="{{$spec->companySpecCategory->category_name}}" name="category_name">
    <input type="submit" value="submit">
</form>
</body>
</html>