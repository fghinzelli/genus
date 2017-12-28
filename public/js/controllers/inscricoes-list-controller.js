'use strict';

angular.module('Home',)
.controller('InscricoesListController',
    ['$scope', '$rootScope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $rootScope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.inscricoes = [];
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

    
        // LISTAGEM DE INSCRICOES
        $http.get(serviceBase + 'inscricoes-catequese')
        .success(function(inscricoes) {
            $scope.inscricoes = inscricoes;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(pessoa) {
            $http.delete(serviceBase + 'inscricoes-catequese/' + inscricao.id)
            .success(function() {
                var indiceDaInscricao = $scope.inscricoes.indexOf(inscricao);
                $scope.inscricoes.splice(indiceDaInscricao, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);