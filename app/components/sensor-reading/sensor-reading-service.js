angular.module('sensorReading').service('sensorReadingService',
['$rootScope', 'Restangular', 'orderByFilter', 'limitToFilter', 'filterFilter',
function ($rootScope, Restangular, orderByFilter, limitToFilter, filterFilter) {
	'use strict';
	var sensorReadingService = this;
	var baseNodes = Restangular.all('getnodes');
	var baseSensors = Restangular.all('getsensors');
	var baseSensorValues = Restangular.all('getsensorvalues');
	var latestValues = {};
	/**
	 * Parse the sensorValues to find the latest for each sensor and store in latestValues
	 */
	var getLatestValues = function(sensors, sensorValues) {
		angular.forEach(sensors, function(sensor){
			var latest = limitToFilter(orderByFilter(filterFilter(sensorValues, {sensor: sensor.id}, true), '-timestamp'), 1);
			if (latest.length == 1) {
				latestValues[sensor.id] = latest[0];
			}
		});
	};

	var service = {
		nodes: [],
		sensors: [],
		sensorValues: [],


		fetchNodes: function() {
			baseNodes.getList().
				then(function(nodes) {
					service.nodes = nodes;
					$rootScope.$broadcast('sensorReadingService.nodes.update', nodes);
				});
		},

		fetchSensors: function() {
			baseSensors.getList().
				then(function(sensors) {
					service.sensors = sensors;
					getLatestValues(service.sensors, service.sensorValues);
					$rootScope.$broadcast('sensorReadingService.sensors.update', sensors);
				});
		},

		fetchSensorValues: function(node) {
			//hard coded for now
			var from = parseInt(Date.now()/1000) - 60*60*48;
			var to = parseInt(Date.now()/1000);
			baseSensorValues.getList({node: node, from: from, to: to}).
				then(function(sensorValues) {
					service.sensorValues = sensorValues;
					getLatestValues(service.sensors, service.sensorValues);
					$rootScope.$broadcast('sensorReadingService.sensorValues.update', sensorValues);
				});
		},

		/**
		 * Get the sensors in a node
		 * @param node
		 * @returns {*}
		 */
		sensorsByNode: function(node) {
			return filterFilter(service.sensors, {node: node});
		},

		/**
		 * Get the latest value for this sensor
		 * @param sensorId
		 * @returns {*}
		 */
		latestValue: function(sensorId) {
			if (latestValues[sensorId] === undefined) {
				return false;
			}
			return latestValues[sensorId].value;
		},

		/**
		 * Get the latest timestamp for this sensor
		 * @param sensorId
		 * @returns {*}
		 */
		latestTimestamp: function(sensorId) {
			if (latestValues[sensorId] === undefined) {
				return false;
			}
			return latestValues[sensorId].timestamp;
		}
	};

	return service;
}]);