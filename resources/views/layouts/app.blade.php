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
    @include("layouts.nav")

    <div id="app" v-cloak>
        @yield('content')
    </div>

    @include('layouts.footer')

    <!-- Scripts -->
    {{-- <script src="/js/app.js"></script> --}}
    @stack("script")

</body>
</html>
