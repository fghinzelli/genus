angular.module('Genus', [])
    .directive('cpfValido', function () {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function (scope, elem, attrs, ctrl) {
     
                scope.$watch(attrs.ngModel, function () {
     
                    if (elem[0].value.length == 0)
                        ctrl.$setValidity('cpfValido', true);
                    else if (elem[0].value.length < 11) {
                        //aplicar o algoritmo de validação completo do CPF
                        ctrl.$setValidity('cpfValido', false);
                    }
                    else ctrl.$setValidity('cpfValido', true);
                });
            }
        };
    });