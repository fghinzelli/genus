'use strict';

angular.module('Home',)
.controller('EtapasCatequeseListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = '/genus/services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.etapasCatequese = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE ETAPAS
        $http.get(serviceBase + 'etapas-catequese')
        .success(function(etapasCatequese) {
            $scope.etapasCatequese = etapasCatequese;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(etapaCatequese) {
            $http.delete(serviceBase + 'etapas-catequese/' + etapaCatequese.id)
            .success(function() {
                var indiceDaEtapa = $scope.etapasCatequese.indexOf(etapaCatequese);
                $scope.etapasCatequese.splice(indiceDaEtapa, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);