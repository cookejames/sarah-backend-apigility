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
    		foreach ($readings as $name => $value) {
    			$sensor = $this->getSensorModel()->getSensorByName($name);
    			if ($sensor instanceof Sensor) {
    				$sensorValue = $sensor->getNewSensorValue();
    				$sensorValue->setValue($value);
    				$this->saveEntity($sensorValue);
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
    		$this->log('Read weather value: '. json_encode($value));
    	}
    	return new JsonModel(array('result' => true));
    }
}
