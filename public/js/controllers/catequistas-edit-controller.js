'use strict';

angular.module('Home',)
.controller('CatequistasEditController',
['$scope', '$http', '$cookieStore', '$routeParams', '$rootScope',
function ($scope, $http, $cookieStore, $routeParams, $rootScope) {
    
    var serviceBase = 'services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.catequista = {};
    if ($rootScope.pessoa) {
        $scope.catequista.pessoa = $rootScope.pessoa;
        $rootScope.pessoa = {};
    }

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
            $scope.catequista.pessoa = catequista.pessoa;
        })
        .error(function(erro) {
            console.log(erro);
            $scope.mensagem = 'Não foi possível obter os dados deste catequista';
        });
    }

    // SUBMIT DO FORM - CREATE AND UPDATE
    $scope.submeterForm = function() {
        if ($scope.formulario.$valid) {
            $scope.catequista.pessoaId = $scope.catequista.pessoa.id;
            if ($routeParams.catequistaId) {
                $http.put(serviceBase + 'catequistas/' + $scope.catequista.id, $scope.catequista)
                .success(function() {
                    $rootScope.mensagem = 'Catequista alterado(a) com sucesso';
                    window.history.back();
                })
                .error(function(error) {
                    console.log(error);
                    $scope.mensagem = 'Não foi possível alterar os dados';
                });
            } else {
                $http({method: "POST",
                       url: serviceBase + 'catequistas', 
                       data: $scope.catequista,
                       headers: {'Content-Type': 'application/json'}
                      })
                .success(function() {
                    $scope.catequista = {};
                    $rootScope.mensagem = 'Catequista cadastrado(a) com sucesso';
                    window.history.back();
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar este catequista';
                });
            }
        }
    }

}]);
    
