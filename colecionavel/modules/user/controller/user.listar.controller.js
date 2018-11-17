(function () {
    'use strict';

    angular
    .module('colecionavel.module.user')
    .controller('UserListarController', UserListarController);

    UserListarController.$inject = ['$scope','UserService','UserFactory','$state','UserService','$uibModal'];


    function UserListarController($scope, UserService,UserFactory,$state,UserService,$uibModal) {
        //Atributos
        var vm = this;
        vm.titulo = "Listagem do Proprietário";  
        vm.itens = [];
        vm.user = {};
        vm.maxSize = 3;
        vm.totalUsers = 0;
        vm.currentPage = 1;
        vm.registrosPorPagina = "5";
        vm.selectTop = ["5","10","15","20"];
        vm.order = 'titulo';
        vm.sort = true;
        vm.animationsEnabled = true;
        
        //Instancia Metodos
        vm.findByFilter = findByFilter;
        vm.atualizar = atualizar;
        vm.remover = remover;
        vm.visualizar = visualizar;
        vm.registrosPorPaginaAlterados = registrosPorPaginaAlterados;
        vm.pesquisar = pesquisar;
        vm.sorter = sorter;
        vm.sorterIconCheck = sorterIconCheck;
        vm.limparCampos = limparCampos;
        vm.modalExcluir = modalExcluir;    

        function limparCampos(){
            vm.user = {};
        }
        

        //Metodos
        function sorter(ordem){
            vm.sort = !vm.sort;
            vm.order = ordem;
            vm.findByFilter(vm.currentPage,vm.registrosPorPagina,vm.user,vm.order,vm.sort);
        }

        function sorterIconCheck(coluna){
            if(coluna === vm.order && vm.sort === true){
                return 'sorting_asc';
            }else if(coluna === vm.order && vm.sort === false){
                return 'sorting_desc';
            }else{
                return 'sorting';
            }
        }

        function pesquisar(){
            vm.findByFilter(vm.currentPage,vm.registrosPorPagina,vm.user,vm.order,vm.sort);
        }
        
        function registrosPorPaginaAlterados(){
            vm.findByFilter(vm.currentPage,vm.registrosPorPagina,vm.user,vm.order,vm.sort);
        }

        vm.setPage = function (pageNo) {
            vm.currentPage = pageNo;
        };

        vm.pageChanged = function() {
            vm.findByFilter(vm.currentPage,vm.registrosPorPagina,vm.user,vm.order,vm.sort);
        };

        
        function activate() {
           vm.findByFilter(vm.currentPage,vm.registrosPorPagina,vm.user,vm.order,vm.sort);
        }

        function visualizar (objeto) {
        objeto.isView = true;
        UserFactory.setUser(objeto);
            $state.go('user-manter');              
        }    

        function atualizar(objeto){
            objeto.isView = false;
            UserFactory.setUser(objeto);
            $state.go('user-manter');
        }

        function remover(codigo){
            //console.log('Voce excluiu o '+codigo)
            UserService.remove(codigo).then(function onSuccess(response) {
                console.log(response.data);
                activate();
            }).catch(function onError(response) {
                console.log(response);
            });
        }


        function findByFilter(skipIn, takeIn, pesquisa, order, sort) {
            UserService.findByFilter(skipIn, parseInt(takeIn),pesquisa, order, sort).then(function onSuccess(response) {
                if(response.headers('X-Total-Registros') !== null && !angular.isUndefined(response.headers('X-Total-Registros'))){
                    vm.totalUsers = parseInt(response.headers('X-Total-Registros'));
                }
                vm.itens = UserFactory.convertList(response.data);                
            }).catch(function onError(response) {
                console.log(response);
                UserService.checkStatus(response);
            });
        };



        function modalExcluir(userIn) {
            vm.modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'modules/user/templates/user.listar.modal.html',
                controller: ['$scope','user','remover', function($scope,user,remover ) {
                    var modal = this;
                    modal.titulo = 'Confirmação';
                    modal.remover =remover;
                    modal.user = user;

                    modal.confirm =  function confirm() {
                        modal.remover(modal.user.id);
                        vm.modalInstance.close();
                    };

                    modal.close = function close() {
                        vm.modalInstance.close();
                    };
                }],
                controllerAs: 'confirmCrt',
                keyboard: false,
                backdrop: 'static',
                size: 'md',
                resolve: {
                    remover: function(){
                        return vm.remover;
                    },
                    user: userIn

                }
            });
        };

        activate();

    }
})();
