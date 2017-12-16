'use strict';

angular.module('Home',)
.controller('ComunidadesListController',
    ['$rootScope', '$scope', '$http', '$cookieStore', '$routeParams',
    function ($rootScope, $scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.comunidades = [];
        $scope.filtro = '';
        $scope.mensagem = '';

        // Exibe a mensagem ao retornar do formulário de edição
        if($rootScope.mensagem) {
            $scope.mensagem = $rootScope.mensagem;
            $rootScope.mensagem = '';
        }
        
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE COMUNIDADES
        $http.get(serviceBase + 'comunidades')
        .success(function(comunidades) {
            $scope.comunidades = comunidades;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(comunidade) {
            $http.delete(serviceBase + 'comunidades/' + comunidade.id)
            .success(function() {
                var indiceDaComunidade = $scope.comunidades.indexOf(comunidade);
                $scope.comunidades.splice(indiceDaComunidade, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);