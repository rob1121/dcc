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
            width: 20%;
        }
        #app>.content {
            padding: 50px;
            width: 80%;
        }

        #sidebar {
            display: flex;
            flex-direction: column;
        }

        @media screen and (max-width: 770px) {

            body {
                overflow-x: hidden;
            }

            /*.content {*/
                /*width: 125%;*/
            /*}*/

            /*#app {*/
                /*width: 125%;*/
                /*transform: translateX(-20%);*/
            /*}*/
            .active #app {
                width: 170vw;
            }

            .active #app > #sidebar {
                width: 70vw;
            }

            .active #app > .content {
                width: 100vw;
            }

            .active .nav {
                transform: translateX(70vw);
            }
        }
    </style>
</head>
<body>
<div class="nav">
    @include("layouts.nav")
</div>

    <div id="app" v-cloak>
        @if(isset($categories))
            <div id="sidebar">
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
                                class="btn btn-default"
                                name="search-field-submit"
                        >
                            Search
                        </button>
                    </div>
                </form>
                <a v-for="category in {{$categories}}"
                   href="#"
                   class="sidebar-link btn-link"
                @click.prevent="getSpecByCategory(category)"
                >
                    @{{category.name}}
                </a>
            </div>
        @endif

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
    $("button.navbar-toggle").click(function() {
        $(".body").toggleClass("active");
    });
</script>
</body>
</html>
