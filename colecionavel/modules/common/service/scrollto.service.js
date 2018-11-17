(function () {
    'use strict';

    angular
            .module('colecionavel.module')
            .service('ScrollToService', ScrollToService);

    ScrollToService.$inject = ['$location', '$anchorScroll'];

    /**
     * @ngdoc service
     * @name porto.producao.portal.service:ScrollToService
     * @description
     *
     * Servico que faz a tela subir para o topo
     **/

    function ScrollToService($location, $anchorScroll) {

        this.scrollToTop = scrollToTop;
        this.scrollToId = scrollToId;
        this.scrollFixDivHerarquia = scrollFixDivHerarquia;
         /**
         * @ngdoc method
         * @name porto.producao.portal:ScrollToService#scrollToTop
         * @methodOf porto.producao.portal.service:ScrollToService
         * @param {Object} element página em questão.
         * @param {Number} to altura de onde quer o movimento.
         * @param {Number} duration duração em mileseconds do evento de subida.
         * @returns {undefined} retorno .
         * @description
         *
         * Metodo que sobe para o topo da página
        **/
        function scrollToTop(to, duration) {
            $('body').removeClass('altura-full');
            $('body').addClass('altura-initial');
            
            var top = undefined;
            if(document.documentElement && document.documentElement.scrollTop){
                top = document.documentElement;
            }else{
                top = document.body;
            }
            if(!angular.isUndefined(top)){
                if (duration <= 0){
                    $('body').removeClass('altura-initial');
                    $('body').addClass('altura-full');
                    
                    
                    return;
                }
                    
                var difference = to - top.scrollTop;
                var perTick = difference / duration * 10;
                
                setTimeout(function () {
                    top.scrollTop = top.scrollTop + perTick;
                    if (top.scrollTop == to){
                        $('body').removeClass('altura-initial');
                        $('body').addClass('altura-full');
                        return;
                    }                        
                    scrollToTop(to, duration - 10);

                }, 10);

            }

            

        };

        function scrollToId(id) {
            $location.hash(id);

            $anchorScroll();
        };
        
        /**
         * @ngdoc method
         * @name porto.producao.portal:ScrollToService#scrollToTop
         * @methodOf porto.producao.portal.service:ScrollToService
         * @param nome do elemento.
         * @returns {undefined}
         * @description
         * Esse metodo tem por finalidade corrigir uma incompatibilidade com o IE10 
         * quando se é utilizado um tree view dentro de uma div com Scroll
         * caso não utilizar o IE vai para o ScrollTop ZERO a cada renderização
         */
        function scrollFixDivHerarquia(nomeElemento){
            var scr = document.getElementById(nomeElemento).scrollTop;
            setTimeout(function () {
                document.getElementById(nomeElemento).scrollTop = scr;
            }, 10);
        };         
    }
})();
