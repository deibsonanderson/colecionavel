angular
    .module('colecionavel.module')
    .run(appRun);

/* @ngInject */
function appRun(routerHelper) {
    routerHelper.configureStates(getStates());
}

function getStates() {
    return [
        {
            state: 'index',
            config: {
                url: 'colecionavel/',
                controller: 'HomeController',
                controllerAs: 'HomeCtrl',
                templateUrl: 'modules/home/templates/home.template.html',
                data:{
                    firstAccess: true
                },
                resolve: {
                    loadDeps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({
                            serie: true,
                            files: [
                            'modules/home/home.module.js',
                            'modules/item/item.module.js',
                            'modules/user/user.module.js',
                            'modules/user/service/user.service.js',
                            'modules/user/factory/user.factory.js',                            
                            'modules/item/service/item.service.js',
                            'modules/item/factory/item.factory.js',                            
                            'modules/home/controller/home.controller.js'
                            ]});
                    }]
                }  
            }
        },    
        {
            state: 'home',
            config: {
                url: 'colecionavel/',
                controller: 'HomeController',
                controllerAs: 'HomeCtrl',
                templateUrl: 'modules/home/templates/home.template.html',
                data:{
                    firstAccess: false
                },
                resolve: {
                    loadDeps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({
                            serie: true,
                            files: [
                            'modules/home/home.module.js',
                            'modules/item/item.module.js',
                            'modules/user/user.module.js',
                            'modules/user/service/user.service.js',
                            'modules/user/factory/user.factory.js',                            
                            'modules/item/service/item.service.js',
                            'modules/item/factory/item.factory.js',                            
                            'modules/home/controller/home.controller.js'
                            ]});
                    }]
                }  
            }
        },
        {
            state: 'item-manter',
            config: {
                url: 'colecionavel/',
                controller: 'ItemManterController',
                controllerAs: 'ItemManterCtrl',
                templateUrl: 'modules/item/templates/item.manter.template.html',
                resolve: {
                    loadDeps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({
                            serie: true,
                            files: [
                            'modules/user/user.module.js',
                            'modules/user/service/user.service.js',                             
                            'modules/item/item.module.js',
                            'modules/item/service/item.service.js',
                            'modules/item/factory/item.factory.js',
                            'modules/item/controller/item.manter.controller.js'
                            ]});
                    }]
                }                                
            }
        },                                 
        {
            state: 'item-listar',
            config: {
                url: 'colecionavel/',
                controller: 'ItemListarController',
                controllerAs: 'ItemListarCtrl',
                templateUrl: 'modules/item/templates/item.listar.template.html',
			    params: {
					obj: undefined
				},
                resolve: {
                    loadDeps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({
                            serie: true,
                            files: [
                            'modules/user/user.module.js',
                            'modules/user/service/user.service.js',
                            'modules/item/item.module.js',
                            'modules/item/service/item.service.js',
                            'modules/item/factory/item.factory.js',
                            'modules/item/controller/item.listar.controller.js'
                            ]});
                    }]
                }                                
            }
        },
        {
            state: 'item-galeria',
            config: {
                url: 'colecionavel/',
                controller: 'ItemGaleriaController',
                controllerAs: 'ItemGaleriaCtrl',
                templateUrl: 'modules/item/templates/item.galeria.template.html',
                resolve: {
                    loadDeps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({
                            serie: true,
                            files: [
                            'modules/user/user.module.js',
                            'modules/user/service/user.service.js', 
                            'modules/item/item.module.js',
                            'modules/item/service/item.service.js',
                            'modules/item/factory/item.factory.js',
                            'modules/item/controller/item.galeria.controller.js'
                            ]});
                    }]
                }                                
            }
        },
        {
            state: 'user-manter',
            config: {
                url: 'colecionavel/',
                controller: 'UserManterController',
                controllerAs: 'UserManterCtrl',
                templateUrl: 'modules/user/templates/user.manter.template.html',
                resolve: {
                    loadDeps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({
                            serie: true,
                            files: [
                            'modules/user/user.module.js',
                            'modules/user/service/user.service.js',                             
                            'modules/user/factory/user.factory.js',
                            'modules/user/controller/user.manter.controller.js'
                            ]});
                    }]
                }                                
            }
        },
        {
            state: 'user-senha',
            config: {
                url: 'colecionavel/',
                controller: 'UserSenhaController',
                controllerAs: 'UserSenhaCtrl',
                templateUrl: 'modules/user/templates/user.senha.template.html',
                resolve: {
                    loadDeps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({
                            serie: true,
                            files: [
                            'modules/user/user.module.js',
                            'modules/user/service/user.service.js', 
                            'modules/user/factory/user.factory.js',
                            'modules/user/controller/user.senha.controller.js'
                            ]});
                    }]
                }                                
            }
        }                                    
                                          

    ];
}
