(function() {
    'use strict';

    angular
    .module('colecionavel.module.user')
    .service('UserService', UserService);

    UserService.$inject = ['$http'];

    function UserService($http) {

        var _baseUrl = 'http://localhost:8091/colecionavel/sistema/service/UserService.php';
        //var _baseUrl = 'http://dicaseprogramacao.com.br/colecionavel/sistema/service/UserService.php';        

        // Methods
        this.create = create;
        this.createLog = createLog;
        this.update = update;
        this.remove = remove;
        this.findAllLog = findAllLog;
        this.logout = logout;
        this.findUserById = findUserById;
        this.checkStatus = checkStatus;
        this.updateSenha = updateSenha;


        function findAllLog() {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '2',               
                'timestamp':timestamp
            };
            return $http.get(_baseUrl ,{params:_params});
        };

        function logout() {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '3',
                'timestamp':timestamp
            };
            return $http.get(_baseUrl ,{params:_params});
        };        

        function findUserById() {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '5',               
                'timestamp':timestamp
            };
            return $http.get(_baseUrl , {params:_params});
        };


        function create(item) {
            return $http.post(_baseUrl + '?op=3',item);
        };


        function update(item) {
            return $http.post(_baseUrl + '?op=6&id='+item.id, item);
        };

        function updateSenha(item) {
            return $http.post(_baseUrl + '?op=7&id='+item.id, item);
        };


        function remove(codigo) {
            var timestamp = new Date().getTime();
            var _params = {
                'op': '99',
                'id': codigo,
                'timestamp':timestamp
            };
            return $http.get(_baseUrl , {params:_params});
        };

        function createLog(log) {
            return $http.post(_baseUrl + '?op=4',log);
        };


        function checkStatus(response){
            if(response.status === 401){
                //window.location.href = './';
                window.location.reload();
            }
        }



    }
})();
