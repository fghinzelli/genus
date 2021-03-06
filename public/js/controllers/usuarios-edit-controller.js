'use strict';

angular.module('Home',)
.controller('UsuariosEditController',
['$scope', '$http', '$cookieStore', '$routeParams', '$rootScope',
function ($scope, $http, $cookieStore, $routeParams, $rootScope) {
    
    var serviceBase = 'services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.usuario = {};
    if ($rootScope.pessoa) {
        $scope.usuario.pessoa = $rootScope.pessoa;
        $rootScope.pessoa = {};
    }

    $scope.mensagem = '';
    $scope.showSuccessAlert = true;
    $scope.switchBool = function(value) {
        $scope[value] = !$scope[value];
    };

    $scope.limparSenha = function() {
        $scope.usuario.senha = '';
    }

    // GET BY ID
    if ($routeParams.usuarioId) {
        $http.get(serviceBase + 'usuarios/' + $routeParams.usuarioId)
        .success(function(usuario) {
            $scope.usuario = usuario;
            $scope.usuario.pessoa = usuario.pessoa;
        })
        .error(function(erro) {
            console.log(erro);
            $scope.mensagem = 'Não foi possível obter os dados deste usuario';
        });
    }

    // SUBMIT DO FORM - CREATE AND UPDATE
    $scope.submeterForm = function() {
        if ($scope.formulario.$valid) {
            $scope.usuario.pessoaId = $scope.usuario.pessoa.id;
            if ($routeParams.usuarioId) {
                $http.put(serviceBase + 'usuarios/' + $scope.usuario.id, $scope.usuario)
                .success(function() {
                    $rootScope.mensagem = 'Usuário alterado com sucesso';
                    window.history.back();
                })
                .error(function(error) {
                    console.log(error);
                    $scope.mensagem = 'Não foi possível alterar os dados';
                });
            } else {
                $http({method: "POST",
                       url: serviceBase + 'usuarios', 
                       data: $scope.usuario,
                       headers: {'Content-Type': 'application/json'}
                      })
                .success(function() {
                    $scope.usuario = {};
                    $rootScope.mensagem = 'Usuario cadastrado com sucesso';
                    window.history.back();
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar este usuario';
                });
            }
        }
    }

}]);
    
