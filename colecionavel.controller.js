(function () {
    'use strict';

    angular
            .module('colecionavel.module')
            .controller('ColecionavelController', AppController);

    AppController.$inject = ['$scope','$rootScope', '$log','$state'];


    function AppController($scope, $rootScope, $log, $state) {
        var vm = this;
        vm.titulo = "Colecionável";
        vm.getHome = getHome;

        function activate() {
            vm.getHome();
        }

        function getHome (){
             $state.go('index');
        }

//        $rootScope.$on('$stateChangeError', function(event) {
 // $state.go('404');
//});

        activate();

    }
})();
