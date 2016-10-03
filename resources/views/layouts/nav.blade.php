<nav class="navbar navbar-default navbar-fixed-top navbar">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
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
                <li class="navbar-form">
                    <form>
                        <input type="text" style="width: 200px;"
                               class="form-control"
                               placeholder="&#128270; Search for Specification"
                               v-model="searchKeyword"
                               name="search-field"
                               id="search-field"
                               @keyup.enter="displaySearchResult"
                        >
                        <button @click="displaySearchResult" class="btn btn-default" name="search-field-submit">Search</button>
                    </form>
                </li>

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
    <div class="search-result" v-show="showResultDialog" v-cloak>
        <button class="close" @click="closeResultDialog"><i class="fa fa-remove"></i></button>
        <br>
        <br>
        <div class="container">
            <!-- TAB NAVIGATION -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Internal Specification Result:</a></li>
                @if(Auth::user() && Auth::user()->is_admin)<li><a href="#tab2" role="tab" data-toggle="tab">External Specification Result:</a></li>@endif
            </ul>
            <!-- TAB CONTENT -->
            <div class="tab-content">
                <div class="active tab-pane fade in" id="tab1">
                    <div class="search--deck-collection search-result--list" v-show="searchResults.internal">
                        <h1>Search result found for <strong>"@{{ searchKeyword }}"</strong> under Internal Specification
                        </h1>
                        <a class="search--deck" v-for="result in searchResults.internal" target="_blank"
                           href="@{{result.id | internalRoute}}"
                           placholder="view file">
                            <div class="search--spec-no col-xs-offset-1 col-xs-10">
                                <h4>@{{result.spec_no | uppercase}} - @{{result.name | uppercase}}</h4>
                                <h5>@{{result.company_spec_revision.revision_summary | capitalize}}</h5>
                                <h6 class="help-block">
                                    <strong>Date: </strong>@{{result.company_spec_revision | telfordStandardDate}}
                                    <strong>Revision: </strong>@{{result.company_spec_revision.revision | uppercase}}
                                </h6>
                            </div>
                        </a>
                    </div>

                    <div v-else>
                        <h1 class="text-left search-result--list">No Result Found for <strong>"@{{ searchKeyword }}
                                "</strong></h1>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab2">

                    <div class="search--deck-collection search-result--list" v-show="searchResults.external">
                        <h1>Search result found for <strong>"@{{ searchKeyword }}"</strong> under External Specification
                        </h1>
                        <a class="search--deck" v-for="result in searchResults.external" target="_blank"
                           href="@{{result.id | externalRoute}}"
                           placeholder="view file">
                            <div class="search--spec-no cpl-xs-offset-1 col-xs-10">
                                <h4>@{{result.spec_no | uppercase}} - @{{result.name | uppercase}}</h4>
                                <h6 class="help-block justify">
                                    <strong>Date: </strong>@{{result.customer_spec_revision | latestRevision "revision_date" | telfordStandardDate}}
                                    <strong>Revision: </strong>@{{result.customer_spec_revision | latestRevision "revision" | uppercase}}
                                </h6>
                            </div>
                        </a>
                    </div>

                    <div v-else>
                        <h1 class="text-left search-result--list">No Result Found for <strong>"@{{ searchKeyword }}
                                "</strong></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>