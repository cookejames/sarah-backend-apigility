'use strict';

angular.module('rickshawGraph', []).directive('rickshawGraph', function() {
	return {
		restrict: 'AE',
		scope: {
			sensors : '=rickshawSensors'
		},
		link: function(scope, element, attrs) {

		}
	};
});