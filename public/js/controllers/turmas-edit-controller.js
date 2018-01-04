'use strict';

angular.module('Home',)
.controller('TurmasEditController',
['$scope', '$http', '$cookieStore', '$routeParams', '$rootScope', '$uibModal',
function ($scope, $http, $cookieStore, $routeParams, $rootScope, $uibModal) {
    
    var serviceBase = 'services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.turma = {};
    $scope.turma.dataUltimaAlteracao = null;
    $scope.turma.usuarioUltimaAlteracaoId = null;
    $scope.turma.inscricoes = [];
    $scope.filtro = '';
    $scope.mensagem = '';
    $scope.showSuccessAlert = true;
    $scope.switchBool = function(value) {
        $scope[value] = !$scope[value];
    };

    $scope.setEtapa = function() {
        $rootScope.etapaCatequeseId = $scope.turma.etapaCatequeseId;
    };

    $scope.setAnoLetivo = function() {
        $rootScope.anoLetivoId = $scope.turma.anoLetivoId;
    };

    // GET BY ID
    if ($routeParams.turmaId) {
        $http.get(serviceBase + 'turmas-catequese/' + $routeParams.turmaId)
        .success(function(turma) {
            $scope.turma = turma;
            $rootScope.etapaCatequeseId = $scope.turma.etapaCatequeseId;
            $rootScope.anoLetivoId = $scope.turma.anoLetivoId;
            $rootScope.turmaId = $scope.turma.id;
        })
        .error(function(erro) {
            console.log(erro);
            $scope.mensagem = 'Não foi possível obter os dados desta turma';
        });
    }

    $scope.goBack = function() {
        $window.history.back();
    }

    // SUBMIT DO FORM - CREATE AND UPDATE
    $scope.submeterForm = function() {
        if ($scope.formulario.$valid) {   
            if ($routeParams.turmaId) {
                $http.put(serviceBase + 'turmas-catequese/' + $scope.turma.id, $scope.turma)
                .success(function() {
                    $rootScope.mensagem = 'Turma alterada com sucesso';
                    window.history.back();
                })
                .error(function(error) {
                    console.log(error);
                    $scope.mensagem = 'Não foi possível alterar os dados';
                });
            } else {
                //$scope.turma.etapaCatequeseId = $scope.turma.etapaCatequese.id;
                //$scope.turma.catequistaId = $scope.turma.catequista.id;
                //$scope.turma.turnoId = $scope.turma.turno.id;
                //$scope.turma.comunidadeId = $scope.turma.comunidade.id;
                $http({method: "POST",
                       url: serviceBase + 'turmas-catequese', 
                       data: $scope.turma,
                       headers: {'Content-Type': 'application/json'}
                      })
                .success(function(data) {
                    //console.log(data);
                    $scope.turma.id = data.id;
                    //console.log($scope.inscricao.id);
                    $scope.countInscricoes = 0;
                    $scope.gravarInscricoes();
                    //$scope.turma = {};
                    //$rootScope.mensagem = 'Turma cadastrada com sucesso';
                    //window.history.back();
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar esta turma';
                });
            }
        }
    }

    $scope.gravarInscricoes = function() {
        if($scope.countInscricoes < $scope.turma.inscricoes.length) {
            var turmaCatequeseInscricao = {};
            turmaCatequeseInscricao.turmaCatequeseId = $scope.turma.id;
            turmaCatequeseInscricao.inscricaoCatequeseId = $scope.turma.inscricoes[$scope.countInscricoes].id;
            turmaCatequeseInscricao.status = 1;
            $http({method: "POST",
                url: serviceBase + 'turmas-catequese-inscricoes',
                data: turmaCatequeseInscricao,
                headers: {'Content-Type': 'application/json'}
            })
            .success(function() {
                $scope.countInscricoes += 1;
                $scope.gravarInscricoes();
            })
            .error(function(erro) { 
                console.log(erro);
                $scope.mensagem = 'Não foi possível cadastrar esta turma';
            })
        } else {
            $rootScope.mensagem = 'Turma cadastrado(a) com sucesso';
            window.history.back();
        }
    }

    // DELETE RESPONSAVEL
    $scope.removerInscricao = function(inscricao) {
        var indiceDaLista = $scope.turma.inscricoes.indexOf(inscricao);
        if ($routeParams.turmaId) {
            $http.delete(serviceBase + 'turmas-catequese-inscricoes/' + inscricao.id)
            .success(function() {
                $scope.turma.inscricoes.splice(indiceDaLista, 1);
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível remover o responsável';
            });
        } else {
            $scope.turma.inscricoes.splice(indiceDaLista, 1);
        }
        
    };

    var modalInstance = '';
    $scope.incluirInscricao = function (task) {
        modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'partials/turmas_catequese_inscricoes_form.html',
            controller: 'TurmasCatequeseInscricoesEditCtrl',
            scope: $scope,
            size: 'lg',
            backdrop: 'static',
            // Parametros enviados para o modal controller       
            resolve: {

                /*
                inscricao: function () {
                    //return $scope.responsavel;
                    return {'inscricao': 1};
                }
                */
            }
        });

        modalInstance.result.then(function (response) {
            //console.log(response);
            $scope.turma.inscricoes.push(response);
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
    
