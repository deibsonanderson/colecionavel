(function() {
    'use strict';

    angular
    .module('colecionavel.module.item')
    .service('ItemService', ItemService);

    ItemService.$inject = ['$http','ItemFactory'];

    function ItemService($http,ItemFactory) {

        var _baseUrl = 'http://localhost:8091/colecionavel/sistema/service/ItemService.php';
        //var _baseUrl = 'http://dicaseprogramacao.com.br/colecionavel/sistema/service/ItemService.php';

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
        this.findItemByAwards = findItemByAwards;


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
                'status':ItemFactory.objetoDropdownToListString(item.status),
                'titulo':item.titulo,
                'skip': skip,
                'take': take,
                'procedencia': item.procedencia,
                'regiao': ItemFactory.objetoDropdownToListString(item.regiao),
                'plataforma': ItemFactory.objetoDropdownToListString(item.plataforma),
                'tipo': ItemFactory.objetoDropdownToListString(item.tipo),
                'ordem': item.ordem,
                'genero': ItemFactory.objetoDropdownToListString(item.genero),
                'possui': item.possui,
                'situacao': ItemFactory.objetoDropdownToListString(item.situacao),
                'order': order,
                'sort': (sort === false)?'desc':'asc',
                'timestamp':timestamp
            };            
            return $http.post(_baseUrl + '?op=1', _params);
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




    }
})();
