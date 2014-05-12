<?php
/**
 * SensorReadingModel test case.
 */
class SensorReadingModelTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var SensorReadingModel
	 */
	private $sensorReadingModel;
	
	private $validReading = '{"h1":"42.0","t1":"25.0","t2":"21.2","l1":"650","m1":"720","m2":"512","p1":"0"}';
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		$bootstrap = PHPUnitBootstrap::getInstance();
		$serviceManager = $bootstrap->getServiceManager();
		$this->sensorReadingModel = $serviceManager->get('SensorReadingModel');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->sensorReadingModel = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Tests SensorReadingModel->getSensorReadings()
	 */
	public function testGetSensorReadings() {
		// TODO Auto-generated SensorReadingModelTest->testGetSensorReadings()
		$this->markTestIncomplete ( "getSensorReadings test not implemented" );
		
		$this->sensorReadingModel->getSensorReadings(/* parameters */);
	}
	
	/**
	 * Tests SensorReadingModel->sensorReadingsToSensorValues()
	 */
	public function testSensorReadingsToSensorValues() {
		$readings = json_decode($this->validReading);
		$sensorValues = $this->sensorReadingModel->sensorReadingsToSensorValues($readings);
		
		$this->assertInternalType('array', $sensorValues);
		$this->assertGreaterThan(0, count($sensorValues));
		
		foreach ($sensorValues as $sensorValue) {
			$this->assertInstanceOf('WateringSystem\Entity\SensorValue', $sensorValue);
		}
	}
}

