(function () {
    'use strict';

    angular
    .module('colecionavel.module.item')
    .controller('ItemListarController', ItemListarController);

    ItemListarController.$inject = ['$scope','ItemService','ItemFactory','$state','UserService','$uibModal', 'GENERO', 'PLATAFORMA', 'REGIAO', 'SITUACAO', 'TIPO', 'ScrollToService','ORDEM'];


    function ItemListarController($scope, ItemService,ItemFactory,$state,UserService,$uibModal, GENERO, PLATAFORMA, REGIAO, SITUACAO, TIPO, ScrollToService, ORDEM) {
        //Atributos
        var vm = this;
        vm.titulo = "Listagem do Proprietário";  
        vm.itens = [];
        vm.item = {};
        vm.maxSize = 3;
        vm.totalItems = 0;
        vm.currentPage = 1;
        vm.item.registrosPorPagina = "10";
        vm.item.exibicao = "S";
        vm.item.acao = "E";
		vm.item.modo = "1";
		vm.item.plataforma = [];
		vm.item.tipo = [];
		vm.item.genero = [];
        vm.selectTop = ["5","10","30","50"];
        vm.order = 'deprecated';
        vm.sort = true;
        vm.animationsEnabled = true;
        vm.generos = [];
        vm.plataformas = [];
        vm.regioes = [];
        vm.situacoes = [];
        vm.tipos = [];     
		vm.alerts = [];
        vm.complementos = [['Cartucho/Fita',['flag_cartucho_disco','']],
						['NF',['flag_nota_fiscal', '']],
						['Panfleto',['flag_panfleto', '']],
						['CD/DVD/GD/BD',['flag_cd_dvd', '']],
						['Caixa',['flag_caixa', '']],
						['Manual',['flag_manual', '']],
						['Berço',['flag_berco', '']],
						['Protetores/Cases',['flag_protetor', '']],
						['Poster',['flag_poster', '']],
						['Luva',['flag_luva', '']],
						['Lacrado',['flag_lacrado', '']],
						['Replica/ActionFigure',['flag_replica', '']]];	
		
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
        vm.montarFiltro = montarFiltro; 
        vm.topoPagina = topoPagina;
		vm.addAlert = addAlert;
        vm.closeAlert = closeAlert;
        vm.traducaoFlag = traducaoFlag;
        vm.checarStatus = ItemFactory.checarStatus;
        vm.campoVazio = campoVazio;
        vm.checkLength = checkLength;
		
        function limparCampos(){
            vm.item = {
                registrosPorPagina : "10",
                exibicao:"S",
                acao:"E",
				modo: "1",
				plataforma: [],
				tipo: [],
				genero: []
				
            };
            ItemFactory.setPesquisa(undefined);
            activate();
        }
        

        //Metodos
        function sorter(ordem){
            vm.sort = !vm.sort;
            vm.order = ordem;
            vm.findByFilter(vm.currentPage,vm.item.registrosPorPagina,vm.item,vm.order,vm.sort);
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
            ItemFactory.setPesquisa(vm.item);
            vm.findByFilter(vm.currentPage,vm.item.registrosPorPagina,vm.item,vm.order,vm.sort);
        }
        
        function registrosPorPaginaAlterados(){
            vm.findByFilter(vm.currentPage,vm.item.registrosPorPagina,vm.item,vm.order,vm.sort);
        }

        vm.setPage = function (pageNo) {
            vm.currentPage = pageNo;
        };

        vm.pageChanged = function() {
            vm.findByFilter(vm.currentPage,vm.item.registrosPorPagina,vm.item,vm.order,vm.sort);
        };

        
        function activate() {
			
			if(!angular.isUndefined($state.params) && !angular.isUndefined($state.params.obj)){
				vm.addAlert($state.params.obj.classe, $state.params.obj.message);
			}
			
            var objeto = ItemFactory.getPesquisa();
            if(angular.isUndefined(objeto) && angular.isUndefined(vm.item.ordem)){
				  vm.item.ordem = ORDEM.lista[Math.floor((Math.random() * 34))];
				  ItemFactory.setPesquisa(vm.item);
			} else if (!angular.isUndefined(objeto)) {
              vm.item = objeto;
              switch(vm.item.registrosPorPagina){
                 case '5':
                    vm.item.registrosPorPagina = "5";
                 break;
                 case '10':
                    vm.item.registrosPorPagina = "10";
                 break;
                 case '30':
                    vm.item.registrosPorPagina = "30";
                 break;
                 case '50':
                    vm.item.registrosPorPagina = "50";
                 break;
                 case '9999':
                    vm.item.registrosPorPagina = "9999";
                 break;
              }
			  
			  if(angular.isUndefined(vm.item.ordem)){
				  vm.item.ordem = ORDEM.lista[Math.floor((Math.random() * 34))];
				  ItemFactory.setPesquisa(vm.item);
			  }
			  
            }
            vm.item.complementos = vm.complementos; 			
            vm.findByFilter(vm.currentPage,vm.item.registrosPorPagina,vm.item,vm.order,vm.sort);
            vm.montarFiltro();
        }

        function visualizar (objeto) {
        objeto.isView = true;
		objeto.isListar = true;
        ItemFactory.setItem(objeto);
            $state.go('item-manter');              
        }    

        function atualizar(objeto){
            objeto.isView = false;
			objeto.isListar = true;
            ItemFactory.setItem(objeto);
            $state.go('item-manter');
        }

        function remover(codigo){
            addloader();
            ItemService.remove(codigo).then(function onSuccess(response) {
                console.log(response.data);
                removeloader();
                activate();
				vm.addAlert('alert-success', response.data.message);
            }).catch(function onError(response) {
				vm.addAlert('alert-danger', response.data.message);
                removeloader();
                console.log(response);
            });
        }


        function findByFilter(skipIn, takeIn, pesquisa, order, sort) {
            addloader();
            ItemService.findByFilter(skipIn, parseInt(takeIn),pesquisa, order, sort).then(function onSuccess(response) {
                if(response.headers('X-Total-Registros') !== null && !angular.isUndefined(response.headers('X-Total-Registros'))){
                    vm.totalItems = parseInt(response.headers('X-Total-Registros'));
                }
                vm.itens = ItemFactory.convertList(response.data);
                removeloader();     
                ScrollToService.scrollToId('topo');           
            }).catch(function onError(response) {
                console.log(response);
                UserService.checkStatus(response);
                removeloader();
                ScrollToService.scrollToTop( 0, 600);
            });
        };


        function ordenar(dados) {
            dados.sort(function (a, b) {
                if(a > b){
                    return 1;
                }else{
                    return -1;
                }
            });
            return dados;
        }


        function montarFiltro() {
            ItemService.findAll().then(function onSuccess(response) {
                if(response !== null && !angular.isUndefined(response) && !angular.isUndefined(response.data)){
                    for (var i = 0; i < response.data.length; i++) {
                         if(GENERO.lista.includes(response.data[i].genero) === true && 
                            vm.generos.includes(response.data[i].genero) === false){
                            vm.generos.push(response.data[i].genero);
                         }
                         if(PLATAFORMA.lista.includes(response.data[i].plataforma) === true && 
                            vm.plataformas.includes(response.data[i].plataforma) === false){
                            vm.plataformas.push(response.data[i].plataforma);
                         }
                         if(REGIAO.lista.includes(response.data[i].regiao) === true && 
                            vm.regioes.includes(response.data[i].regiao) === false){
                            vm.regioes.push(response.data[i].regiao);
                         }
                         if(SITUACAO.lista.includes(response.data[i].situacao) === true && 
                            vm.situacoes.includes(response.data[i].situacao) === false){
                            vm.situacoes.push(response.data[i].situacao);
                         }
                         if(TIPO.lista.includes(response.data[i].tipo) === true && 
                            vm.tipos.includes(response.data[i].tipo) === false){
                            vm.tipos.push(response.data[i].tipo);
                         }
                    };
                    vm.plataformas = ordenar(vm.plataformas); 
                    vm.generos = ordenar(vm.generos); 
                    vm.regioes = ordenar(vm.regioes); 
                    vm.tipos = ordenar(vm.tipos); 
                    vm.situacoes = ordenar(vm.situacoes); 
					vm.complementos = ordenar(vm.complementos); 
                }                
            }).catch(function onError(response) {
                UserService.checkStatus(response);            
            });
        };        

        function topoPagina(){
            ScrollToService.scrollToTop( 0, 600);
        }


        function modalExcluir(itemIn) {
            vm.modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'modules/item/templates/item.listar.modal.html',
                controller: ['$scope','item','remover', function($scope,item,remover ) {
                    var modal = this;
                    modal.titulo = 'Confirmação';
                    modal.remover =remover;
                    modal.item = item;

                    modal.confirm =  function confirm() {
                        modal.remover(modal.item.id);
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
                    item: itemIn

                }
            });
        };
		
		function addAlert(type, message) {
            vm.alerts.push({
                "type": type,
                "msg": message
            });
        }

        function traducaoFlag(value){
            return (value == true)?'Sim':'Não';
        }

        function campoVazio(value){
            return (!angular.isUndefined(value) && value != '')?value:'-';
        }

        function closeAlert(index) {
            vm.alerts.splice(index, 1);
        }
        
        function checkLength(len,value){
            if(!angular.isUndefined(value)){
                var fieldLength = value.length;
                if(fieldLength <= len){
                    return value;
                } else {
                    var str = value;
                    str = str.substring(0, len);
                    return str+"...";
                }
            }else{
                return '-';
            }
        }

        activate();

    }
})();
