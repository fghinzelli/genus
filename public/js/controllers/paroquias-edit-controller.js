'use strict';

angular.module('Home',)
.controller('ParoquiasEditController',
['$scope', '$http', '$cookieStore', '$routeParams', '$rootScope',
function ($scope, $http, $cookieStore, $routeParams, $rootScope) {
    
    var serviceBase = 'services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.paroquia = {};
    $scope.mensagem = '';
    $scope.showSuccessAlert = true;
    $scope.switchBool = function(value) {
        $scope[value] = !$scope[value];
    };

    // Valores default para o endereço
    $scope.paroquia.cep = "95185000";
    $scope.estado = "RS";
    $scope.paroquia.municipioId = "4697";

    // GET BY ID
    if ($routeParams.paroquiaId) {
        $http.get(serviceBase + 'paroquias/' + $routeParams.paroquiaId)
        .success(function(paroquia) {
            $scope.paroquia = paroquia;
            $scope.estado = paroquia.municipio.uf;
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
                    $rootScope.mensagem = 'Paróquia alterada com sucesso';
                    window.history.back();
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
                    $rootScope.mensagem = 'Paróquia cadastrada com sucesso';
                    window.history.back();
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar esta paroquia';
                });
            }
        }
    }

}]);
    
