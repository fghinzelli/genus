'use strict';

angular.module('Home',)
.controller('PessoasEditController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = '/genus/services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        $scope.pessoas = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

        $scope.municipios = {}


        // GET BY ID
        if ($routeParams.pessoaId) {
            $http.get(serviceBase + 'pessoas/' + $routeParams.pessoaId)
            .success(function(pessoa) {
                $scope.pessoa = pessoa;
                //console.log(pessoa);
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível obter os dados desta pessoa';
            });
        }
    
        // SUBMIT DO FORM - CREATE AND UPDATE
        $scope.submeterForm = function() {
            if ($scope.formulario.$valid) {
                if ($routeParams.id) {
                    $http.put(serviceBase + 'pessoas/' + $scope.pessoa.id, $scope.pessoa)
                    .success(function() {
                        $scope.mensagem = 'Dados alterados com sucesso';
                    })
                    .error(function(error) {
                        console.log(error);
                        $scope.mensagem = 'Não foi possível alterar os dados';
                    });
                } else {
                    $http.post(serviceBase + 'pessoas/', $scope.pessoa)
                    .success(function() {
                        $scope.pessoa = {};
                        $scope.mensagem = 'Pessoas adastrada com sucesso';
                    })
                    .error(function(erro) { 
                        console.log(erro);
                        $scope.mensagem = 'Não foi possível cadastrar esta pessoa';
                    });
                }
            }
        }

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