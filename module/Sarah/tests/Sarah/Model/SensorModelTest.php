<?php
use Doctrine\ORM\Query;
use SarahTest\Bootstrap;
use Sarah\Model\SensorModel;
use SarahTest\Database\TestCase;
/**
 * SensorModel test case.
 */
class SensorModelTest extends TestCase 
{
	/**
	 * @var SensorModel
	 */
	private $sensorModel;	
	private $validSensorId = 1;
	private $validSensorName = 'h1';
	
	/* (non-PHPdoc)
	 * @see \SarahTest\Database\TestCase::getServiceLocator()
	*/
	protected function getServiceLocator ()
	{
		return Bootstrap::getServiceManager();
	}
	
	/* (non-PHPdoc)
	 * @see PHPUnit_Extensions_Database_TestCase::getDataSet()
	*/
	protected function getDataSet ()
	{
		return $this->createArrayDataSet(array(
			'nodes' => array(
				array(
					'id' => 1,
					'name' => 'node1',
					'isEnabled' => true
				),
			),
			'sensors' => array(
				array(
					'id' => 1,
					'name' => 'sensor1',
					'description' => '',
					'node' =>  1,
					'valueType' => 'int',
					'conversionFactor' => 1,
					'isRanged' => false,
					'isEnabled' => true,
				),
			)
		));
	}
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->sensorModel = $this->getServiceLocator()->get('SensorModel');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() 
	{
		parent::tearDown ();
		$this->sensorModel = null;
	}
	
	/**
	 * Tests SensorModel->getSensors()
	 */
	public function testGetSensors() 
	{
	    $this->sensorModel->setHydrationMode(Query::HYDRATE_ARRAY);
		$sensors = $this->sensorModel->getSensors();
		//check we are getting an array with more than 1 element
		$this->assertInternalType('array', $sensors);
		$this->assertEquals(1, count($sensors));
		
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
	    $this->assertInternalType('array', $sensors);
	    $this->assertEquals(1, count($sensors));
	
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

