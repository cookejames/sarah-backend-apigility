<?php
use WateringSystem\Entity\SensorValue;
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
	
	private $sensor1 = 'm1';
	private $sensor2 = 'm2';
	
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
		//TODO need to create better dummy data for pump
		$sm = $this->serviceManager->get('SensorModel');
		$sVm = $this->serviceManager->get('SensorValueModel');
		$pm = $this->serviceManager->get('PumpModel');
		
		//create dummy data and test not active when over threshold for 1 sensor
		$pump = $pm->getPumpFromConfig();
		$m1 = $sm->getSensorByName($this->sensor1);
		$v1 = new SensorValue();
		$v1->setSensor($m1)
		   ->setValue($m1->getWateringThresholdUpper() + 1);
		
		$m2 = $sm->getSensorByName($this->sensor2);
		$v2 = new SensorValue();
		$v2->setSensor($m2)
		   ->setValue($m2->getWateringThresholdLower());
		
		$active = $this->wateringModel->shouldPumpActivate($pump, array($v1, $v2));
		$this->assertFalse($active);
		
		//value at threshold
		$v1->setValue($m1->getWateringThresholdUpper());
		$active = $this->wateringModel->shouldPumpActivate($pump, array($v1, $v2));
		$this->assertFalse($active);
		
		//below threshold
		$v2->setValue($m2->getWateringThresholdLower() - 1);
		$active = $this->wateringModel->shouldPumpActivate($pump, array($v1, $v2));
		$this->assertTrue($active);
	}
}

