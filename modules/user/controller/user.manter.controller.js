(function() {
    'use strict';

    angular
        .module('colecionavel.module.user')
        .controller('UserManterController', UserManterController);

    UserManterController.$inject = ['$scope', 'UserFactory', 'UserService', '$state','$rootScope','ScrollToService'];


    function UserManterController($scope, UserFactory, UserService, $state, $rootScope,ScrollToService) {
        //Atributos
        var vm = this;
        vm.titulo = undefined;
        vm.user = undefined;
        vm.alerts = [];
        var urlImgDefault = './assets/img/user-medium.png';
        var urlBgDefault = './assets/img/profile-bg.png';
        vm.isView = false;
        vm.log = undefined;

        //Instancia Metodos
        vm.cadastrar = cadastrar;
        vm.removerImagem = removerImagem;
        vm.findUserById = findUserById;
        vm.addAlert = addAlert;
        vm.closeAlert = closeAlert;

        //Metodos
        function removerImagem(form,posicao){
            switch(posicao) {
                case 1:
                     vm.user.foto = urlImgDefault;  
                    break;   
                case 2:
                     vm.user.fundo = urlBgDefault;
                    break;                                    
            }                   
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
            UserFactory.setUser($rootScope.usuario); 
            var objeto = UserFactory.getUser();
            objeto.isView = false;
            verificarTitulo(objeto);
            if (angular.isUndefined(objeto)) {
                vm.user = {
                    foto: urlImgDefault,
                    fundo: urlBgDefault
                };
                removeloader();
            } else {
                vm.isView = objeto.isView;
                vm.findUserById(objeto.id);                
            }
            UserFactory.limparUser();
            ScrollToService.scrollToTop( 0, 600);
        }

        function verificarTitulo(objeto){
            if (angular.isUndefined(objeto)) {
                vm.titulo = "Cadastrado de um novo Usuário";
            }else if(objeto.isView){
                vm.titulo = "Visualização do Usuário";
            }else{
                vm.titulo = "Edição do Usuário";
            }
        }

        function cadastrar(form) {
            vm.alerts = [];
            if (form.$valid) {
                addloader();
                var userConverted = UserFactory.convertBack(vm.user);
                if (angular.isUndefined(userConverted.id)) {
                    
                    UserService.create(userConverted).then(function onSuccess(response) {                        
                        activate();
                        vm.addAlert('alert-success', response.data.message);
                        removeloader();
                        ScrollToService.scrollToTop( 0, 600);
                    }).catch(function onError(response) {
                        vm.addAlert('alert-danger', response.data.message);
                        UserService.checkStatus(response);
                        removeloader();
                        ScrollToService.scrollToTop( 0, 600);
                    });                    
                } else {                    
                    UserService.update(userConverted).then(function onSuccess(response) {
                        vm.addAlert('alert-success', response.data.message);
                        //$state.go('home');
                        removeloader();
                        ScrollToService.scrollToTop( 0, 600);
                    }).catch(function onError(response) {
                        vm.addAlert('alert-danger', response.data.message);
                        UserService.checkStatus(response);
                        removeloader();
                        ScrollToService.scrollToTop( 0, 600);
                    });                    
                }
            }else{
                vm.addAlert('alert-danger', 'Preencha os campos obrigatórios!');
                ScrollToService.scrollToTop( 0, 600);                
            }

        }

        function findUserById(codigo) {
            addloader();
            UserService.findUserById(codigo).then(function onSuccess(response) {
                vm.user = UserFactory.convert(response.data);                
                removeloader();
            }).catch(function onError(response) {
                vm.addAlert('alert-danger', response.data.message);
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
                    switch(posicao) {
                        case 1:
                             vm.user.foto = loadEvent.target.result;
                            break;   
                        case 2:
                             vm.user.fundo = loadEvent.target.result;
                            break;
                    }                  
                    
                });
            };
            reader.readAsDataURL(file[0]);
            $scope.$apply();            
        };



        activate();

    }
})();