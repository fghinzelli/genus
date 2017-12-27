'use strict';

angular.module('Home',)
.controller('TurmaCatequeseInscricaoListController',
    ['$scope', '$rootScope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $rootScope, $http, $cookieStore, $routeParams) {  
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.inscricoes = [];
        $scope.filtro = '';
        $scope.mensagem = '';

        // Exibe a mensagem ao retornar do formulário de edição
        if($rootScope.mensagem) {
            $scope.mensagem = $rootScope.mensagem;
            $rootScope.mensagem = '';
        }

        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE INSCRICOES
        $http.get(serviceBase + 'turmas-catequese-inscricoes/turma/' +$routeParams.turmaId)
        .success(function(inscricoes) {
            $scope.inscricoes = inscricoes;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(turma) {
            $http.delete(serviceBase + 'turmas-catequese-inscricoes/' + $scope.inscricao.id)
            .success(function() {
                var indiceDaInscricao = $scope.inscricoes.indexOf(inscricao);
                $scope.inscricoes.splice(indiceDaInscricao, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }])
    .controller('TurmaCatequeseInscricaoListModalController',
        ['$scope', '$rootScope', '$http', '$cookieStore', '$routeParams',
        function ($scope, $rootScope, $http, $cookieStore, $routeParams) {
            
            var serviceBase = 'services/';
            var globals = $cookieStore.get('globals');
            $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];

            var etapaCatequeseId = $rootScope.etapaCatequeseId;

            // LISTAGEM DE INSCRICOES DA ETAPA 
            $http.get(serviceBase + 'inscricoes-catequese/etapa/' + etapaCatequeseId)
            .success(function(inscricoes) {
                $scope.inscricoes = inscricoes;
                //console.log(inscricoes);
            })
            .error(function(erro) {
                console.log(erro)
            });
    }]);