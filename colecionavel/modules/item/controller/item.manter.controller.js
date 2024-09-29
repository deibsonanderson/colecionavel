(function() {
    'use strict';

    angular
        .module('colecionavel.module.item')
        .controller('ItemManterController', ItemManterController);

    ItemManterController.$inject = ['$scope', 'ItemFactory', 'ItemService', '$state','UserService', 'GENERO', 'PLATAFORMA', 'REGIAO', 'SITUACAO', 'TIPO', 'ScrollToService'];


    function ItemManterController($scope, ItemFactory, ItemService, $state, UserService, GENERO, PLATAFORMA, REGIAO, SITUACAO, TIPO, ScrollToService) {
        //Atributos
        var vm = this;
        vm.titulo = undefined;
        vm.item = undefined;
        vm.alerts = [];
        var urlImgDefault = './assets/img/default.jpg';
        vm.isView = false;
        vm.log = undefined;
        vm.isDigital = false;
        vm.isPropriedade = false;
        vm.generos = GENERO.lista;
        vm.plataformas = PLATAFORMA.lista;
        vm.regioes = REGIAO.lista;
        vm.situacoes = SITUACAO.lista;
        vm.tipos = TIPO.lista;
		vm.isListar = undefined;

        //Instancia Metodos
        vm.cadastrar = cadastrar;
        vm.removerImagem = removerImagem;
        vm.findById = findById;
        vm.addAlert = addAlert;
        vm.closeAlert = closeAlert;
        vm.montarLog = montarLog;
        vm.createLog = createLog;
        vm.colorInput = '#f2dede';
        vm.addValue = addValue;
        vm.removeValue = removeValue;
        vm.checarDigital = checarDigital;
        vm.checarPropriedade = checarPropriedade;
		vm.cancelar = cancelar;
        //Metodos
        function addValue(objeto,atributo){
            var valor = 100;
            if(parseInt(objeto) < 100){
                valor = parseInt(objeto)+1;
            }
            switch(atributo){
                case 1:
                    vm.item.progressao = valor;
                break;
                case 2:
                    vm.item.tempo = valor;
                break;
                case 3:
                    vm.item.num_jogadas = valor;
                break;
            }
        }

        function removeValue(objeto,atributo){
            var valor = 0;
            if(parseInt(objeto) > 0){
                valor = parseInt(objeto)-1;
            }
            switch(atributo){
                case 1:
                    vm.item.progressao = valor;
                break;
                case 2:
                    vm.item.tempo = valor;
                break;
                case 3:
                    vm.item.num_jogadas = valor;
                break;
            }            
        }


        function removerImagem(form,posicao){
            switch(posicao) {
                case 99:
                     vm.item.imagem = urlImgDefault;
                    break;
                case 1:
                     vm.item.screenshot1 = urlImgDefault;
                    break;   
                case 2:
                     vm.item.screenshot2 = urlImgDefault;
                    break;                                    
                case 3:
                     vm.item.screenshot3 = urlImgDefault;
                    break;   
                case 4:
                     vm.item.screenshot4 = urlImgDefault;
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
			if(!angular.isUndefined($state) && 
                !angular.isUndefined($state.$current) && 
                !angular.isUndefined($state.$current.data) && 
                $state.$current.data.firstAccess === true){
                ItemFactory.limparItem();
            }
            var objeto = ItemFactory.getItem();
            verificarTitulo(objeto);
            if (angular.isUndefined(objeto)) {
                vm.item = {
                    avaliacao: '1',
                    imagem: urlImgDefault,
                    screenshot1:urlImgDefault,
                    screenshot2:urlImgDefault,
                    screenshot3:urlImgDefault,
                    screenshot4:urlImgDefault,
                    progressao:0,
					quantidade:1,
                    num_jogadas:0,
                    tempo:0,
                    possui:'1',
					situacao: 'Comprado',
					regiao: 'BRA',
					procedencia: 'Original'
					
                };
                removeloader();
            } else {
                vm.isView = objeto.isView;
                vm.findById(objeto.id);
				vm.isListar = objeto.isListar;                
            }
            ItemFactory.limparItem();
            ScrollToService.scrollToTop( 0, 600);
        }

        function verificarTitulo(objeto){
            if (angular.isUndefined(objeto)) {
                vm.titulo = "Cadastrado de um novo Item";
            }else if(objeto.isView){
                vm.titulo = "Visualização do Item";
            }else{
                vm.titulo = "Edição do Item";
            }
        }

        
        function montarLog(status){
            if(!angular.isUndefined(vm.item.id)){
                var log = {
                        id_user: (vm.item.id_user === undefined?2:vm.item.id_user),
                        id_item:  vm.item.id
                    }
                switch(status){
                    case 1:
                        log.descricao = 'O status encontra-se do XXX como '+ItemFactory.checarStatus(vm.item.status);
                        log.icone = 'fa-gamepad';
                    break;                
                    case 2:
                        log.descricao = 'O progresso foi atualizado para '+vm.item.progressao+'% do XXX';
                        log.icone = 'fa-check';
                    break;
                    case 3:
                        log.descricao = 'Foi adicionado uma nova imagem ao XXX ';
                        log.icone = 'fa-cloud-upload';
                    break;
                    case 4:
                        log.descricao = 'O Item XXX foi removido';
                        log.icone = 'fa-times';
                    break;
                    case 5:
                        log.descricao = 'O Item XXX teve seus dados atualizados';
                        log.icone = 'fa-refresh';
                    break;
                    
                }              
                vm.log = log;
            }
        }

        function createLog(item){
            if(angular.isUndefined(vm.log)){
                vm.montarLog(5);
            }
            var texto = vm.log.descricao.replace("XXX", item.titulo);
            vm.log.descricao = texto;
            UserService.createLog(vm.log).then(function onSuccess(response) {                        
                console.log('Log Cadastrado com sucesso!');
            }).catch(function onError(response) {
                vm.addAlert('alert-danger', response.data.message);
                UserService.checkStatus(response);
            });  
        }

        function cadastrar(form) {
            vm.alerts = [];

            if (form.$valid) {
                addloader();
                var itemConverted = ItemFactory.convertBack(vm.item);
                if (angular.isUndefined(itemConverted.id)) {
                    
                    ItemService.create(itemConverted).then(function onSuccess(response) {                        
                        activate();
                        vm.addAlert('alert-success', response.data.message);
                        removeloader();
                    }).catch(function onError(response) {
                        vm.addAlert('alert-danger', response.data.message);
                        UserService.checkStatus(response);
                        removeloader();
                    });                    
                } else {                    
                    ItemService.update(itemConverted).then(function onSuccess(response) {
                        vm.addAlert('alert-success', response.data.message);
                        vm.createLog(itemConverted);
                        removeloader();
						var objUpdate = {
							       classe: 'alert-success',
								   message: response.data.message
								   };
                        //$state.go('item-listar',{obj:objUpdate});
						cancelar ({obj:objUpdate});
                    }).catch(function onError(response) {
                        vm.addAlert('alert-danger', response.data.message);
                        UserService.checkStatus(response);
                        removeloader();
                    });                    
                }
            }else{
                vm.addAlert('alert-danger', 'Preencha os campos obrigatórios!');
            }
            ScrollToService.scrollToTop( 0, 600);
        }

        function findById(codigo) {
            addloader();
            ItemService.findById(codigo).then(function onSuccess(response) {
                vm.item = ItemFactory.convert(response.data);
                removeloader();                
            }).catch(function onError(response) {
                vm.addAlert('alert-danger', response.data.message);
                UserService.checkStatus(response);
                removeloader();
            });
        };

        function checarDigital(){
            if(!angular.isUndefined(vm.item.tipo) && vm.item.tipo === 'Jogo Digital'){
                vm.isDigital = true;
                vm.item.local_primeiro = undefined; 
                vm.item.local_segundo = undefined; 
                vm.item.local_terceiro = undefined;
                vm.item.flag_cartucho_disco = undefined;
                vm.item.flag_replica = undefined;
                vm.item.flag_protetor = undefined;
                vm.item.flag_cd_dvd = undefined;
                vm.item.flag_caixa = undefined;
                vm.item.flag_manual = undefined; 
                vm.item.flag_berco = undefined;
                vm.item.flag_panfleto = undefined; 
                vm.item.flag_poster = undefined;
                vm.item.flag_nota_fiscal = undefined; 
                vm.item.flag_lacrado = undefined; 
                vm.item.flag_luva = undefined;
            }else{
                vm.isDigital = false;
            }
        }

        function checarPropriedade(){
            if(!angular.isUndefined(vm.item.possui) && vm.item.possui == "0"){
                vm.isPropriedade = true;
                vm.item.local_primeiro = undefined; 
                vm.item.local_segundo = undefined; 
                vm.item.local_terceiro = undefined;
                vm.item.flag_cartucho_disco = undefined;
                vm.item.flag_replica = undefined;
                vm.item.flag_protetor = undefined;
                vm.item.flag_cd_dvd = undefined;
                vm.item.flag_caixa = undefined;
                vm.item.flag_manual = undefined; 
                vm.item.flag_berco = undefined;
                vm.item.flag_panfleto = undefined; 
                vm.item.flag_poster = undefined;
                vm.item.flag_nota_fiscal = undefined; 
                vm.item.flag_lacrado = undefined; 
                vm.item.flag_luva = undefined;
                vm.item.situacao = undefined;
                vm.item.procedencia = undefined;
                vm.item.valor_pago = undefined;
            }else{
                vm.isPropriedade = false;             
            }
        }

        $scope.uploadFile = function (element,posicao) {
            var file = element.files;
            vm.item.imagemName = file[0].name;
            vm.item.imagemFile = file[0];
            var reader = new FileReader();
            reader.onload = function (loadEvent) {
                $scope.$apply(function () {
                    switch(posicao) {
                        case 99:
                            vm.item.imagem = loadEvent.target.result;
                            break;
                        case 1:
                             vm.item.screenshot1 = loadEvent.target.result;
                            break;   
                        case 2:
                             vm.item.screenshot2 = loadEvent.target.result;
                            break;                                    
                        case 3:
                             vm.item.screenshot3 = loadEvent.target.result;
                            break;   
                        case 4:
                             vm.item.screenshot4 = loadEvent.target.result;
                            break;                 
                    }                     
                    vm.montarLog(3);
                });
            };
            reader.readAsDataURL(file[0]);
            $scope.$apply();            
        };

        function cancelar (objeto) {
			if(vm.isListar === false){
				$state.go('item-galeria',objeto);
			}else if(vm.isListar === true){
				$state.go('item-listar',objeto);
			}else{
				$state.go('home',objeto);
			}
        }  

        activate();

    }
})();
