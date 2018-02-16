'use strict';

// declare modules
angular.module('Authentication', []);
angular.module('Home', ['ngAnimate', 'ngSanitize', 'ui.bootstrap', 'ngTable']);

angular.module('Genus', [
    'Authentication',
    'Home',
    'ngRoute',
    'ngAnimate',
    'ngSanitize',
    'ngCookies',
    'ui.bootstrap',
    'ui.mask',
])
 

.config(['$routeProvider', function ($routeProvider) {

    //$locationProvider.html5Mode(true);

    $routeProvider
        .when('/login', {
            controller: 'LoginController',
            templateUrl: 'partials/login.html',
        })
 
        .when('/', {
            controller: 'HomeController',
            templateUrl: 'partials/home.html',
        })

        // PAROQUIAS
        .when('/paroquias', {
            controller: 'ParoquiasListController',
            templateUrl: 'partials/paroquias_list.html'
        })

        .when('/paroquias/new', {
            controller: 'ParoquiasEditController',
            templateUrl: 'partials/paroquias_form.html'
        })

        .when('/paroquias/edit/:paroquiaId', {
            controller: 'ParoquiasEditController',
            templateUrl: 'partials/paroquias_form.html'
        })

        // COMUNIDADES
        .when('/comunidades', {
            controller: 'ComunidadesListController',
            templateUrl: 'partials/comunidades_list.html'
        })

        .when('/comunidades/new', {
            controller: 'ComunidadesEditController',
            templateUrl: 'partials/comunidades_form.html'
        })

        .when('/comunidades/edit/:comunidadeId', {
            controller: 'ComunidadesEditController',
            templateUrl: 'partials/comunidades_form.html'
        })

        // PESSOAS
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

        // USUÁRIOS
        .when('/usuarios', {
            controller: 'UsuariosListController',
            templateUrl: 'partials/usuarios_list.html'
        })

        .when('/usuarios/new', {
            controller: 'UsuariosEditController',
            templateUrl: 'partials/usuarios_form.html'
        })

        .when('/usuarios/edit/:usuarioId', {
            controller: 'UsuariosEditController',
            templateUrl: 'partials/usuarios_form.html'
        })

        // CATEQUIZANDOS
        .when('/catequese/catequizandos', {
            controller: 'CatequizandosListController',
            templateUrl: 'partials/catequizandos_list.html'
        })

        .when('/catequese/catequizandos/new', {
            controller: 'CatequizandosEditController',
            templateUrl: 'partials/catequizandos_form.html'
        })

        .when('/catequese/catequizandos/edit/:catequizandoId', {
            controller: 'CatequizandosEditController',
            templateUrl: 'partials/catequizandos_form.html'
        })

        // CATEQUISTAS
        .when('/catequese/catequistas', {
            controller: 'CatequistasListController',
            templateUrl: 'partials/catequistas_list.html'
        })

        .when('/catequese/catequistas/new', {
            controller: 'CatequistasEditController',
            templateUrl: 'partials/catequistas_form.html'
        })

        .when('/catequese/catequistas/edit/:catequistaId', {
            controller: 'CatequistasEditController',
            templateUrl: 'partials/catequistas_form.html'
        })

        // TURMAS CATEQUESE
        .when('/catequese/turmas', {
            controller: 'TurmasListController',
            templateUrl: 'partials/turmas_list.html'
        })

        .when('/catequese/turmas/new', {
            controller: 'TurmasEditController',
            templateUrl: 'partials/turmas_form.html'
        })

        .when('/catequese/turmas/edit/:turmaId', {
            controller: 'TurmasEditController',
            templateUrl: 'partials/turmas_form.html'
        })

        // INSCRIÇÕES CATEQUESE
        .when('/catequese/inscricoes', {
            controller: 'InscricoesListController',
            templateUrl: 'partials/inscricoes_list.html'
        })

        .when('/catequese/inscricoes/new', {
            controller: 'InscricoesEditController',
            templateUrl: 'partials/inscricoes_form.html'
        })

        .when('/catequese/inscricoes/edit/:inscricaoId', {
            controller: 'InscricoesEditController',
            templateUrl: 'partials/inscricoes_form.html'
        })

        // relatórios
        .when('/catequese/relatorios', {
            controller: 'RelatoriosController',
            templateUrl: 'partials/catequese_relatorios.html'
        })
        /*
        .when('/catequese/relatorios/catequizandos-etapas', {
            controller: 'RelatoriosController',
            templateUrl: 'partials/relatorios/catequese/catequizandos_etapas.html'
        })

        .when('/catequese/relatorios/catequizandos-turmas', {
            controller: 'RelatoriosController',
            templateUrl: 'partials/relatorios/catequese/catequizandos_turmas.html'
        })

        .when('/catequese/relatorios/turmas-comunidade', {
            controller: 'RelatoriosController',
            templateUrl: 'partials/relatorios/catequese/turmas_comunidade.html'
        })

        .when('/catequese/relatorios/catequistas-comunidade', {
            controller: 'RelatoriosController',
            templateUrl: 'partials/relatorios/catequese/catequistas_comunidades.html'
        })

        .when('/catequese/relatorios/catequizandos-padrinhos', {
            controller: 'RelatoriosController',
            templateUrl: 'partials/relatorios/catequese/catequizandos_padrinhos.html'
        })
        */
        .otherwise({ redirectTo: '/' });
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
            //console.log(current);
            $rootScope.lastPage = current;
            if ($location.path() !== '/login' && !$rootScope.globals.currentUser) {
                $location.path('/login');
            }
        });
    }]);