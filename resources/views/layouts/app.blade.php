
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

    <div id="sidebar">
        <h4 class="menu-title">Menu:</h4>

        <a class="menu-link sidebar-link btn-link" href="{{ route("internal.index") }}">Internal Specification
            @if($internal)
                <span class="label label-danger">{{$internal}}</span>
            @endif
        </a>

        @if(Auth::user())
            <a class="menu-link sidebar-link btn-link" href="{{ route("external.index") }}">External Specification
                @if($external)
                    <span class="label label-danger">{{$external}}</span>
                @endif
            </a>
        @endif

        <a class="menu-link sidebar-link btn-link" href="{{ route("iso.index") }}">ISO
        @if($iso)
            <span class="label label-danger">{{$iso}}</span>
        @endif
        </a>
        @if (Auth::guest())

            <a class="menu-link sidebar-link" href="{{ url('/login') }}">Login</a>

        @else
            @if(isAdmin())
                <a class="menu-link sidebar-link" href="{{ url('/register') }}">Register new user</a>
                <a class="menu-link sidebar-link" href="{{ url('/user-list') }}">User list</a>
            @endif

            <a class="menu-link sidebar-link" href="{{ url('/logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            > Logout</a>

            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>
        @endif

        <br><br>

        @include("sidebar.sidebar", ["show" => isset($show)])
        @if(isset($categories))
            <h4>Specification Category:</h4>

            <a v-for="category in {{$categories}}"
               href="#"
               class="sidebar-link"
               @click.prevent="getSpecByCategory(category)"
            >
                @{{category.name}}
            </a>
        @endif
    </div>

    <div class="white-cover"></div>
    <div class="content">
        @if(isset($show))
            <div v-show="! showResultDialog">
                @yield('content')
                @include("search.result")
            </div>
            <div class="search-output" v-show="showResultDialog">
                @include("layouts.search_engine")
            </div>
        @else @yield('content')
        @endif
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
