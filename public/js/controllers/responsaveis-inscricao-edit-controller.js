'use strict';

angular.module('Home').controller('ResponsaveisCtrl',['$scope', '$http', '$routeParams', '$cookieStore', function ($scope, $http, $routeParams, $cookieStore) {
    
    var serviceBase = 'services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.responsavel = {};
    $scope.responsavel.inscricaoCatequeseId = $routeParams.inscricaoId;
    $scope.responsavel.status = 1;
    $scope.responsavel.observacoes = '';
    $scope.responsavel.dataUltimaAlteracao = null;
    $scope.responsavel.usuarioUltimaAlteracaoId = null;

    $scope.closeModal = function() {
        $scope.cancelModal();
    }

    $scope.salvar = function() {
        if($scope.responsavel.inscricaoCatequeseId) {
            $http({method: "POST",
                url: serviceBase + 'responsaveis', 
                data: $scope.responsavel,
                headers: {'Content-Type': 'application/json'}
            })
            .success(function(data) {
                $scope.saveModal(data);
            })
            .error(function(erro) { 
                console.log(erro);
                $scope.mensagem = 'Não foi possível incluir o responsável';
            }); 
        } else {
            $http.get(serviceBase + 'pessoas/' + $scope.responsavel.pessoaResponsavelId)
            .success(function(pessoa) {
                $scope.responsavel.pessoa = pessoa;

                $http.get(serviceBase + 'parentescos/' + $scope.responsavel.parentescoId)
                .success(function(parentesco) {
                    $scope.responsavel.parentesco = parentesco;
                    $scope.saveModal($scope.responsavel);
                })
                .error(function(erro) {
                    console.log(erro);
                });
            })
            .error(function(erro) {
                console.log(erro);
            });
            
        }
        
    }
}]);