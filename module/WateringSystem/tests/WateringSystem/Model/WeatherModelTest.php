<?php
use WateringSystem\Entity\SensorValue;
/**
 * WeatherModel test case.
 */
class WeatherModelTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var WeatherModel
	 */
	private $weatherModel;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$bootstrap = PHPUnitBootstrap::getInstance();
		$serviceManager = $bootstrap->getServiceManager();
		$this->weatherModel = $serviceManager->get('WeatherModel');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->weatherModel = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Tests WeatherModel->getWeather()
	 */
	public function testGetWeather() {
		$weather = $this->weatherModel->getWeather();
		
		$this->assertInternalType('array', $weather);
		
		foreach ($weather as $sensorValue) {
			$this->assertInstanceOf('WateringSystem\Entity\SensorValue', $sensorValue);
		}
	}
}

