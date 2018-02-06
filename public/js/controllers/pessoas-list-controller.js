'use strict';

angular.module('Home',)
.controller('PessoasListController',
    ['$scope', '$rootScope', '$http', '$cookieStore', '$routeParams', 'NgTableParams',
    function ($scope, $rootScope, $http, $cookieStore, $routeParams, NgTableParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        //var data = [{name: "Moroni", age: 50}];
        //$scope.tableParams = new NgTableParams({}, { dataset: data});
        
        
        // MENSAGEM DE ALERTA
        $scope.pessoas = [];
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

    
        // LISTAGEM DE PESSOAS
        $http.get(serviceBase + 'pessoas')
        .success(function(pessoas) {
            //$scope.pessoas = pessoas;
            $scope.tableParams = new NgTableParams({}, { dataset: pessoas});
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