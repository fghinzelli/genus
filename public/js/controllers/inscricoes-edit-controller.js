'use strict';

angular.module('Home',)
.controller('InscricoesEditController',
['$scope', '$http', '$cookieStore', '$routeParams', '$rootScope', '$uibModal',
function ($scope, $http, $cookieStore, $routeParams, $rootScope, $uibModal) {
    
    var serviceBase = 'services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.inscricao = {};
    $scope.inscricao.dataUltimaAlteracao = null;
    $scope.inscricao.usuarioUltimaAlteracaoId = null;
    $scope.inscricao.responsaveis = [];
    
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
            $scope.inscricao.livroPago = (inscricao.livroPago === '1');
            $scope.inscricao.inscricaoPaga = (inscricao.inscricaoPaga === '1');
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
            if ($scope.inscricao.etapaCatequeseId != 4){
                $scope.inscricao.nomePadrinho = '';
            }
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
                       url: serviceBase + 'inscricoes-catequese', 
                       data: $scope.inscricao,
                       headers: {'Content-Type': 'application/json'}
                      })
                .success(function(data) {
                    //$scope.inscricao = {};
                    //$rootScope.mensagem = 'Inscrição cadastrado(a) com sucesso';
                    $scope.inscricao.id = data.id;
                    //console.log($scope.inscricao.id);
                    $scope.countResponsaveis = 0;
                    $scope.gravarResponsaveis();
                    //window.history.back();
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar esta inscrição';
                });
            }
        }
    }

    $scope.gravarResponsaveis = function() {
        if($scope.countResponsaveis < $scope.inscricao.responsaveis.length) {
            $scope.inscricao.responsaveis[$scope.countResponsaveis].inscricaoCatequeseId = $scope.inscricao.id;
            $http({method: "POST",
                url: serviceBase + 'responsaveis',
                data: $scope.inscricao.responsaveis[$scope.countResponsaveis],
                headers: {'Content-Type': 'application/json'}
            })
            .success(function() {
                $scope.countResponsaveis += 1;
                $scope.gravarResponsaveis();
            })
            .error(function(erro) { 
                console.log(erro);
                $scope.mensagem = 'Não foi possível cadastrar esta inscrição';
            })
        } else {
            $rootScope.mensagem = 'Inscrição cadastrado(a) com sucesso';
            window.history.back();
        }
        /*
        $scope.inscricao.responsaveis.forEach(function(element) {
            ;         
        });
        
          
        */  
    }

    // DELETE RESPONSAVEL
    $scope.removerResponsavel = function(responsavel) {
        var indiceDaLista = $scope.inscricao.responsaveis.indexOf(responsavel);
        if ($routeParams.inscricaoId) {
            $http.delete(serviceBase + 'responsaveis/' + responsavel.id)
            .success(function() {
                $scope.inscricao.responsaveis.splice(indiceDaLista, 1);
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível remover o responsável';
            });
        } else {
            $scope.inscricao.responsaveis.splice(indiceDaLista, 1);
        }
        
    };

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
                    return {'inscricao': 1};
                }
            }
        });

        modalInstance.result.then(function (response) {
            //console.log(response);
            $scope.inscricao.responsaveis.push(response);
            //$state.go('customer.detail', { 'customerId': response.CustomerId });            
        }, function () {
            console.info('Modal dismissed at: ' + new Date());
        });
    }

    $scope.cancelModal = function() {
        modalInstance.dismiss('cancel');
    }

    $scope.saveModal = function(result) {
        modalInstance.close(result);
    }
}]);
    
