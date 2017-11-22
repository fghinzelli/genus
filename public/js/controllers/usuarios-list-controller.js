'use strict';

angular.module('Home',)
.controller('UsuariosListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = '/genus/services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.usuarios = [];
        $scope.filtro = '';
        $scope.mensagem = '';
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