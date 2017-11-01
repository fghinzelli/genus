angular.module('Home')
    .controller('MunicipiosController', function($scope, $http, $cookieStore) {

    $scope.estados = [];
    $scope.municipios = [];

    var serviceBase = '/genus/services/';
    var globals = $cookieStore.get('globals');
    $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];

    $http.get(serviceBase + 'estados')
        .success(function(estados) {
            $scope.estados = estados;
            //console.log(estados);
        })
        .error(function(erro) {
            console.log(erro);
        });

    $scope.atualizarMunicipios = function() {
        $http.get(serviceBase + 'municipios/' + $scope.estado)
        .success(function(municipios) {
            $scope.municipios = municipios;
            //console.log(municipios);
        })
        .error(function(erro) {
            console.log(erro);
        });
    };

});

