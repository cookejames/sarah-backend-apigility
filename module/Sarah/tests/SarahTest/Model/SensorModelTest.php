<?php
use Doctrine\ORM\Query;
use SarahTest\Bootstrap;
use Sarah\Model\SensorModel;
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
		$serviceManager = Bootstrap::getServiceManager();
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
	    $this->sensorModel->setHydrationMode(Query::HYDRATE_ARRAY);
		$sensors = $this->sensorModel->getSensors();
		//check we are getting an array with more than 1 element
		$this->assertInstanceOf('Doctrine\ORM\Tools\Pagination\Paginator', $sensors);
		$this->assertGreaterThan(0, count($sensors));
		
		foreach ($sensors as $sensor) {
			$this->assertInternalType('array', $sensor);
		}
	}
	
	/**
	 * Tests SensorModel->getSensors()
	 */
	public function testGetSensorsObjectHydrator()
	{
	    $this->sensorModel->setHydrationMode(Query::HYDRATE_OBJECT);
	    $sensors = $this->sensorModel->getSensors();
	    //check we are getting an array with more than 1 element
	    $this->assertInstanceOf('Doctrine\ORM\Tools\Pagination\Paginator', $sensors);
	    $this->assertGreaterThan(0, count($sensors));
	
	    foreach ($sensors as $sensor) {
	        $this->assertInstanceOf('Sarah\Entity\Sensor', $sensor);
	    }
	}
	
	/**
	 * Tests SensorModel->getSensorById()
	 */
	public function testGetSensorById() 
	{
		//get valid sensor
		$sensor = $this->sensorModel->getSensorById($this->validSensorId);
		$this->assertInstanceOf('Sarah\Entity\Sensor', $sensor);
		
		//get invalid sensor
		$sensor = $this->sensorModel->getSensorById(-1);
		$this->assertNull($sensor);
	}
}

