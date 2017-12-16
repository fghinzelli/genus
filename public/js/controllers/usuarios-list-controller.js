'use strict';

angular.module('Home',)
.controller('UsuariosListController',
    ['$scope', '$rootScope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $rootScope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.usuarios = [];
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

    
        // LISTAGEM DE USUARIOS
        $http.get(serviceBase + 'usuarios')
        .success(function(usuarios) {
            $scope.usuarios = usuarios;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(usuario) {
            $http.delete(serviceBase + 'usuarios/' + usuario.id)
            .success(function() {
                var indiceDoUsuario = $scope.usuarios.indexOf(usuario);
                $scope.usuarios.splice(indiceDoUsuario, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);