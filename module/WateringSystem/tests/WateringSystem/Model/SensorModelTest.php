<?php
use \PHPUnit_Framework_TestCase;
use WateringSystem\Model\SensorModel;

/**
 * SensorModel test case.
 */
class SensorModelTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var SensorModel
	 */
	private $sensorModel;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$bootstrap = PHPUnitBootstrap::getInstance();
		$serviceManager = $bootstrap->getServiceManager();
		$this->sensorModel = $serviceManager->get('SensorModel');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated SensorModelTest::tearDown()
		$this->sensorModel = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	/**
	 * Tests SensorModel->getSensors()
	 */
	public function testGetSensors() {
		// TODO Auto-generated SensorModelTest->testGetSensors()
		$this->markTestIncomplete ( "getSensors test not implemented" );
		
		$this->sensorModel->getSensors(/* parameters */);
	}
	
	/**
	 * Tests SensorModel->getSensorById()
	 */
	public function testGetSensorById() {
		// TODO Auto-generated SensorModelTest->testGetSensorById()
		$this->markTestIncomplete ( "getSensorById test not implemented" );
		
		$this->sensorModel->getSensorById(/* parameters */);
	}
	
	/**
	 * Tests SensorModel->getSensorByName()
	 */
	public function testGetSensorByName() {
		// TODO Auto-generated SensorModelTest->testGetSensorByName()
		$this->markTestIncomplete ( "getSensorByName test not implemented" );
		
		$this->sensorModel->getSensorByName(/* parameters */);
	}
}

