(function () {
	'use strict';

	angular.module('colecionavel.module').directive('alerta', Alerta);

	Alerta.$inject = [];

function Alerta() {
	return {
		restrict: 'AEC',
		link: function(scope, el, attr, controller){},
		scope:{
			alerts: "@alerts",
			type: "="
		},
		templateUrl: "modules/common/templates/alerta.template.html",
		controller: ['$scope', function($scope){
				var vm = this;
				//vm.closeAlert = closeAlert;
				vm.type = $scope.type;
				vm.alerts = $scope.alerts;

				//function closeAlert(index){
				//	vm.alerts.splice(index, 1);
				//}

		}],
		controllerAs:"alertaCtrl"
	};
};

})();
