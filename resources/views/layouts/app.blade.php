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
    <style type="text/css">
        .clear-btn {
            cursor:pointer;
            float:right;
            margin-top: -28px;
            margin-right: 10px;
        }

        .search-output {
            margin-bottom: 80px;
        }

        #app {
            display: flex;
        }
        #app>#sidebar {
            padding-left: 15px;
            width: 20vw;
        }
        #app>.content {
            padding: 50px;
            width: 80vw;
        }

        #sidebar {
            display: flex;
            flex-direction: column;
        }
        .white-cover {
            background: #fff;
            opacity: 0.8;
            padding:0;
            top:0;
            bottom:0;
            width:100vw;
            position: fixed;
            z-index:5;
            transform: translateX(60vw);
            display: none;
        }
        .menu-link.sidebar-link {
            display: none;
        }

        @media screen and (max-width: 770px) {

            body {
                overflow-x: hidden;
            }

        .active .menu-link {
            display: block;
        }

            #app > #sidebar {
                display: none;
            }

            #app .content {
                width: 100vw;
            }

            .active #app {
                width: 160vw;
            }

            .active #app > #sidebar {
                display: flex;
                width: 60vw;
            }

            .active #app > .content {
                width: 100vw;
            }

            .active .nav {
                transform: translateX(60vw);
            }

            .active .white-cover {
                display: block;
            }
        }
    </style>
</head>
<body>
<div class="nav">
    @include("layouts.nav")
</div>

    <div id="app" v-cloak>

            <div id="sidebar">
            <h3 class=" menu-link sidebar-link">Menu:</h3>
            <a class="menu-link sidebar-link btn-link" href="{{ route("internal.index") }}">Internal Specification
                @if($count = newCompanySpecCount())
                    <span class="label label-danger">{{$count}}</span>
                @endif
            </a>
            @if(Auth::user())
                    <a class="menu-link sidebar-link btn-link" href="{{ route("external.index") }}">External Specification
                        @if($count = customerForSpecReviewCount())
                            <span class="label label-danger">{{$count}}</span>
                        @endif
                    </a>
            @endif
            <a class="menu-link sidebar-link btn-link" href="{{ route("iso.index") }}">ISO</a>
        <br><br>
        @if(isset($categories))
                <form>
                    <div class="form-group">
                        <label for=""> Search:
                            <input type="text"
                                   class="form-control"
                                   placeholder="&#128270;"
                                   v-model="searchKeyword"
                                   name="search-field"
                                   id="search-field"
                                   @keyup.enter="displaySearchResult"
                            >
                            <span class="clear-btn" v-if="searchKeyword" @click="clearSearchInput">&times;</span>
                        </label>
                        <button @click.prevent="displaySearchResult"
                                class="btn btn-default btn-search"
                                name="search-field-submit"
                        >
                            Search
                        </button>
                    </div>
                </form>

            <h3>Specification Category:</h3>
                <a v-for="category in {{$categories}}"
                   href="#"
                   class="sidebar-link btn-link"
                @click.prevent="getSpecByCategory(category)"
                >
                    @{{category.name}}
                </a>
        @endif
            </div>
        <div class="white-cover"></div>
        <div class="content" v-show="! showResultDialog">
            @yield('content')
        </div>

        <div class="content search-output" v-show="showResultDialog">
            @include("layouts.search_engine")
        </div>
    </div>

    @include('layouts.footer')

    <!-- Scripts -->
    {{-- <script src="/js/app.js"></script> --}}
    @stack("script")
<script>
    $("button.navbar-toggle").click(function() { $("body").addClass("active"); });
    $(".white-cover").click(function() { $("body").removeClass("active"); });
</script>
</body>
</html>
