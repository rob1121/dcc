<nav class="navbar navbar-default navbar">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" style="background: darkred;color: #FFF"
                    {{--data-toggle="collapse"--}}
                    {{--data-target="#app-navbar-collapse" --}}
            >
                <span class="sr-only">Toggle Navigation</span>
                <i class="fa fa-align-justify"></i>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <strong>
                    <img src="{{URL::to("/favicon.ico")}}" alt="dcc" width="20px" style="position:relative;top:-2px">
                    {{ config('app.name', 'Laravel') }}
                </strong>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav navbar-left">
                <li class="{{route("internal.index") === Request::url() ? "active" : ""}} nav-link">
                    <a href="{{ route("internal.index") }}">Internal Specification
                        @if($count = newCompanySpecCount())
                            <span class="label label-danger">{{$count}}</span>
                        @endif
                    </a>
                </li>
                @if(Auth::user())
                    <li class="{{route("external.index") === Request::url() ? "active" : ""}} nav-link">
                        <a href="{{ route("external.index") }}">External Specification
                            @if($count = customerForSpecReviewCount())
                                <span class="label label-danger">{{$count}}</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="{{route("iso.index") === Request::url() ? "active" : ""}} nav-link">
                    <a href="{{ route("iso.index") }}">ISO</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">

                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                @else
                    <li class="dropdown nav-link">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @if(Auth::user()->is_admin)
                                <li><a href="{{ url('/register') }}">Register new user</a></li>
                                <li><a href="{{ url('/user-list') }}">User list</a></li>
                                <li role="separator" class="divider"></li>
                            @endif
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>