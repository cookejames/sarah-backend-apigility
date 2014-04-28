<?php
namespace WateringSystem\Controller;

use Zend\View\Model\JsonModel;
use WateringSystem\Entity\Sensor;
use WateringSystem\Entity\SensorValue;

class CronController extends WateringSystemControllerAbstract
{
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
}
