<?php
/**
 * PumpModel test case.
 */
class PumpModelTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var PumpModel
	 */
	private $pumpModel;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		$bootstrap = PHPUnitBootstrap::getInstance();
		$serviceManager = $bootstrap->getServiceManager();
		$this->pumpModel = $serviceManager->get('PumpModel');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->pumpModel = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Tests PumpModel->turnPumpOn()
	 */
	public function testTurnPumpOn() 
	{
		$this->assertTrue($this->pumpModel->turnPumpOn());
	}
	
	/**
	 * Tests PumpModel->getPumpFromConfig()
	 */
	public function testGetPumpFromConfig() 
	{
		$pump = $this->pumpModel->getPumpFromConfig();
		
		$this->assertInstanceOf('WateringSystem\Entity\Sensor', $pump);
	}
}

