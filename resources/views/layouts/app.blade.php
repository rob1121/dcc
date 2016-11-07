
@php
    $internal = \App\CompanySpecRevision::where("revision_date",">", \Carbon::now()->subDays(7))->count();
    $external = \App\CustomerSpecRevision::whereIsReviewed(0)->count();
    $iso = \App\Iso::where("revision_date",">", \Carbon::now()->subDays(7))->count();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{URL::to("/css/app.css")}}">
    @stack("style")
<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div class="nav">
    @include("layouts.nav")
</div>

<div id="app" v-cloak>
    <div class="content">
        @yield('content')
    </div>
</div>

@include('layouts.footer')

@stack("script")

<script>
    $("button.navbar-toggle").click(function () {
        $("body").addClass("active");
    });
    $(".white-cover").click(function () {
        $("body").removeClass("active");
    });
</script>
</body>
</html>
