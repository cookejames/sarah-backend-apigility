'use strict';

angular.module('sarahApp.node').controller('nodeController',
['$scope', 'sensorReadingService', '$interval',
function ($scope, sensorReadingService, $interval) {
	var nodeController = this;

	var updateInterval = 60 * 1000; //how often to fetch the sensor values for the active node - every minute
	var activeNode = null;
	this.nodes = sensorReadingService.nodes;
	sensorReadingService.fetchNodes();

	//When the nodes are updated we will likewise update our own copy of the nodes
	$scope.$on('sensorReadingService.nodes.update', function(event, nodes){
		nodeController.nodes = nodes;

		//setup the active node
		if (nodes.length > 0 && activeNode == null) {
			nodeController.setActive(nodes[0].id);
		}
	});

	//Update the active node regularly
	var interval = $interval(function(){
		if (activeNode != null) {
			sensorReadingService.fetchSensorValues(activeNode);
		}
	}, updateInterval);
	$scope.$on('$destroy', function() {
		$interval.cancel(interval);
	});

	/**
	 * Is this node active
	 * @param node
	 * @returns {boolean}
	 */
	this.isActive = function(node) {
		return node == activeNode;
	};

	/**
	 * Set this as the active node
	 * @param node
	 */
	this.setActive = function(node) {
		activeNode = node;
		sensorReadingService.fetchSensorValues(node);
	};
}]);
