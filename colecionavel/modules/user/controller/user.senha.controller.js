(function() {
    'use strict';

    angular
        .module('colecionavel.module.user')
        .controller('UserSenhaController', UserSenhaController);

    UserSenhaController.$inject = ['$scope', 'UserFactory', 'UserService', '$state','$rootScope','ScrollToService'];


    function UserSenhaController($scope, UserFactory, UserService, $state, $rootScope,ScrollToService) {
        //Atributos
        var vm = this;
        vm.titulo = undefined;
        vm.user = undefined;
        vm.alerts = [];
        var urlImgDefault = './assets/img/user-medium.png';
        vm.isView = false;
        vm.log = undefined;

        //Instancia Metodos
        vm.cadastrar = cadastrar;
        vm.removerImagem = removerImagem;
        vm.findUserById = findUserById;
        vm.addAlert = addAlert;
        vm.closeAlert = closeAlert;
        //vm.montarLog = montarLog;
        //vm.createLog = createLog;

        //Metodos
        function removerImagem(form){
            vm.user.foto = urlImgDefault;         
        }


        function addAlert(type, message) {        
            vm.alerts.push({
                "type": type,
                "msg": message
            });
        }

        function closeAlert(index) {
            vm.alerts.splice(index, 1);
        }

        function activate() {
            UserFactory.setUser($rootScope.usuario); //Temporario 
            var objeto = UserFactory.getUser();
            objeto.isView = false; //Temporario 
            verificarTitulo(objeto);
            if (angular.isUndefined(objeto)) {                
                removeloader();
            }else{
                vm.isView = objeto.isView;
                vm.findUserById(objeto.id);                
            }
            UserFactory.limparUser();
            ScrollToService.scrollToTop( 0, 600);
        }

        function verificarTitulo(objeto){
            vm.titulo = "Atualização de Senha de Acesso";            
        }

        function cadastrar(form) {
            vm.alerts = [];
            if (form.$valid) {
                addloader();
                var userConverted = UserFactory.convertBackSenha(vm.user);
                if (!angular.isUndefined(userConverted.id)) {              
                    UserService.updateSenha(userConverted).then(function onSuccess(response) {
                        vm.addAlert('alert-success', response.data.message);
                        //vm.createLog();
                        //$state.go('home');
                        ScrollToService.scrollToTop( 0, 600);
                        removeloader();
                    }).catch(function onError(response) {
                        vm.addAlert('alert-danger', 'Erro!');
                        UserService.checkStatus(response);
                        removeloader();
                        ScrollToService.scrollToTop( 0, 600);
                    });                    
                }else{
                    vm.addAlert('alert-danger', 'Preencha os campos obrigatórios!');    
                    ScrollToService.scrollToTop( 0, 600);
                    removeloader();
                }
            }else{
                vm.addAlert('alert-danger', 'Preencha os campos obrigatórios!');
                ScrollToService.scrollToTop( 0, 600);
                removeloader();
            }

        }

        function findUserById(codigo) {
            addloader();
            UserService.findUserById(codigo).then(function onSuccess(response) {
                vm.user = UserFactory.convert(response.data);                
                removeloader();
            }).catch(function onError(response) {
                vm.addAlert('alert-danger', 'Erro!');
                UserService.checkStatus(response);
                removeloader();
            });
        };

        $scope.uploadFile = function (element,posicao) {
            var file = element.files;
            vm.user.fotoName = file[0].name;
            vm.user.fotoFile = file[0];
            var reader = new FileReader();
            reader.onload = function (loadEvent) {
                $scope.$apply(function () {
                    vm.user.foto = loadEvent.target.result;                   
                    //vm.montarLog(3);
                });
            };
            reader.readAsDataURL(file[0]);
            $scope.$apply();            
        };



        activate();

    }
})();