<nav class="navbar navbar-default navbar-fixed-top navbar">
    <div class="row-fluid" style="padding: 0 20px">
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
            <a class="navbar-brand" href="{{ url('/') }}" style="margin-left: 20px">
                <strong><img src="{{URL::to("/favicon.ico")}}" alt="dcc" width="20px"
                             style="position:relative;top:-2px">{{ config('app.name', 'Laravel') }}</strong>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav navbar-left" style="margin-left: 8%">
                <li @if(route("internal.index") === Request::url()) class="active" @endif>
                    <a href="{{ route("internal.index") }}">Internal Specification
                        @if(newCompanySpecCount())
                            <span class="label label-danger">{{newCompanySpecCount()}}</span>
                        @endif
                    </a>
                </li>

                <li @if(route("external.index") === Request::url()) class="active" @endif>
                    <a href="{{ route("external.index") }}">External Specification
                        @if(newCustomerSpecCount())
                            <span class="label label-danger">{{newCustomerSpecCount()}}</span>
                        @endif
                    </a>
                </li>

                <li @if(route("external.for_review") === Request::url()) class="active" @endif>
                    <a href="{{ route("external.for_review") }}">For Specification Review
                        <span class="label label-danger">{{customerForSpecReviewCount()}}</span>
                    </a>
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
        <div class="search--deck-collection search-result--list" v-show="searchResults.internal">
            <h1>Search result found for <strong>"@{{ searchKeyword }}"</strong> under Internal Specification</h1>
            <a class="search--deck" v-for="result in searchResults.internal" target="_blank"
               href="@{{result.id | internalRoute}}"
               placholder="view file">
                <div class="search--spec-no col-xs-5"><h4>@{{result.spec_no}} - @{{result.name}}</h4></div>
                <div class="col-xs-5 search--revision-summary">
                    <h5>@{{result.company_spec_revision.revision_summary | trim}}</h5></div>
                <div class="col-xs-2 search--revision">
                    <h6>@{{result.company_spec_revision | telfordStandardDate}}</h6>
                    <h6>@{{result.company_spec_revision.revision | uppercase}}</h6>
                </div>
            </a>
        </div>

        <div v-else>
            <h1 class="text-left search-result--list">No Result Found for <strong>"@{{ searchKeyword }}"</strong></h1>
        </div>
        <div class="search--deck-collection search-result--list" v-show="searchResults.external">
            <h1>Search result found for <strong>"@{{ searchKeyword }}"</strong> under External Specification</h1>
            <a class="search--deck" v-for="result in searchResults.external" target="_blank"
               href="@{{result.id | externalRoute}}"
               placeholder="view file">
                <div class="search--spec-no col-xs-10"><h4>@{{result.spec_no}} - @{{result.name}}</h4></div>
                <div class="col-xs-2 search--revision">
                    <h6>@{{result.customer_spec_revision | latestRevision "revision_date" | telfordStandardDate}}</h6>
                    <h6>@{{result.customer_spec_revision | latestRevision "revision" | uppercase}}</h6>
                </div>
            </a>
        </div>

        <div v-else>
            <h1 class="text-left search-result--list">No Result Found for <strong>"@{{ searchKeyword }}"</strong></h1>
        </div>
    </div>
</nav>