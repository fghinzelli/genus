'use strict';

angular.module('Home',)
.controller('CatequistasEditController',
['$scope', '$http', '$cookieStore', '$routeParams',
function ($scope, $http, $cookieStore, $routeParams) {
    
    var serviceBase = '/genus/services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.filtro = '';
    $scope.mensagem = '';
    $scope.showSuccessAlert = true;
    $scope.switchBool = function(value) {
        $scope[value] = !$scope[value];
    };



    // GET BY ID
    if ($routeParams.catequistaId) {
        $http.get(serviceBase + 'catequistas/' + $routeParams.catequistaId)
        .success(function(catequista) {
            $scope.catequista = catequista;
            //console.log(catequista);
        })
        .error(function(erro) {
            console.log(erro);
            $scope.mensagem = 'Não foi possível obter os dados deste catequista';
        });
    }

    // SUBMIT DO FORM - CREATE AND UPDATE
    $scope.submeterForm = function() {
        //if ($scope.formulario.$valid) {
            $scope.catequista.status = 1;
            if ($routeParams.catequistaId) {
                $http.put(serviceBase + 'catequistas/' + $scope.catequista.id, $scope.catequista)
                .success(function() {
                    $scope.mensagem = 'Dados alterados com sucesso';
                })
                .error(function(error) {
                    console.log(error);
                    $scope.mensagem = 'Não foi possível alterar os dados';
                });
            } else {
                $http.post(serviceBase + 'catequistas', $scope.catequista)
                .success(function() {
                    $scope.catequista = {};
                    $scope.mensagem = 'Catequista adastrada com sucesso';
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar este catequista';
                });
            }
        //}
    }

}]);
    
