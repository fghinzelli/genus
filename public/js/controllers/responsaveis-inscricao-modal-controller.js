angular.module('Genus').controller('ModalResponsaveisCtrl', function ($rootScope, $http, $uibModal, $log, $document) {
  var $ctrl = this;
  
  //$ctrl.items = ['item1', 'item2', 'item3'];

  $ctrl.animationsEnabled = true;
  $ctrl.turmaCatequeseInscricao = {}

  $ctrl.open = function (size, parentSelector) {
    var parentElem = parentSelector ? 
      angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
    var modalInstance = $uibModal.open({
      animation: $ctrl.animationsEnabled,
      ariaLabelledBy: 'modal-title',
      ariaDescribedBy: 'modal-body',
      templateUrl: 'myModalResponsaveisContent.html',
      //templateUrl: 'partials/pessoas_form_modal.html',
      controller: 'ModalInstanceCtrl',
      controllerAs: '$ctrl',
      size: size,
      appendTo: parentElem,
      resolve: {
        items: function () {
          //return $ctrl.items;
          return true;
        }
        
      }
    });

    // Retorno
    modalInstance.result.then(function () {
      //$ctrl.selected = selectedItem;
      console.log($ctrl);
      /*
      $http({method: "POST",
        url: serviceBase + 'turmas-catequese-inscricoes', 
        data: $scope.turmaCatequeseInscricao,
        headers: {'Content-Type': 'application/json'}
      })
      .success(function() {
        $scope.turmaCatequeseInscricao = {};
      })
      .error(function(erro) { 
        console.log(erro);
      });
      //$log.info('OK');
    }, function () {
      //$log.info('CANCELAR');
      */
    });
    
  };

  
});

// Please note that $uibModalInstance represents a modal window (instance) dependency.
// It is not the same as the $uibModal service used above.
/*
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
*/