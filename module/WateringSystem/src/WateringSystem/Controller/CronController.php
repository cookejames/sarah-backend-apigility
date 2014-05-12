<?php
namespace WateringSystem\Controller;

use Zend\View\Model\JsonModel;
use WateringSystem\Entity\Sensor;
use WateringSystem\Entity\SensorValue;
use Zend\Mvc\MvcEvent;

class CronController extends WateringSystemControllerAbstract
{
	public function onDispatch(MvcEvent $e)
	{
		if ($this->getRequest()->getServer()->get('REMOTE_ADDR') != '127.0.0.1') {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		return parent::onDispatch($e);
	}
	
	/**
	 * Save the 
	 * @return \Zend\View\Model\JsonModel
	 */
    public function readSensorsAction()
    {
    	try {
    		$readings = $this->getSensorReadingModel()->getSensorReadings();
    		//convert the readings to sensor values
			$sensorValues = $this->getSensorReadingModel()->sensorReadingsToSensorValues($readings);
			
			//save all the sensor values
			foreach ($sensorValues as $value) {
				$this->saveEntity($value);
			}
			
			//get the pump and check if it should activate
			$pump = $this->getPumpModel()->getPumpFromConfig();
			if ($pump instanceof Sensor) {
				if ($this->getWateringModel()->shouldPumpActivate($pump, $sensorValues)) {
					$this->log($pump->getDescription() . ' should activate!');
					$this->getPumpModel()->turnPumpOn();
				} else {
					$this->log($pump->getDescription() . ' should not activate');
				}
			}

    		$this->log('Read sensors: ' . json_encode($readings));
    	} catch (\Exception $e) {
    		$this->log('Reading sensors failed: ' . $e->getMessage());
    		return new JsonModel(array('result' => false, 'message' => $e->getMessage()));
    	}
    	return new JsonModel(array('result' => true));
    }
    
    /**
     * Save the api weather results
     */
    public function readWeatherAction()
    {
    	$weather = $this->getWeatherModel()->getWeather();
    	foreach ($weather as $value) {
    		$this->saveEntity($value);
    	}
    	$this->log('Read ' . count($weather) . ' weather records');
    	return new JsonModel(array('result' => true));
    }
}
