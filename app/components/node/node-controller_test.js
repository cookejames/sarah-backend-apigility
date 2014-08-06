'use strict';

describe('Controller: nodeController', function(){
	var controller, scope;

	beforeEach(module('sarahApp'));

	beforeEach(inject(function($rootScope, $controller){
		scope = $rootScope.$new();
		controller = $controller("nodeController", {$scope: scope});
	}));

	it('should be defined', function() {
		expect(controller).toBeDefined();
	});

	it('should have nodes', function(){
		expect(controller.nodes).toBeArrayOfObjects();
	});

	it('should have set active methods', function(){
		controller.setActive(2);
		expect(controller.isActive(2)).toBeTruthy();
	});
});