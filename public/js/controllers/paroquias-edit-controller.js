'use strict';

angular.module('Home',)
.controller('ParoquiasEditController',
['$scope', '$http', '$cookieStore', '$routeParams', '$rootScope',
function ($scope, $http, $cookieStore, $routeParams, $rootScope) {
    
    var serviceBase = '/genus/services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.paroquia = {};
    $scope.estado = "RS";
    $scope.mensagem = '';
    $scope.showSuccessAlert = true;
    $scope.switchBool = function(value) {
        $scope[value] = !$scope[value];
    };

    // GET BY ID
    if ($routeParams.paroquiaId) {
        $http.get(serviceBase + 'paroquias/' + $routeParams.paroquiaId)
        .success(function(paroquia) {
            $scope.paroquia = paroquia;
            $scope.estado = paroquia.municipio.uf;
            //$scope.atualizarMunicipios;
        })
        .error(function(erro) {
            console.log(erro);
            $scope.mensagem = 'Não foi possível obter os dados desta paroquia';
        });
    }

    // SUBMIT DO FORM - CREATE AND UPDATE
    $scope.submeterForm = function() {
        if ($scope.formulario.$valid) {
            if ($routeParams.paroquiaId) {
                $http.put(serviceBase + 'paroquias/' + $scope.paroquia.id, $scope.paroquia)
                .success(function() {
                    $scope.mensagem = 'Dados alterados com sucesso';
                })
                .error(function(error) {
                    console.log(error);
                    $scope.mensagem = 'Não foi possível alterar os dados';
                });
            } else {
                $http({method: "POST",
                       url: serviceBase + 'paroquias', 
                       data: $scope.paroquia,
                       headers: {'Content-Type': 'application/json'}
                      })
                .success(function() {
                    $scope.paroquia = {};
                    $scope.mensagem = 'Paróquia cadastrada com sucesso';
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar esta paroquia';
                });
            }
        }
    }

}]);
    
