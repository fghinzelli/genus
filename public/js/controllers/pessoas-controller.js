'use strict';

angular.module('Home',)

.controller('PessoasController',
    ['$scope', '$http', '$cookieStore',
    function ($scope, $http, $cookieStore ) {
        
        var serviceBase = '/genus/services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        $scope.pessoas = [];
        $scope.filtro = '';
        $scope.mensagem = '';
    
        $http.get(serviceBase + 'pessoas')
        .success(function(retorno) {
            $scope.pessoas = retorno.pessoas;
        })
        .error(function(erro) {
            console.log(erro)
        });
    
        $scope.remover = function(pessoa) {
    
            $http.delete(serviceBase + 'pessoas/' + pessoa.id)
            .success(function() {
                var indiceDaPessoa = $scope.pessoas.indexOf(pessoa);
                $scope.pessoas.splice(indiceDaPessoa, 1);
                $scope.mensagem = 'Pessoa ' + pessoa.nome + ' removida com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar ' + pessoa.nome;
            });
        };
    }]);