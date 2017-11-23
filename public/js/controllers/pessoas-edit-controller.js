'use strict';

angular.module('Home',)
.controller('PessoasEditController',
    ['$scope', '$http', '$cookieStore', '$routeParams', '$location', '$rootScope',
    function ($scope, $http, $cookieStore, $routeParams, $location, $rootScope) {
        
        var serviceBase = '/genus/services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        $scope.pessoa = {};

        // Valores default
        $scope.pessoa.nacionalidade = "Brasileira";
        $scope.pessoa.cep = "95185000";
        //$scope.estado = "RS";
        //$scope.atualizarMunicipios;
        //$scope.pessoa.municipioId = "4697";
        

        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

        


        // GET BY ID
        if ($routeParams.pessoaId) {
            $http.get(serviceBase + 'pessoas/' + $routeParams.pessoaId)
            .success(function(pessoa) {
                $scope.pessoa = pessoa;
                $scope.estado = pessoa.municipio.uf;
                //$scope.rgEstado = $scope.pessoa.rgUF;
                //$scope.pessoa.rgUF = pessoa.rgUF;
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
                //$scope.pessoa.rgUF = $scope.pessoa.rgUF.uf;
                //console.log($scope.pessoa);
                if ($routeParams.pessoaId) {
                    $http.put(serviceBase + 'pessoas/' + $scope.pessoa.id, $scope.pessoa)
                    .success(function() {
                        $scope.mensagem = 'Dados alterados com sucesso';
                        //window.history.back();
                    })
                    .error(function(error) {
                        console.log(error);
                        $scope.mensagem = 'Não foi possível alterar os dados';
                    });
                } else {
                    $http.post(serviceBase + 'pessoas', $scope.pessoa)
                    .success(function(pessoa) {
                        $rootScope.pessoa = pessoa;
                        console.log(pessoa);
                        $scope.pessoa = {};
                        $scope.mensagem = 'Pessoa cadastrada com sucesso';
                        window.history.back();
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

        //Funcao executada no clique do botão voltar
        $scope.$back = function() { 
            window.history.back();
        };
        

    }]);