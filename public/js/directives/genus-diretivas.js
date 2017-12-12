angular.module('Home')
    .directive('cpfValido', function () {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function (scope, elem, attrs, ctrl) {
     
                scope.$watch(attrs.ngModel, function () {
     
                    if (elem[0].value.length == 0)
                        ctrl.$setValidity('cpfValido', true);
                    else if (elem[0].value.length < 11) {
                        ctrl.$setValidity('cpfValido', false);
                    }
                    else {
                        var vlr = elem[0].value;
                        vlr  = vlr.replace( /\./g,'').replace('-', '').replace('_', '');
                        if(validaCPF(vlr)) {
                            ctrl.$setValidity('cpfValido', true);
                        } else {
                            ctrl.$setValidity('cpfValido', false);
                        }
                    }
                });
            }
        };
    });