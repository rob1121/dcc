<nav class="navbar navbar-default navbar">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->

            <button type="button" class="toggle-faded navbar-toggle collapsed"
                    @click="navToggler = ! navToggler"
                    {{--data-toggle="collapse"--}}
                    {{--data-target="#app-navbar-collapse" --}}
            >
                <span class="sr-only">Toggle Navigation</span>
                <i class="fa fa-align-justify"></i>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}" style="z-index: 2;position:relative">
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
                        @if($internal)
                            <span class="label label-danger">{{$internal}}</span>
                        @endif
                    </a>
                </li>
                @if(Auth::user())
                    <li class="{{route("external.index") === Request::url() ? "active" : ""}} nav-link">
                        <a href="{{ route("external.index") }}">External Specification
                            @if($external)
                                <span class="label label-danger">{{$external}}</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="{{route("iso.index") === Request::url() ? "active" : ""}} nav-link">
                    <a href="{{ route("iso.index") }}">ISO
                        @if($iso)
                            <span class="label label-danger">{{$iso}}</span>
                        @endif
                    </a>
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
                            @if(isAdmin())
                                <li><a href="{{ route("user.index") }}">Users list</a></li>
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