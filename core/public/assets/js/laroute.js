(function () {

    var laroute = (function () {

        var routes = {

            absolute: true,
            rootUrl: 'http://localhost/jalanku',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"api\/user","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"coba","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":null,"action":"App\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"App\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"App\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["POST"],"uri":"logout","name":"logout","action":"App\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"App\Http\Controllers\Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"register","name":null,"action":"App\Http\Controllers\Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset","name":"password.request","action":"App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"password\/email","name":"password.email","action":"App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset\/{token}","name":"password.reset","action":"App\Http\Controllers\Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"password\/reset","name":"password.update","action":"App\Http\Controllers\Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","POST","HEAD"],"uri":"pengaturan","name":"pengaturan","action":"App\Http\Controllers\UserController@pengaturan"},{"host":null,"methods":["POST"],"uri":"ubah_pw","name":"ubah_pw","action":"App\Http\Controllers\UserController@ubah_pw"},{"host":null,"methods":["GET","HEAD"],"uri":"beranda","name":"beranda","action":"App\Http\Controllers\BerandaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"jalan","name":"jalan","action":"App\Http\Controllers\JalanController@index"},{"host":null,"methods":["GET","POST","HEAD"],"uri":"jalan\/tambah","name":"jalan.tambah","action":"App\Http\Controllers\JalanController@tambah"},{"host":null,"methods":["GET","HEAD"],"uri":"jalan\/detail\/{id}","name":"jalan.detail","action":"App\Http\Controllers\JalanController@detail"},{"host":null,"methods":["POST"],"uri":"jalan\/simpan","name":"jalan.simpan","action":"App\Http\Controllers\JalanController@simpan"},{"host":null,"methods":["GET","HEAD"],"uri":"jalan\/edit\/{id}","name":"jalan.edit","action":"App\Http\Controllers\JalanController@edit"},{"host":null,"methods":["POST"],"uri":"jalan\/update","name":"jalan.update","action":"App\Http\Controllers\JalanController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"jalan\/hapus\/{id}","name":"jalan.hapus","action":"App\Http\Controllers\JalanController@hapus"},{"host":null,"methods":["GET","HEAD"],"uri":"tpt\/{jalan_id}","name":"tpt","action":"App\Http\Controllers\TPTController@index"},{"host":null,"methods":["GET","POST","HEAD"],"uri":"tpt\/tambah\/{jalan_id}","name":"tpt.tambah","action":"App\Http\Controllers\TPTController@tambah"},{"host":null,"methods":["GET","HEAD"],"uri":"tpt\/detail\/{id}","name":"tpt.detail","action":"App\Http\Controllers\TPTController@detail"},{"host":null,"methods":["POST"],"uri":"tpt\/simpan","name":"tpt.simpan","action":"App\Http\Controllers\TPTController@simpan"},{"host":null,"methods":["GET","HEAD"],"uri":"tpt\/edit\/{id}","name":"tpt.edit","action":"App\Http\Controllers\TPTController@edit"},{"host":null,"methods":["POST"],"uri":"tpt\/update","name":"tpt.update","action":"App\Http\Controllers\TPTController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"tpt\/hapus\/{id}","name":"tpt.hapus","action":"App\Http\Controllers\TPTController@hapus"},{"host":null,"methods":["GET","HEAD"],"uri":"drainase\/{jalan_id}","name":"drainase","action":"App\Http\Controllers\DrainaseController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"drainase\/tambah\/{id}","name":"drainase.tambah","action":"App\Http\Controllers\DrainaseController@tambah"},{"host":null,"methods":["GET","HEAD"],"uri":"drainase\/detail\/{id}","name":"drainase.detail","action":"App\Http\Controllers\DrainaseController@detail"},{"host":null,"methods":["POST"],"uri":"drainase\/simpan","name":"drainase.simpan","action":"App\Http\Controllers\DrainaseController@simpan"},{"host":null,"methods":["GET","HEAD"],"uri":"drainase\/edit\/{id}","name":"drainase.edit","action":"App\Http\Controllers\DrainaseController@edit"},{"host":null,"methods":["POST"],"uri":"drainase\/update","name":"drainase.update","action":"App\Http\Controllers\DrainaseController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"drainase\/hapus\/{id}","name":"drainase.hapus","action":"App\Http\Controllers\DrainaseController@hapus"},{"host":null,"methods":["GET","HEAD"],"uri":"beton\/{jalan_id}","name":"beton","action":"App\Http\Controllers\BetonController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"beton\/tambah\/{id}","name":"beton.tambah","action":"App\Http\Controllers\BetonController@tambah"},{"host":null,"methods":["GET","HEAD"],"uri":"beton\/detail\/{id}","name":"beton.detail","action":"App\Http\Controllers\BetonController@detail"},{"host":null,"methods":["POST"],"uri":"beton\/simpan","name":"beton.simpan","action":"App\Http\Controllers\BetonController@simpan"},{"host":null,"methods":["GET","HEAD"],"uri":"beton\/edit\/{id}","name":"beton.edit","action":"App\Http\Controllers\BetonController@edit"},{"host":null,"methods":["POST"],"uri":"beton\/update","name":"beton.update","action":"App\Http\Controllers\BetonController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"beton\/hapus\/{id}","name":"beton.hapus","action":"App\Http\Controllers\BetonController@hapus"},{"host":null,"methods":["GET","HEAD"],"uri":"jembatan\/{id}","name":"jembatan","action":"App\Http\Controllers\JembatanController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"jembatan\/tambah\/{id}","name":"jembatan.tambah","action":"App\Http\Controllers\JembatanController@tambah"},{"host":null,"methods":["GET","HEAD"],"uri":"jembatan\/detail\/{id}","name":"jembatan.detail","action":"App\Http\Controllers\JembatanController@detail"},{"host":null,"methods":["POST"],"uri":"jembatan\/simpan","name":"jembatan.simpan","action":"App\Http\Controllers\JembatanController@simpan"},{"host":null,"methods":["GET","HEAD"],"uri":"jembatan\/edit\/{id}","name":"jembatan.edit","action":"App\Http\Controllers\JembatanController@edit"},{"host":null,"methods":["POST"],"uri":"jembatan\/update","name":"jembatan.update","action":"App\Http\Controllers\JembatanController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"jembatan\/hapus\/{id}","name":"jembatan.hapus","action":"App\Http\Controllers\JembatanController@hapus"},{"host":null,"methods":["GET","HEAD"],"uri":"penganggaran","name":"penganggaran","action":"App\Http\Controllers\PenganggaranController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"penganggaran\/jalan\/{id}","name":"penganggaran.jalan","action":"App\Http\Controllers\PenganggaranController@jalan"},{"host":null,"methods":["GET","POST","HEAD"],"uri":"penganggaran\/{id}\/langkah-1","name":"penganggaran.tambah","action":"App\Http\Controllers\PenganggaranController@step1"},{"host":null,"methods":["GET","POST","HEAD"],"uri":"penganggaran\/{id}\/langkah-2","name":"penganggaran.step2","action":"App\Http\Controllers\PenganggaranController@step2"},{"host":null,"methods":["GET","POST","HEAD"],"uri":"penganggaran\/{id}\/langkah-3","name":"penganggaran.step3","action":"App\Http\Controllers\PenganggaranController@step3"},{"host":null,"methods":["GET","HEAD"],"uri":"penganggaran\/detail\/{id}","name":"penganggaran.detail","action":"App\Http\Controllers\PenganggaranController@detail"},{"host":null,"methods":["POST"],"uri":"penganggaran\/simpan","name":"penganggaran.simpan","action":"App\Http\Controllers\PenganggaranController@simpan"},{"host":null,"methods":["GET","HEAD"],"uri":"penganggaran\/edit\/{id}","name":"penganggaran.edit","action":"App\Http\Controllers\PenganggaranController@edit"},{"host":null,"methods":["POST"],"uri":"penganggaran\/update","name":"penganggaran.update","action":"App\Http\Controllers\PenganggaranController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"penganggaran\/hapus\/{id}","name":"penganggaran.hapus","action":"App\Http\Controllers\PenganggaranController@hapus"},{"host":null,"methods":["GET","HEAD"],"uri":"njop","name":"njop","action":"App\Http\Controllers\NJOPController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"njop\/detail\/{id}","name":"njop.detail","action":"App\Http\Controllers\NJOPController@detail"},{"host":null,"methods":["POST"],"uri":"njop\/simpan","name":"njop.simpan","action":"App\Http\Controllers\NJOPController@simpan"},{"host":null,"methods":["GET","HEAD"],"uri":"njop\/edit\/{id}","name":"njop.edit","action":"App\Http\Controllers\NJOPController@edit"},{"host":null,"methods":["POST"],"uri":"njop\/update","name":"njop.update","action":"App\Http\Controllers\NJOPController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"njop\/hapus\/{id}","name":"njop.hapus","action":"App\Http\Controllers\NJOPController@hapus"},{"host":null,"methods":["GET","HEAD"],"uri":"pengguna","name":"pengguna","action":"App\Http\Controllers\UserController@index"},{"host":null,"methods":["POST"],"uri":"pengguna\/simpan","name":"pengguna.simpan","action":"App\Http\Controllers\UserController@simpan"},{"host":null,"methods":["GET","HEAD"],"uri":"pengguna\/edit\/{id}","name":"pengguna.edit","action":"App\Http\Controllers\UserController@edit"},{"host":null,"methods":["POST"],"uri":"pengguna\/update","name":"pengguna.update","action":"App\Http\Controllers\UserController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"pengguna\/hapus\/{id}","name":"pengguna.hapus","action":"App\Http\Controllers\UserController@hapus"}],
            prefix: '',

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

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
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

                if ( ! this.absolute) {
                    return url;
                }

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

