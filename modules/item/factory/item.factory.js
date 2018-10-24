(function () {
    'use strict';
    angular
    .module('colecionavel.module.item')
    .factory('ItemFactory', ItemFactory);
    
    ItemFactory.$inject = [];
    var item = {};
    var pesquisa = {};


    function ItemFactory(){

        var exports = {
            Item: Item,
            convert: convert,
            convertList: convertList,
            convertBack:convertBack,
            getItem:getItem,
            setItem:setItem,
            getPesquisa:getPesquisa,
            setPesquisa:setPesquisa,
            limparItem:limparItem,
            checarImagem:checarImagem,
            checarStatus:checarStatus,
            checarValorNumerico:checarValorNumerico 
        };

        return exports;

        function checarFlagFront(valor){
            return (valor === '1'?true:false);
        } 

        function checarStatus(status){
            var statusExtenso = '';
            switch(status){
                case 'P':
                statusExtenso = 'Pendente';
                break;
                case 'C':
                statusExtenso = 'Concluído';
                break;
                case 'E':
                statusExtenso = 'Em Progresso';
                break;
            }
            return statusExtenso;
        } 

        function checarImagem(imagem){
            if(!angular.isUndefined(imagem) && imagem !== null && imagem !== ''){
                return './sistema/uploads/'+imagem;                
            }else{
                return './assets/img/default.jpg';
            }
        }     

        function checarValorNumerico(valor){
            if(!angular.isUndefined(valor) && valor !== null && valor !== ''){
                return parseInt(valor);
            }else{
                return 0;
            }
        }


        function Item(id,data_cadastro,titulo,descricao,imagem,procedencia,regiao,valor_pago,valor_atual,plataforma,tipo,codigo,complemento,avaliacao,local_primeiro,local_segundo,local_terceiro,flag_cartucho_disco,flag_replica,flag_protetor,flag_cd_dvd,flag_caixa,flag_manual,flag_berco,flag_panfleto,flag_poster,flag_nota_fiscal,flag_lacrado,flag_luva,id_user,status,progressao,situacao,possui,genero,produtora,publicadora,screenshot1,screenshot2,screenshot3,screenshot4,tempo,num_jogadas) {
            this.id = id; 
            this.data_cadastro = data_cadastro; 
            this.titulo = titulo; 
            this.descricao = descricao; 
            this.imagem = checarImagem(imagem); 
            this.procedencia = procedencia; 
            this.regiao = regiao; 
            this.valor_pago = valor_pago; 
            this.valor_atual = valor_atual; 
            this.plataforma = plataforma; 
            this.tipo = tipo; 
            this.codigo = codigo; 
            this.complemento = complemento; 
            this.avaliacao = avaliacao; 
            this.local_primeiro = local_primeiro; 
            this.local_segundo = local_segundo; 
            this.local_terceiro = local_terceiro;
            this.flag_cartucho_disco = checarFlagFront(flag_cartucho_disco);
            this.flag_replica = checarFlagFront(flag_replica);
            this.flag_protetor = checarFlagFront(flag_protetor);
            this.flag_cd_dvd = checarFlagFront(flag_cd_dvd);
            this.flag_caixa = checarFlagFront(flag_caixa);
            this.flag_manual = checarFlagFront(flag_manual); 
            this.flag_berco = checarFlagFront(flag_berco);
            this.flag_panfleto = checarFlagFront(flag_panfleto); 
            this.flag_poster = checarFlagFront(flag_poster);
            this.flag_nota_fiscal = checarFlagFront(flag_nota_fiscal); 
            this.flag_lacrado = checarFlagFront(flag_lacrado); 
            this.flag_luva = checarFlagFront(flag_luva);
            this.id_user    = id_user;   
            this.status = status;
            this.progressao = checarValorNumerico(progressao);
            this.situacao = situacao;
            this.possui = possui;
            this.genero = genero;
            this.produtora = produtora;
            this.publicadora = publicadora;
            this.statusExtenso = checarStatus(status);
            this.screenshot1 = checarImagem(screenshot1);
            this.screenshot2 = checarImagem(screenshot2);
            this.screenshot3 = checarImagem(screenshot3);
            this.screenshot4 = checarImagem(screenshot4);
            this.tempo = checarValorNumerico(tempo);
            this.num_jogadas = checarValorNumerico(num_jogadas);
        }

        function convertDate(data){
            return new Date(parseInt(data));
        }


        function convert(item) {
            return new Item(
                item.id, 
                item.data_cadastro, 
                item.titulo, 
                item.descricao, 
                item.imagem, 
                item.procedencia, 
                item.regiao, 
                item.valor_pago, 
                item.valor_atual, 
                item.plataforma, 
                item.tipo, 
                item.codigo, 
                item.complemento, 
                item.avaliacao, 
                item.local_primeiro, 
                item.local_segundo, 
                item.local_terceiro,
                item.flag_cartucho_disco,
                item.flag_replica,
                item.flag_protetor,
                item.flag_cd_dvd,
                item.flag_caixa,
                item.flag_manual, 
                item.flag_berco,
                item.flag_panfleto, 
                item.flag_poster,
                item.flag_nota_fiscal, 
                item.flag_lacrado, 
                item.flag_luva,
                item.id_user,   
                item.status,
                item.progressao,
                item.situacao,
                item.possui,
                item.genero,
                item.produtora,
                item.publicadora,
                item.screenshot1,
                item.screenshot2,
                item.screenshot3,
                item.screenshot4,
                item.tempo,
                item.num_jogadas);
        }


        function convertList(items) {
            var converted = [];

            for (var i = 0; i < items.length; ++i) {
                converted.push(this.convert(items[i]));
            }

            return converted;
        }

        function convertBack(item) {
            var converted = {};
                converted.id = item.id;
                converted.data_cadastro = item.data_cadastro;
                converted.titulo = item.titulo;
                converted.descricao = item.descricao;
                converted.imagem = item.imagem;
                converted.procedencia = item.procedencia;
                converted.regiao = item.regiao;
                converted.valor_pago = item.valor_pago;
                converted.valor_atual = item.valor_atual;
                converted.plataforma = item.plataforma;
                converted.tipo = item.tipo;
                converted.codigo = item.codigo;
                converted.complemento = item.complemento;
                converted.avaliacao = item.avaliacao;
                converted.local_primeiro = item.local_primeiro;
                converted.local_segundo = item.local_segundo;
                converted.local_terceiro = item.local_terceiro;
                converted.flag_cartucho_disco = item.flag_cartucho_disco;
                converted.flag_replica = item.flag_replica;
                converted.flag_protetor = item.flag_protetor;
                converted.flag_cd_dvd = item.flag_cd_dvd;
                converted.flag_caixa = item.flag_caixa;
                converted.flag_manual = item.flag_manual;
                converted.flag_berco = item.flag_berco;
                converted.flag_panfleto = item.flag_panfleto;
                converted.flag_poster = item.flag_poster;
                converted.flag_nota_fiscal = item.flag_nota_fiscal;
                converted.flag_lacrado = item.flag_lacrado;
                converted.flag_luva = item.flag_luva;
                converted.id_user = item.id_user;
                converted.status = item.status;
                converted.progressao = item.progressao;
                converted.situacao = item.situacao;
                converted.possui = item.possui;
                converted.genero = item.genero;
                converted.produtora = item.produtora;
                converted.publicadora = item.publicadora;
                converted.screenshot1 = item.screenshot1;
                converted.screenshot2 = item.screenshot2;
                converted.screenshot3 = item.screenshot3;
                converted.screenshot4 = item.screenshot4;               
                converted.tempo = item.tempo;
                converted.num_jogadas = item.num_jogadas;

            return converted;
        }

        function getItem(){
            return this.item;
        }

        function setItem(item){
            this.item = item;
        }

        function getPesquisa(){
            return this.pesquisa;
        }

        function setPesquisa(item){
            this.pesquisa = item;
        }

        function limparItem(){
            this.item = undefined;
        }


    }
})();
