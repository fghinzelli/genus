'use strict';

angular.module('Home',)
.controller('ResponsaveisInscricaoListController',
    ['$scope', '$rootScope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $rootScope, $http, $cookieStore, $routeParams) {  
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        $scope.responsaveis = [];
    
        // LISTAGEM DE INSCRICOES
        $http.get(serviceBase + 'responsaveis/inscricao/' +$routeParams.inscricaoId)
        .success(function(responsaveis) {
            $scope.responsaveis = responsaveis;
            console.log(responsaveis);
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(responsavel) {
            $http.delete(serviceBase + 'responsaveis/' + $scope.responsavel.id)
            .success(function() {
                var indiceDoResponsavel = $scope.responsaveis.indexOf(responsavel);
                $scope.responsaveis.splice(indiceDoResponsavel, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);