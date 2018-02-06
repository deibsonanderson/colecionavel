(function () {
    'use strict';

    angular
            .module('colecionavel.module.home')
            .controller('HomeController', HomeController);

    HomeController.$inject = ['$scope','ItemService','$rootScope','ItemFactory','UserService','$state','UserFactory'];


    function HomeController($scope, ItemService, $rootScope,ItemFactory,UserService, $state,UserFactory) {
        //Atributos
        var vm = this;
        vm.titulo = "home";
        vm.usuario =  {};
        vm.videogames = [];
        vm.progressos = [];
        vm.countGame = {};
        vm.logs = [];
        vm.awardsAvaliado = {};
        vm.awardsMaiorTempo = {};
        vm.awardsMaisJogado = {};
        vm.awardsMaisRecente = {};
        vm.awardsMaisCaro = {};
        vm.awardsPortatilAvaliado = {};
        vm.awardsVideoGameAvaliado = {};
        vm.awardsCompletado = {};
        vm.awardsAdaptadorAvaliado = {};
        vm.percent = [];        

        //Instancia Metodos
        vm.findItemByVideoGame = findItemByVideoGame;
        vm.findItemByProgressos = findItemByProgressos;
        vm.findItemByCountGames = findItemByCountGames;  
        vm.findUserById = findUserById; 
        vm.findAllLog = findAllLog;   
        vm.visualizar = visualizar;
        vm.visualizarLog = visualizarLog;
        vm.findItemByAvaliado = findItemByAvaliado;
        vm.findItemByMaiorTempo = findItemByMaiorTempo;
        vm.findItemByMaisJogadas = findItemByMaisJogadas;
        vm.findItemByMaisRecente = findItemByMaisRecente;
        vm.findItemByMaisCaro = findItemByMaisCaro;            
        vm.findPortatilByAvaliado = findPortatilByAvaliado;
        vm.findVideoGameByAvaliado = findVideoGameByAvaliado;
        vm.findAdaptadorByAvaliado = findAdaptadorByAvaliado;
        vm.findItemByCompletado =  findItemByCompletado;
        vm.checkStatus = checkStatus;
        vm.montarGraficoPie = montarGraficoPie;
        vm.tratarTextoAwards = tratarTextoAwards;

        //Metodos
        function activate() {
            addloader();
            if(!angular.isUndefined($state) && 
                !angular.isUndefined($state.$current) && 
                !angular.isUndefined($state.$current.data) && 
                $state.$current.data.firstAccess === true){
                ItemFactory.setPesquisa(undefined);
            }
            vm.findItemByVideoGame();
            vm.findItemByProgressos();
            vm.findItemByCountGames();
            vm.findUserById();
            vm.findAllLog();
            vm.findItemByAvaliado();
            vm.findItemByMaiorTempo();
            vm.findItemByMaisJogadas();
            vm.findItemByMaisRecente();
            vm.findItemByMaisCaro();            
            vm.findPortatilByAvaliado();
            vm.findVideoGameByAvaliado();
            vm.findAdaptadorByAvaliado();
            vm.findItemByCompletado();
            removeloader();            
        }

        function checkStatus(response){
            UserService.checkStatus(response);
        }

        function visualizar (objeto) {
            objeto.isView = true;
            ItemFactory.setItem(objeto);
            $state.go('item-manter');              
        }   

        function visualizarLog (id) {
            var objeto = {};
            objeto.isView = true;
            objeto.id = id;
            ItemFactory.setItem(objeto);
            $state.go('item-manter');              
        }
        

        function findItemByVideoGame() {
            ItemService.findItemByVideoGame().then(function onSuccess(response) {
                vm.videogames = ItemFactory.convertList(response.data);                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };

        function findItemByProgressos() {
            ItemService.findItemByProgressos().then(function onSuccess(response) {
                vm.progressos = ItemFactory.convertList(response.data);                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };       

        function findItemByCountGames() {
            ItemService.findItemByCountGames().then(function onSuccess(response) {
                vm.countGame = response.data;
                vm.montarGraficoPie(vm.countGame);                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        }; 


        function findAllLog() {
            UserService.findAllLog().then(function onSuccess(response) {
                vm.logs = response.data;
                if(!angular.isUndefined(vm.logs) && vm.logs != null && vm.logs.length > 0){
                    for(var i=0; i < vm.logs.length;i++){
                        var texto = vm.logs[i].descricao.replace("XXX", vm.logs[i].titulo);
                        vm.logs[i].descricao = texto;
                    }
                }
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };   

        function findUserById() {
            UserService.findUserById().then(function onSuccess(response) {
                vm.usuario = UserFactory.convert(response.data);
                $rootScope.usuario = vm.usuario;                             
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };


        function findItemByMaiorTempo() {
            ItemService.findItemByAwards(9).then(function onSuccess(response) {
                vm.awardsMaiorTempo = response.data;                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };                

        function findItemByMaisJogadas() {
            ItemService.findItemByAwards(10).then(function onSuccess(response) {
                vm.awardsMaisJogado= response.data;                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };                


        function findItemByMaisRecente() {
            ItemService.findItemByAwards(11).then(function onSuccess(response) {
                vm.awardsMaisRecente = response.data;                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };                


        function findItemByMaisCaro() {
            ItemService.findItemByAwards(12).then(function onSuccess(response) {
                vm.awardsMaisCaro = response.data;                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };  

        function findItemByAvaliado() {
            ItemService.findItemByAwards(13).then(function onSuccess(response) {
                vm.awardsAvaliado = response.data;                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };                

        function findPortatilByAvaliado() {
            ItemService.findItemByAwards(14).then(function onSuccess(response) {
                vm.awardsPortatilAvaliado = response.data;                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };                


        function findVideoGameByAvaliado() {
            ItemService.findItemByAwards(15).then(function onSuccess(response) {
                vm.awardsVideoGameAvaliado = response.data;                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };   


        function findAdaptadorByAvaliado() {
            ItemService.findItemByAwards(17).then(function onSuccess(response) {
                vm.awardsAdaptadorAvaliado = response.data;                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };                        


        function findItemByCompletado() {
            ItemService.findItemByAwards(16).then(function onSuccess(response) {
                vm.awardsCompletado = response.data;                
            }).catch(function onError(response) {
                console.log(response);
                checkStatus(response);
            });
        };


        function montarGraficoPie(countGame){
            var data = {
              series: [parseInt(countGame.concluido), 
                       parseInt(countGame.pendente), 
                       parseInt(countGame.andamento)]
            };            
            
            var sum = function(a, b) { return a + b };
            new Chartist.Pie('#pie-simple-chart', data, {
              labelInterpolationFnc: function(value) {
                var retorno = Math.round(value / data.series.reduce(sum) * 100) + '%'; 
                vm.percent.push(retorno);
                return retorno;
              }
            });  

        }   

        function tratarTextoAwards(texto){
            if(!angular.isUndefined(texto) && texto.length >= 35){
                return texto.substring(0, 35)+'...';
            }else if(!angular.isUndefined(texto) && texto.length < 35){
                return texto;
            }else{
                return "-";
            }
        }

        activate();

    }
})();
