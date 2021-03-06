<!DOCTYPE html>
<html>
<head>
    <title>Be right back.</title>

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato', sans-serif;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">
            <small>
                {{$exception->getMessage()}}
                @yield("error")
            </small>
        </div>
        <a  class="title" href="{{URL::to("/")}}">Go Home</a>
    </div>
</div>
</body>
</html>
