'use strict';

angular.module('Home',)
.controller('PessoasListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = '/genus/services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.pessoas = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE PESSOAS
        $http.get(serviceBase + 'pessoas')
        .success(function(retorno) {
            $scope.pessoas = retorno.pessoas;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(pessoa) {
            $http.delete(serviceBase + 'pessoas/' + pessoa.id)
            .success(function() {
                var indiceDaPessoa = $scope.pessoas.indexOf(pessoa);
                $scope.pessoas.splice(indiceDaPessoa, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);