<?php
require_once 'module/WateringSystem/src/WateringSystem/Model/WateringModel.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * WateringModel test case.
 */
class WateringModelTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var WateringModel
	 */
	private $wateringModel;
	private $serviceManager;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		$bootstrap = PHPUnitBootstrap::getInstance();
		$serviceManager = $bootstrap->getServiceManager();
		$this->serviceManager = $serviceManager;
		$this->wateringModel = $serviceManager->get('WateringModel');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->wateringModel = null;
		$this->serviceManager = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Tests WateringModel->shouldPumpActivate()
	 */
	public function testShouldPumpActivate() {
		// TODO create dummy data
		$this->markTestIncomplete ( "shouldPumpActivate test not implemented" );
		$sm = $this->serviceManager->get('SensorModel');
		$pump = $sm->getSensorByName('p1');
		$m1 = $sm->getSensorByName('m1');
		$m2 = $sm->getSensorByName('m2');
		
		$active = $this->wateringModel->shouldPumpActivate($pump, array($m1, $m2));
		
	}
}

