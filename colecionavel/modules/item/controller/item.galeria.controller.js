(function () {
    'use strict';

    angular
    .module('colecionavel.module.item')
    .controller('ItemGaleriaController', ItemGaleriaController);

    ItemGaleriaController.$inject = ['$scope','ItemService','ItemFactory','$state','UserService', 'GENERO', 'PLATAFORMA', 'REGIAO', 'SITUACAO', 'TIPO','ScrollToService', 'ORDEM'];


    function ItemGaleriaController($scope, ItemService,ItemFactory,$state,UserService, GENERO, PLATAFORMA, REGIAO, SITUACAO, TIPO, ScrollToService, ORDEM) {
        //Atributos
        var vm = this;
        vm.titulo = "Listagem do Proprietário";  
        vm.itens = [];
        vm.maxSize = 3;
        vm.totalItems = 0;
        vm.currentPage = 1;
        vm.item = {};
        vm.item.registrosPorPagina = "12";
        vm.item.acao = "E";
        vm.item.exibicao = "S";
		vm.item.modo = "1";
        vm.selectTop = ["6","12","18","24"];
        vm.order = 'deprecated';
        vm.sort = true;
        vm.itensMobile = [];
        vm.itens = [];
        vm.generos = [];
        vm.plataformas = [];
        vm.regioes = [];
        vm.situacoes = [];
        vm.tipos = [];        
		vm.alerts = [];	

        //Instancia Metodos
        vm.findByFilter = findByFilter;
        vm.atualizar = atualizar;
        vm.registrosPorPaginaAlterados = registrosPorPaginaAlterados;
        vm.pesquisar = pesquisar;
        vm.sorter = sorter;
        vm.sorterIconCheck = sorterIconCheck;
        vm.formarGaleria = formarGaleria;
        vm.limparCampos = limparCampos;
        vm.montarFiltro = montarFiltro;
        vm.topoPagina = topoPagina;
		vm.addAlert = addAlert;
        vm.closeAlert = closeAlert;

        function limparCampos(){
            vm.item = {
                registrosPorPagina:"24",
                exibicao:"S",
                acao:"E",
				modo: "1"
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
                    vm.item.registrosPorPagina = "12";
                 break;
                 case '10':
                    vm.item.registrosPorPagina = "18";
                 break;
                 case '30':
                    vm.item.registrosPorPagina = "24";
                 break;
                 case '50':
                    vm.item.registrosPorPagina = "48";
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
			  			
           vm.findByFilter(vm.currentPage,vm.item.registrosPorPagina,vm.item,vm.order,vm.sort);
           vm.montarFiltro();
        }

        function atualizar (objeto) {
        objeto.isView = false;
		objeto.isListar = false;
        ItemFactory.setItem(objeto);
            $state.go('item-manter');              
        }    


        function findByFilter(skipIn, takeIn, item, order, sort) {
            addloader();
            ItemService.findByFilter(skipIn, parseInt(takeIn),item, order, sort).then(function onSuccess(response) {
                if(response.headers('X-Total-Registros') !== null && !angular.isUndefined(response.headers('X-Total-Registros'))){
                    vm.totalItems = parseInt(response.headers('X-Total-Registros'));
                }
                vm.itens = formarGaleria(ItemFactory.convertList(response.data),6);                
                vm.itensMobile = formarGaleria(ItemFactory.convertList(response.data),3); 
                removeloader(); 
                ScrollToService.scrollToId('topo');               
            }).catch(function onError(response) {
                console.log(response);
                UserService.checkStatus(response);
                removeloader();
                ScrollToService.scrollToTop( 0, 600);
            });
        };

        function topoPagina(){
            ScrollToService.scrollToTop( 0, 600);
        }        

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
                }                
            }).catch(function onError(response) {
                UserService.checkStatus(response);            
            });
        };   


        function checarImagem(imagem,titulo,colunas,item){
            if(!angular.isUndefined(imagem) && imagem !== '' && imagem !== null && imagem !== './sistema/uploads/default.jpg' && imagem !== './assets/img/default.jpg' ){
                var objeto = {
                    'titulo': titulo,
                    'imagem': imagem,
					'item': item
                }
                colunas.push(objeto);
            }
        }           

        function formarGaleria(itens,col){
            var linhas = [];
            if(!angular.isUndefined(itens) && itens !== null && itens.length > 0){

                var list = [];
                for (var x = 0; x < itens.length; x++) {
                    if(vm.item.modo == '1' || vm.item.modo == '' || vm.item.modo == undefined){    
                        checarImagem(itens[x].imagem,itens[x].titulo,list,itens[x]);                    
                    }
                    if(vm.item.modo == '2' || vm.item.modo == '' || vm.item.modo == undefined){
                        checarImagem(itens[x].screenshot1,itens[x].titulo,list,itens[x]);                    
                        checarImagem(itens[x].screenshot2,itens[x].titulo,list,itens[x]);                    
                        checarImagem(itens[x].screenshot3,itens[x].titulo,list,itens[x]);                    
                        checarImagem(itens[x].screenshot4,itens[x].titulo,list,itens[x]);                    
                    }              
                };
                
                var colunas = [];
                for(var i = 0; i < list.length; i++){
                    colunas.push(list[i]);
                    if(colunas.length === col){
                        linhas.push(angular.copy(colunas));
                        colunas = [];
                    }                    
                }
                if(colunas.length > 0){
                    linhas.push(angular.copy(colunas));
                }
                
            }
            return linhas;
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


        activate();

    }
})();
