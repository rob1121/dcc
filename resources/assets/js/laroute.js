(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://tspi-db01/dcc/public',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"api\/internal\/search","name":"api.search.internal","action":"App\Http\Controllers\ApiController@internalSearch"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/external\/search","name":"api.search.external","action":"App\Http\Controllers\ApiController@externalSearch"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/user\/search","name":"api.search.user","action":"App\Http\Controllers\ApiController@userSearch"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/external\/search-for-review","name":"api.search.external.for_review","action":"App\Http\Controllers\ApiController@forReviewSearch"},{"host":null,"methods":["GET","HEAD"],"uri":"esd","name":"esd.index","action":"App\Http\Controllers\ESDController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"esd\/create","name":"esd.create","action":"App\Http\Controllers\ESDController@create"},{"host":null,"methods":["POST"],"uri":"esd","name":"esd.store","action":"App\Http\Controllers\ESDController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"esd\/{esd}","name":"esd.show","action":"App\Http\Controllers\ESDController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"esd\/{esd}\/edit","name":"esd.edit","action":"App\Http\Controllers\ESDController@edit"},{"host":null,"methods":["PATCH"],"uri":"esd\/{esd}","name":"esd.update","action":"App\Http\Controllers\ESDController@update"},{"host":null,"methods":["DELETE"],"uri":"esd\/{esd}","name":"esd.delete","action":"App\Http\Controllers\ESDController@delete"},{"host":null,"methods":["GET","HEAD"],"uri":"esd\/documents\/all","name":"esd.all","action":"App\Http\Controllers\ESDController@all"},{"host":null,"methods":["GET","HEAD"],"uri":"external","name":"external.index","action":"App\Http\Controllers\ExternalController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"external\/create","name":"external.create","action":"App\Http\Controllers\ExternalController@create"},{"host":null,"methods":["POST"],"uri":"external","name":"external.store","action":"App\Http\Controllers\ExternalController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"external\/{external}\/{revision?}","name":"external.show","action":"App\Http\Controllers\ExternalController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"external\/spec\/{external}\/edit","name":"external.edit","action":"App\Http\Controllers\ExternalController@edit"},{"host":null,"methods":["PATCH"],"uri":"external\/{external}","name":"external.update","action":"App\Http\Controllers\ExternalController@update"},{"host":null,"methods":["PATCH"],"uri":"external\/{external}\/update-status","name":"external.revision.update","action":"App\Http\Controllers\ExternalController@updateRevision"},{"host":null,"methods":["DELETE"],"uri":"external\/{external}","name":"external.destroy","action":"App\Http\Controllers\ExternalController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"internal","name":"internal.index","action":"App\Http\Controllers\InternalController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"internal\/create","name":"internal.create","action":"App\Http\Controllers\InternalController@create"},{"host":null,"methods":["POST"],"uri":"internal","name":"internal.store","action":"App\Http\Controllers\InternalController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"internal\/{internal}","name":"internal.show","action":"App\Http\Controllers\InternalController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"internal\/{internal}\/edit","name":"internal.edit","action":"App\Http\Controllers\InternalController@edit"},{"host":null,"methods":["PATCH"],"uri":"internal\/{internal}","name":"internal.update","action":"App\Http\Controllers\InternalController@update"},{"host":null,"methods":["DELETE"],"uri":"internal\/{internal}","name":"internal.destroy","action":"App\Http\Controllers\InternalController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"iso","name":"iso.index","action":"App\Http\Controllers\IsoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"iso\/iso\/documents\/all","name":"iso.all","action":"App\Http\Controllers\IsoController@getAll"},{"host":null,"methods":["GET","HEAD"],"uri":"iso\/create","name":"iso.create","action":"App\Http\Controllers\IsoController@create"},{"host":null,"methods":["POST"],"uri":"iso","name":"iso.store","action":"App\Http\Controllers\IsoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"iso\/{iso}","name":"iso.show","action":"App\Http\Controllers\IsoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"iso\/{iso}\/edit","name":"iso.edit","action":"App\Http\Controllers\IsoController@edit"},{"host":null,"methods":["PATCH"],"uri":"iso\/{iso}","name":"iso.update","action":"App\Http\Controllers\IsoController@update"},{"host":null,"methods":["DELETE"],"uri":"iso\/{iso}","name":"iso.destroy","action":"App\Http\Controllers\IsoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"log","name":"log.index","action":"App\Http\Controllers\LogController@index"},{"host":null,"methods":["POST"],"uri":"log\/date","name":"log.getByDate","action":"App\Http\Controllers\LogController@getByDate"},{"host":null,"methods":["GET","HEAD"],"uri":"user","name":"user.index","action":"App\Http\Controllers\UserController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"user\/{user}\/edit","name":"user.edit","action":"App\Http\Controllers\UserController@edit"},{"host":null,"methods":["PATCH"],"uri":"user\/{user}","name":"user.update","action":"App\Http\Controllers\UserController@update"},{"host":null,"methods":["DELETE"],"uri":"user\/{user}","name":"user.delete","action":"App\Http\Controllers\UserController@delete"},{"host":null,"methods":["GET","HEAD"],"uri":"demo","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":null,"action":"App\Http\Controllers\HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"documentation","name":null,"action":"App\Http\Controllers\HomeController@documentation"},{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"App\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"App\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["POST"],"uri":"logout","name":"logout","action":"App\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"App\Http\Controllers\Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"register","name":null,"action":"App\Http\Controllers\Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset","name":null,"action":"App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"password\/email","name":null,"action":"App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset\/{token}","name":null,"action":"App\Http\Controllers\Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"password\/reset","name":null,"action":"App\Http\Controllers\Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","HEAD"],"uri":"home","name":"home","action":"App\Http\Controllers\HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"search","name":"search","action":"App\Http\Controllers\SearchController@search"},{"host":null,"methods":["GET","HEAD"],"uri":"department-list","name":"department.list","action":"App\Http\Controllers\Api\departmentController@departments"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/user","name":null,"action":"Closure"}],
            prefix: '/dcc/public',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                return this.getCorrectUrl(uri + qs);
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if(!this.absolute)
                    return url;

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

