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
    @stack("style")

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top navbar">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-left">
                    <li @if(route("internal.index") === Request::url()) class="active" @endif>
                        <a href="{{ route("internal.index") }}">Internal Specification</a>
                    </li>
                    
                    <li @if(route("external.index") === Request::url()) class="active" @endif>
                        <a href="{{ route("external.index") }}">External Specification</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="navbar-form">
                        <input type="text" style="width: 200px;"
                               class="form-control"
                               placeholder="Search for Specification"
                               v-model="searchKeyword"
                               @keyup.enter="displaySearchResult"
                        >
                        <button @click="displaySearchResult" class="btn btn-default">
                        <i class="fa fa-search"></i></button>
                    </li>

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        {{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    <div class="search-result" v-show="showResultDialog" v-cloak>
        <button class="close" @click="closeResultDialog"><i class="fa fa-remove"></i></button>
        <div class="search--deck-collection search-result--list" v-show="isSearchResultNotEmpty">
            <h1>Result found for <strong>"@{{ searchKeyword }}"</strong></h1>
            <a class="search--deck" v-for="result in searchResults" target="_blank" href="/internal/@{{result.id}}" placholder="view file">
                <div class="search--spec-no col-xs-5"><h4>@{{result.spec_no}} - @{{result.name}}</h4></div>
                <div class="col-xs-5 search--revision-summary"><h5>@{{result.company_spec_revision.revision_summary | trim}}</h5></div>
                <div class="col-xs-2 search--revision">
                    <h6>@{{result.company_spec_revision.revision_date}}</h6>
                    <h6>@{{result.company_spec_revision.revision | uppercase}}</h6>
                </div>
            </a>
        </div>

        <div v-else>
            <h1 class="text-left search-result--list">No Result Found for <strong>"@{{ searchKeyword }}"</strong></h1>
        </div>
    </div>
    </nav>
    <div id="app" v-cloak>
        @yield('content')
    </div>

    @include('layouts.footer')
    <!-- Scripts -->
    {{-- <script src="/js/app.js"></script> --}}
    @stack("script")

</body>
</html>
