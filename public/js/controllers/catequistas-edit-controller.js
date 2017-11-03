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

    }])
.controller('ModalDemoCtrl', function ($uibModal, $log, $document) {
    var $ctrl = this;
    $ctrl.items = ['item1', 'item2', 'item3'];
    
    $ctrl.animationsEnabled = true;
    
    $ctrl.open = function (size, parentSelector) {
        var parentElem = parentSelector ? 
        angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
        var modalInstance = $uibModal.open({
        animation: $ctrl.animationsEnabled,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: 'myModalContent.html',
        controller: 'ModalInstanceCtrl',
        controllerAs: '$ctrl',
        size: size,
        appendTo: parentElem,
        resolve: {
            items: function () {
            return $ctrl.items;
            }
        }
        });
    
        modalInstance.result.then(function (selectedItem) {
        $ctrl.selected = selectedItem;
        }, function () {
        $log.info('Modal dismissed at: ' + new Date());
        });
    };
    
    $ctrl.openComponentModal = function () {
        var modalInstance = $uibModal.open({
        animation: $ctrl.animationsEnabled,
        component: 'modalComponent',
        resolve: {
            items: function () {
            return $ctrl.items;
            }
        }
        });
    
        modalInstance.result.then(function (selectedItem) {
        $ctrl.selected = selectedItem;
        }, function () {
        $log.info('modal-component dismissed at: ' + new Date());
        });
    };
    
    $ctrl.openMultipleModals = function () {
        $uibModal.open({
        animation: $ctrl.animationsEnabled,
        ariaLabelledBy: 'modal-title-bottom',
        ariaDescribedBy: 'modal-body-bottom',
        templateUrl: 'stackedModal.html',
        size: 'sm',
        controller: function($scope) {
            $scope.name = 'bottom';  
        }
        });
    
        $uibModal.open({
        animation: $ctrl.animationsEnabled,
        ariaLabelledBy: 'modal-title-top',
        ariaDescribedBy: 'modal-body-top',
        templateUrl: 'stackedModal.html',
        size: 'sm',
        controller: function($scope) {
            $scope.name = 'top';  
        }
        });
    };
    
    $ctrl.toggleAnimation = function () {
        $ctrl.animationsEnabled = !$ctrl.animationsEnabled;
    };
})    
// Please note that $uibModalInstance represents a modal window (instance) dependency.
// It is not the same as the $uibModal service used above.
    
.controller('ModalInstanceCtrl', function ($uibModalInstance, items) {
    var $ctrl = this;
    $ctrl.items = items;
    $ctrl.selected = {
        item: $ctrl.items[0]
    };
    
    $ctrl.ok = function () {
        $uibModalInstance.close($ctrl.selected.item);
    };
    
    $ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});
    
