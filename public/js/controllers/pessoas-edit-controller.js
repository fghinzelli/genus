'use strict';

angular.module('Home',)
.controller('PessoasEditController',
    ['$scope', '$http', '$cookieStore', '$routeParams', '$location', '$rootScope',
    function ($scope, $http, $cookieStore, $routeParams, $location, $rootScope) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        $scope.pessoa = {};
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };


        // Valores default
        $scope.pessoa.nacionalidade = "Brasileira";
        $scope.pessoa.cep = "95185000";
        $scope.estado = "RS";
        $scope.pessoa.municipioId = "4697";

        // GET BY ID
        if ($routeParams.pessoaId) {
            $http.get(serviceBase + 'pessoas/' + $routeParams.pessoaId)
            .success(function(pessoa) {
                $scope.pessoa = pessoa;
                $scope.estado = pessoa.municipio.uf;
                $scope.pessoa.batizado = (pessoa.batizado === '1');
                $scope.pessoa.primeiraEucaristia = (pessoa.primeiraEucaristia === '1');

                if (($scope.pessoa.localBatismo != null) &&
                    ($scope.pessoa.localBatismo != 'Nossa Senhora Mãe de Deus - Carlos Barbosa') &&
                    ($scope.pessoa.localBatismo != 'Nossa Senhora das Graças - Arcoverde - Carlos Barbosa')) {
                    $scope.pessoa.localBatismoOutro = $scope.pessoa.localBatismo;
                    $scope.pessoa.localBatismo = 'Outro';   
                }

                if (($scope.pessoa.localPrimeiraEucaristia != null) &&
                    ($scope.pessoa.localPrimeiraEucaristia != 'Nossa Senhora Mãe de Deus - Carlos Barbosa') &&
                    ($scope.pessoa.localPrimeiraEucaristia != 'Nossa Senhora das Graças - Arcoverde - Carlos Barbosa')) {
                    $scope.pessoa.localPrimeiraEucaristiaOutro = $scope.pessoa.localPrimeiraEucaristia;
                    $scope.pessoa.localPrimeiraEucaristia = 'Outro';  
                }
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível obter os dados desta pessoa';
            });
        }
    
        // SUBMIT DO FORM - CREATE AND UPDATE
        $scope.submeterForm = function() {
            if ($scope.formulario.$valid) {
                if ($scope.pessoa.localBatismo == 'Outro') {
                    $scope.pessoa.localBatismo = $scope.pessoa.localBatismoOutro;
                }
                if ($scope.pessoa.localPrimeiraEucaristia == 'Outro') {
                    $scope.pessoa.localPrimeiraEucaristia = $scope.pessoa.localPrimeiraEucaristiaOutro;
                }
                if ($routeParams.pessoaId) {
                    $http.put(serviceBase + 'pessoas/' + $scope.pessoa.id, $scope.pessoa)
                    .success(function() {
                        $rootScope.mensagem = 'Pessoa alterada com sucesso';
                        window.history.back();
                    })
                    .error(function(error) {
                        console.log(error);
                        $scope.mensagem = 'Não foi possível alterar os dados';
                    });
                } else {
                    $http.post(serviceBase + 'pessoas', $scope.pessoa)
                    .success(function(pessoa) {
                        $rootScope.pessoa = pessoa;
                        $scope.pessoa = {};
                        $rootScope.mensagem = 'Pessoa cadastrada com sucesso';
                        window.history.back();
                    })
                    .error(function(erro) { 
                        console.log(erro);
                        $scope.mensagem = 'Não foi possível cadastrar esta pessoa';
                    });
                }
            }
        }

        function dataValida(str) {
            return !!new Date(str).getTime();
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