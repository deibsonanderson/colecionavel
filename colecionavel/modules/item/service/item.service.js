(function() {
    'use strict';

    angular
    .module('colecionavel.module.item')
    .service('ItemService', ItemService);

    ItemService.$inject = ['$http', 'API_URL'];

    function ItemService($http, API_URL) {

        var _baseUrl = API_URL+'sistema/service/ItemService.php';
        
        // Methods
        this.create = create;
        this.update = update;
        this.remove = remove;
        this.findByFilter = findByFilter;
        this.findAll = findAll;
        this.findById = findById;
        this.findItemByVideoGame = findItemByVideoGame;
        this.findItemByProgressos = findItemByProgressos;
        this.findItemByCountGames = findItemByCountGames;
        this.findItemByAwards = findItemByAwards
		this.getTotalValor = getTotalValor;


        function findAll() {
            
            var timestamp = new Date().getTime();
            var _params = {               
                'timestamp':timestamp
            };
            return $http.get(_baseUrl ,{params:_params});
        };

        function findById(codigo) {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '2',
                'id': codigo,
                'timestamp':timestamp
            };
            return $http.get(_baseUrl , {params:_params});
        };


        function findByFilter(skipIn, takeIn, item, order, sort) {
            var skip = 0;
            var take = 5;
            if(!angular.isUndefined(skipIn) && !angular.isUndefined(takeIn)){
                skip = (skipIn - 1)*takeIn;
                take = takeIn;
            } 

            var timestamp = new Date().getTime();
            var _params = {
                'op': '1',
                'produtora' : item.produtora,
                'publicadora':item.publicadora,
                'status':item.status,
                'titulo':item.titulo,
                'skip': skip,
                'take': take,
                'procedencia': item.procedencia,
                'regiao': item.regiao,
                'plataforma[]': item.plataforma,
                'tipo[]': item.tipo,
                'ordem': item.ordem,
                'genero[]': item.genero,
				'complemento[]': item.complemento,
                'possui': item.possui,
                'situacao': item.situacao,
                //'order': order, deprecated
                'sort': (sort === false)?'desc':'asc',
                'timestamp':timestamp
            };            
            return $http.get(_baseUrl, { params: _params });
        };


        function create(item) {
            return $http.post(_baseUrl + '?op=3',item);
        };


        function update(item) {
            return $http.post(_baseUrl + '?op=4&id=' + item.id, item);
        };


        function remove(codigo) {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '5',
                'id': codigo,
                'timestamp':timestamp
            };
            return $http.get(_baseUrl , {params:_params});

        };


        function findItemByVideoGame() {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '6',               
                'timestamp':timestamp
            };
            return $http.get(_baseUrl , {params:_params});
        };


        function findItemByProgressos() {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '7',                
                'timestamp':timestamp
            };
            return $http.get(_baseUrl , {params:_params});
        }; 


        function findItemByCountGames() {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '8',               
                'timestamp':timestamp
            };
            return $http.get(_baseUrl , {params:_params});
        }; 

        function findItemByAwards(operacao) {
            var timestamp = new Date().getTime();
            var _params = {
                'op': operacao,                
                'timestamp':timestamp
            };
            return $http.get(_baseUrl , {params:_params});
        };                  

		function getTotalValor() {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '18',                
                'timestamp':timestamp
            };
            return $http.get(_baseUrl , {params:_params});
        }; 



    }
})();
