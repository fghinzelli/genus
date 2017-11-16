'use strict';

angular.module('Home',)
.controller('TurmasEditController',
['$scope', '$http', '$cookieStore', '$routeParams',
function ($scope, $http, $cookieStore, $routeParams,) {
    
    var serviceBase = '/genus/services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
    
    $scope.turma = {};
    $scope.filtro = '';
    $scope.mensagem = '';
    $scope.showSuccessAlert = true;
    $scope.switchBool = function(value) {
        $scope[value] = !$scope[value];
    };

    // GET BY ID
    if ($routeParams.turmaId) {
        $http.get(serviceBase + 'turmas-catequese/' + $routeParams.turmaId)
        .success(function(turma) {
            $scope.turma = turma;
            $scope.turma.etapaCatequese = turma.etapaCatequese;
            $scope.turma.comunidade = turma.comunidade;
            $scope.turma.catequista = turma.catequista;
            $scope.turma.turno = turma.turno;
        })
        .error(function(erro) {
            console.log(erro);
            $scope.mensagem = 'Não foi possível obter os dados desta turma';
        });
    }

    $scope.goBack = function() {
        $window.history.back();
    }

    // SUBMIT DO FORM - CREATE AND UPDATE
    $scope.submeterForm = function() {
        //if ($scope.formulario.$valid) {
            //console.log($scope.turma);         
            if ($routeParams.turmaId) {
                $http.put(serviceBase + 'turmas-catequese/' + $scope.turma.id, $scope.turma)
                .success(function() {
                    $scope.mensagem = 'Dados alterados com sucesso';
                })
                .error(function(error) {
                    console.log(error);
                    $scope.mensagem = 'Não foi possível alterar os dados';
                });
            } else {
                $scope.turma.etapaCatequeseId = $scope.turma.etapaCatequese.id;
                $scope.turma.catequistaId = $scope.turma.catequista.id;
                $scope.turma.turnoId = $scope.turma.turno.id;
                $scope.turma.comunidadeId = $scope.turma.comunidade.id;
                //console.log($scope.catequista);
                $http({method: "POST",
                       url: serviceBase + 'turmas-catequese', 
                       data: $scope.turma,
                       headers: {'Content-Type': 'application/json'}
                      })
                .success(function() {
                    $scope.turma = {};
                    $scope.mensagem = 'Turma cadastrada com sucesso';
                })
                .error(function(erro) { 
                    console.log(erro);
                    $scope.mensagem = 'Não foi possível cadastrar esta turma';
                });
            }
        //}
    }

}]);
    