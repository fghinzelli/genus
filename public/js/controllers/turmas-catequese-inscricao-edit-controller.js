'use strict';

angular.module('Home').controller('TurmasCatequeseInscricoesEditCtrl',
['$scope', '$http', '$routeParams', '$cookieStore', function ($scope, $http, $routeParams, $cookieStore) {
    
    var serviceBase = 'services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.turmaCatequeseInscricao = {};
    $scope.turmaCatequeseInscricao.turmaCatequeseId = $routeParams.turmaId;
    $scope.turmaCatequeseInscricao.status = 1;
    $scope.turmaCatequeseInscricao.dataUltimaAlteracao = null;
    $scope.turmaCatequeseInscricao.usuarioUltimaAlteracaoId = null;
    $scope.turmaCatequeseInscricao.inscricao = {};
    

    $scope.closeModal = function() {
        $scope.cancelModal();
    }

    $scope.salvar = function() {
        $scope.turmaCatequeseInscricao.inscricaoCatequeseId = $scope.turmaCatequeseInscricao.inscricao.id;
        if($scope.turmaCatequeseInscricao.turmaCatequeseId) {
            $http({method: "POST",
                url: serviceBase + 'turmas-catequese-inscricoes', 
                data: $scope.turmaCatequeseInscricao,
                headers: {'Content-Type': 'application/json'}
            })
            .success(function(data) {
                $scope.saveModal($scope.turmaCatequeseInscricao.inscricao);
            })
            .error(function(erro) { 
                console.log(erro);
                $scope.mensagem = 'Não foi possível incluir o responsável';
            }); 
        } else {
            $scope.saveModal($scope.turmaCatequeseInscricao.inscricao);
        }
        
    }
}]);