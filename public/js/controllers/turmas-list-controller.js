'use strict';

angular.module('Home',)
.controller('TurmasListController',
    ['$scope', '$rootScope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $rootScope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.turmas = [];
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

    
        // LISTAGEM DE TURMAS
        $http.get(serviceBase + 'turmas-catequese')
        .success(function(turmas) {
            $scope.turmas = turmas;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(turma) {
            $http.delete(serviceBase + 'turmas-catequese/' + turma.id)
            .success(function() {
                var indiceDoTurma = $scope.turmas.indexOf(turma);
                $scope.turmas.splice(indiceDoTurma, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);