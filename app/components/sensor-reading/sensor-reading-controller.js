'use strict';

angular.module('sensorReading').controller('sensorReadingController',
['$scope', 'sensorReadingService',
	function ($scope, sensorReadingService) {
		var sensorReadingController = this;

		this.sensors = sensorReadingService.sensors;
		this.sensorValues = sensorReadingService.sensorValues;
		sensorReadingService.fetchSensors();

		//When the sensors are updated we will likewise update our own copy of the sensors
		$scope.$on('sensorReadingService.sensors.update', function(event, sensors){
			sensorReadingController.sensors = sensors;
		});
		$scope.$on('sensorReadingService.sensorValues.update', function(event, sensorValues){
			sensorReadingController.sensorValues = sensorValues;
		});

		this.latestValue = function(sensorId) {
			return sensorReadingService.latestValue(sensorId);
		};

		this.latestTimestamp = function(sensorId) {
			return sensorReadingService.latestTimestamp(sensorId);
		};

		this.percentage = function(sensorReading) {
			return sensorReadingController.latestValue(sensorReading.id)
				/ (sensorReading.rangeMax - sensorReading.rangeMin) * 100;
		};
	}
]);
