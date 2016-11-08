<html>
<head>
    <style>
        *:focus {
            outline: none
        }

        body {
            overflow-y: scroll;
            margin:0;
            padding:0;
            font-family: Arial;
            display: flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        }

        .heading {
            background-image: url({{URL::to('/img/cover.jpg')}});
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            width: 100%;
            display: flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        }


        .title {
            font-size: 128px;
            font-wieght: bold;
            color: #fff;
        }

        .footer {
            background: #242b3d;
            width: 100%;
            color: #fff;
            text-align: center;
            position: relative;
            margin-top: 120px;
        }

        .footer:before {
            content: '';
            position: absolute;
            z-index: -1;
            left: 0;
            top: -30px;
            width: 100%;
            height: 60px;
            background: #242b3d;
            transform: skewY(2.5deg);
        }

        .menu {
            margin-top: -64px;
        }

        .menu li {
            float: left;
            list-style: none;
            margin: 0 16px;
        }

        .menu a {
            text-decoration: none;
            text-transform: uppercase;
            color: #fff;
        }

        .business-card {
            text-align: left;
            padding-left: 100px;
            padding-top: 12px;
            color: rgba(250,250,250,0.7);
        }

        .secondary-title {
            color: rgba(250,250,250,0.5);
        }

        .logo {
            text-align: right;
            margin-bottom: -80px;
        }

        .text-danger {
            color: firebrick;
        }
        .login {
            position: absolute;
            top: 10px;
            right: 32px;
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: none;
        }

        .body {
            padding: auto 30px;
        }
    </style>
</head>
<body>
<div class="heading">
    <h1 class="title">DCC ONLINE</h1>
    <ul class="menu">
        <li><a href="{{route("internal.index")}}">Internal Specification</a></li>
        <li><a href="{{route("iso.index")}}">ISO Documents</a></li>
    </ul>
</div>
<div class="body">
    @if(Auth::guest())
        <a class="login" href="{{URL::to("/login")}}">login</a>
    @else
        <a class="login" href="{{route("internal.index")}}">home</a>
    @endif
    <h1>DCC Online</h1>
    <p>DCC Online is the <strong class="text-danger">Telford Svc. Phils., Inc.</strong> online document center that aims to cost cut the use paper by making printed documents into an electronic documents.</p>

    <h3>What's new?</h3>
    <ul>
        <li>Real time search query</li>
        <li>Email notification</li>
        <li>Automated followup through online notification</li>
        <li>Improved design</li>
        <li>Fixed bugs</li>
        <p>...read the <a href="{{URL::to("/documentation")}}">system documentation</a> for more details.</p>
    </ul>
</div>

<div class="logo">
    <img src="{{URL::to("/img/signature.jpg")}}">
    <img src="{{URL::to("/img/telford.png")}}" width="16%">
    <img src="{{URL::to("/img/asti.png")}}">
</div>
<div class="footer">

    <div class="business-card">
        <p class="secondary-title">Should you have any concern, please do not hesitate to contact me:</p>
            <div class="name"><strong>ROBINSON L. LEGASPI</strong></div>
        <div class="secondary-title position">Management System Officer</div>
        <br>
        <div class="secondary-title department">Quality Assurance</div>
        <div class="secondary-title email">robinsonlegaspi@astigp.com</div>
        <div class="secondary-title tel-number">local. 1011</div>
    </div>
    <p class="secondary-title">Telford Svc. Phils., Inc. All rights reserved &copy;</p>
</div>
</body>
</html>