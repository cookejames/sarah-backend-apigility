<?php
/**
 * SensorModel test case.
 */
class SensorModelTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @var SensorModel
	 */
	private $sensorModel;
	
	private $validSensorId = 1;
	private $validSensorName = 'h1';
	
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
		$this->sensorModel = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
	}
	
	/**
	 * Tests SensorModel->getSensors()
	 */
	public function testGetSensors() 
	{
		$sensors = $this->sensorModel->getSensors();
		//check we are getting an array with more than 1 element
		$this->assertTrue(is_array($sensors));
		$this->assertGreaterThan(0, count($sensors));
		
		foreach ($sensors as $sensor) {
			$this->assertInstanceOf('sarah\Entity\Sensor', $sensor);
		}
	}
	
	/**
	 * Tests SensorModel->getSensorById()
	 */
	public function testGetSensorById() 
	{
		//get valid sensor
		$sensor = $this->sensorModel->getSensorById($this->validSensorId);
		$this->assertInstanceOf('sarah\Entity\Sensor', $sensor);
		
		//get invalid sensor
		$sensor = $this->sensorModel->getSensorById(-1);
		$this->assertNull($sensor);
	}
	
	/**
	 * Tests SensorModel->getSensorByName()
	 */
	public function testGetSensorByName() 
	{
		//get valid sensor
		$sensor = $this->sensorModel->getSensorByName($this->validSensorName);
		$this->assertInstanceOf('sarah\Entity\Sensor', $sensor);
		
		//get invalid sensor
		$sensor = $this->sensorModel->getSensorByName('foo');
		$this->assertNull($sensor);
	}
}

