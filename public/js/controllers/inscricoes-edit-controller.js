'use strict';

angular.module('Home',)
.controller('InscricoesEditController',
['$scope', '$http', '$cookieStore', '$routeParams', '$rootScope',
function ($scope, $http, $cookieStore, $routeParams, $rootScope) {
    
    var serviceBase = 'services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.inscricao = {};
    if ($rootScope.pessoa) {
        $scope.inscricao.pessoa = $rootScope.pessoa;
        $rootScope.pessoa = {};
    }

    $scope.filtro = '';
    $scope.mensagem = '';
    $scope.showSuccessAlert = true;
    $scope.switchBool = function(value) {
        $scope[value] = !$scope[value];
    };

    // GET BY ID
    if ($routeParams.inscricaoId) {
        $http.get(serviceBase + 'inscricoes-catequese/' + $routeParams.inscricaoId)
        .success(function(inscricao) {
            //console.log(inscricao);
            $scope.inscricao = inscricao;
            $scope.inscricao.pessoa = inscricao.pessoa;
        })
        .error(function(erro) {
            console.log(erro);
            $scope.mensagem = 'Não foi possível obter os dados desta Inscrição';
        });
    }

    // SUBMIT DO FORM - CREATE AND UPDATE
    $scope.submeterForm = function() {
        if ($scope.formulario.$valid) {
            $scope.inscricao.pessoaId = $scope.inscricao.pessoa.id;
            if ($routeParams.inscricaoId) {
                $http.put(serviceBase + 'inscricoes-catequese/' + $scope.inscricao.id, $scope.inscricao)
                .success(function() {
                    $rootScope.mensagem = 'Inscrição alterada com sucesso';
                    window.history.back();
                })
                .error(function(error) {
                    console.log(error);
                    $scope.mensagem = 'Não foi possível alterar os dados';
                });
            } else {
                $http({method: "POST",
                       url: serviceBase + 'inscrições', 
                       data: $scope.inscricao,
                       headers: {'Content-Type': 'application/json'}
                      })
                .success(function() {
                    $scope.inscricao = {};
                    $rootScope.mensagem = 'Inscrição cadastrado(a) com sucesso';
                    window.history.back();
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar esta inscrição';
                });
            }
        }
    }

}]);
    
