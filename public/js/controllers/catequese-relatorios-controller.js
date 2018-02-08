'use strict';

angular.module('Home',)
.controller('RelatoriosController',
    ['$rootScope', '$scope', '$http', '$cookieStore', '$routeParams', '$window', 
    function ($rootScope, $scope, $http, $cookieStore, $routeParams, $window) {
        
        var serviceBase = 'services/relatorios';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        $scope.getReport = function(relatorio) {
            $window.open('services/relatorios/' + relatorio, '_blank');
        }
    }]);