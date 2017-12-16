'use strict';

angular.module('Home',)
.controller('ComunidadesEditController',
['$scope', '$http', '$cookieStore', '$routeParams', '$rootScope', 
function ($scope, $http, $cookieStore, $routeParams, $rootScope) {
    
    var serviceBase = 'services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.comunidade = {};

    $scope.mensagem = '';
    $scope.showSuccessAlert = true;
    $scope.switchBool = function(value) {
        $scope[value] = !$scope[value];
    };

    // Valores default para o endereço
    $scope.comunidade.cep = "95185000";
    $scope.estado = "RS";
    $scope.comunidade.municipioId = "4697";

    // GET BY ID
    if ($routeParams.comunidadeId) {
        $http.get(serviceBase + 'comunidades/' + $routeParams.comunidadeId)
        .success(function(comunidade) {
            $scope.comunidade = comunidade;
            $scope.estado = comunidade.municipio.uf;
            //$scope.atualizarMunicipios;
        })
        .error(function(erro) {
            console.log(erro);
            $scope.mensagem = 'Não foi possível obter os dados desta comunidade';
        });
    }

    // SUBMIT DO FORM - CREATE AND UPDATE
    $scope.submeterForm = function() {
        if ($scope.formulario.$valid) {
            if ($routeParams.comunidadeId) {
                $http.put(serviceBase + 'comunidades/' + $scope.comunidade.id, $scope.comunidade)
                .success(function() {
                    $rootScope.mensagem = 'Comunidade alterada com sucesso';
                    window.history.back();
                })
                .error(function(error) {
                    console.log(error);
                    $scope.mensagem = 'Não foi possível alterar os dados';
                });
            } else {
                $http({method: "POST",
                       url: serviceBase + 'comunidades', 
                       data: $scope.comunidade,
                       headers: {'Content-Type': 'application/json'}
                      })
                .success(function() {
                    $scope.comunidade = {};
                    $rootScope.mensagem = 'Comunidade cadastrada com sucesso';
                    window.history.back();
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar esta comunidade';
                });
            }
        }
    }

}]);
    
