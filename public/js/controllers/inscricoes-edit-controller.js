'use strict';

angular.module('Home',)
.controller('InscricoesEditController',
['$scope', '$http', '$cookieStore', '$routeParams', '$rootScope', '$uibModal',
function ($scope, $http, $cookieStore, $routeParams, $rootScope, $uibModal) {
    
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

    var modalInstance = '';
    $scope.incluirResponsavel = function (task) {
        modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'partials/responsavel_form.html',
            controller: 'ResponsaveisCtrl',
            scope: $scope,
            size: 'lg',
            backdrop: 'static',
            // Parametros enviados para o modal controller       
            resolve: {
                responsavel: function () {
                    //return $scope.responsavel;
                    return 'xxxxxx abacaxi xxxxxx';
                }
            }
        });
    }

    $scope.open = function (size) {        
        
        modalInstance.result.then(function (response) {
            debugger;            
            $scope.currentResponsavel = response;
            //$state.go('customer.detail', { 'customerId': response.CustomerId });            
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };
    

}]);
    
