(function () {
    'use strict';
    angular
    .module('colecionavel.module.user')
    .factory('UserFactory', UserFactory);
    
    UserFactory.$inject = [];
    var user = {};


    function UserFactory(){

        var exports = {
            User: User,
            convert: convert,
            convertList: convertList,
            convertBack:convertBack,
            getUser:getUser,
            setUser:setUser,
            limparUser:limparUser,
            checarImagem:checarImagem,
            convertDate:convertDate,
            covertGetTime:covertGetTime,
            convertBackSenha:convertBackSenha
        };

        return exports;

        function convertDate(data) {
            if(!angular.isUndefined(data) && data !== null && data !== ''){
                var data = new Date(data);
                var dataTexto = ("0" + data.getUTCDate()).slice(-2).toString() + '/' +
                ("0" + (data.getUTCMonth() + 1)).slice(-2).toString() + '/' + 
                data.getUTCFullYear().toString(); 
                return dataTexto;
            }else{
                return undefined;
            }
        }     


        function covertGetTime(dataIn){
            if(!angular.isUndefined(dataIn) && dataIn !== null && dataIn !== ''){
                var data = dataIn.replace('/','').replace('/','');
                var dia = parseInt(data.substr(0,2));
                var mes = parseInt(data.substr(2,2));
                var ano = parseInt(data.substr(4,4));
                return new Date(ano,(mes-1),dia).getTime(); 
            }else{
                return undefined;
            }
        }          



        function checarImagem(imagem){
            if(!angular.isUndefined(imagem) && imagem !== null && imagem !== ''){
                return './sistema/uploads/'+imagem;                
            }else{
                return './assets/img/user-medium.png';
            }
        }

        function checarImagemFundo(imagem){
            if(!angular.isUndefined(imagem) && imagem !== null && imagem !== ''){
                return './sistema/uploads/'+imagem;                
            }else{
                return './assets/img/profile-bg.png';
            }
        }     


        function User(id,nome,email,senha,data_nascimento,telefone,site,descricao,foto,fundo) {
            this.id = id; 
            this.nome = nome;
            this.email = email;
            this.senha = senha;
            this.data_nascimento = convertDate(data_nascimento);
            this.telefone = telefone;
            this.site = site;
            this.descricao = descricao;
            this.foto = checarImagem(foto);
            this.fundo = checarImagemFundo(fundo);
        }


        function convert(user) {
            return new User(
                user.id,                 
                user.nome,
                user.email,
                user.senha,
                user.data_nascimento,
                user.telefone,
                user.site,
                user.descricao,
                user.foto,
                user.fundo);
        }


        function convertList(users) {
            var converted = [];

            for (var i = 0; i < users.length; ++i) {
                converted.push(this.convert(users[i]));
            }

            return converted;
        }

        function convertBack(user) {
            var converted = {};
                converted.id = user.id;
                converted.nome = user.nome;
                converted.email = user.email;                
                converted.data_nascimento = covertGetTime(user.data_nascimento);
                converted.telefone = user.telefone;
                converted.site = user.site;
                converted.descricao = user.descricao;
                converted.foto = user.foto;
                converted.fundo = user.fundo;
            return converted;
        }


        function convertBackSenha(user) {
            var converted = {};
                converted.id = user.id;
                //converted.senha_antiga = user.senha_antiga;
                converted.senha_nova = user.senha_nova;
                converted.senha_confirm = user.senha_confirm;
            return converted;
        }


        function getUser(){
            return this.user;
        }

        function setUser(user){
            this.user = user;
        }

        function limparUser(){
            this.user = undefined;
        }


    }
})();
