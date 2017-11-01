'use strict';

// declare modules
angular.module('Authentication', []);
angular.module('Home', []);

angular.module('Genus', [
    'Authentication',
    'Home',
    'ngRoute',
    'ngCookies',
    'ui.bootstrap'
])
 

.config(['$routeProvider', function ($routeProvider) {

    //$locationProvider.html5Mode(true);

    $routeProvider
        .when('/login', {
            controller: 'LoginController',
            templateUrl: 'partials/login.html',
            hideMenus: true
        })
 
        .when('/', {
            controller: 'HomeController',
            templateUrl: 'partials/home.html'
        })

        .when('/pessoas', {
            controller: 'PessoasListController',
            templateUrl: 'partials/pessoas_list.html'
        })

        .when('/pessoas/new', {
            controller: 'PessoasEditController',
            templateUrl: 'partials/pessoas_form.html'
        })

        .when('/pessoas/edit/:pessoaId', {
            controller: 'PessoasEditController',
            templateUrl: 'partials/pessoas_form.html'
        })

        .otherwise({ redirectTo: '/login' });
}])

.run(['$rootScope', '$location', '$cookieStore', '$http',
    function ($rootScope, $location, $cookieStore, $http) {
        // keep user logged in after page refresh
        $rootScope.globals = $cookieStore.get('globals') || {};
        if ($rootScope.globals.currentUser) {
            $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
        }
 
        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            // redirect to login page if not logged in
            if ($location.path() !== '/login' && !$rootScope.globals.currentUser) {
                $location.path('/login');
            }
        });
    }]);