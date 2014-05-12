<?php

namespace WateringSystem\Model;

use WateringSystem\Model\Sensors\SensorAbstract;
use WateringSystem\Entity\Sensor;
/**
 * Retrieve sensor readings
 * @author James Cooke
 *
 */
class SensorReadingModel extends WateringSystemModelAbstract 
{
	/** @var SensorAbstract */
	protected $sensor;
	
	public function __construct(SensorAbstract $sensor)
	{
		$this->sensor = $sensor;
	}
	
	/**
	 * Get sensor readings
	 * @throws \Exception
	 */
	public function getSensorReadings()
	{
		//send the status message
		$this->sensor->sendMessage('status');
		//read the reply
		$response = $this->sensor->readMessage();
		
		//decode the reponse and check for validity
		$json = json_decode($response);
		if (isset($json->result)) {
			if ($json->result) {
				return $json->result;
			} else {
				$error = (isset($response->message)) ? $response->message : 'Error in sensor reading';
				throw new \Exception($error);
			}
		} else {
			throw new \Exception('Could not get a sensor reading');
		}
	}

	/**
	 * Convert readings into an array of sensor values
	 * @param unknown $readings
	 * @return multitype:unknown
	 */
	public function sensorReadingsToSensorValues($readings)
	{
		$sensorValues = array();	
		foreach ($readings as $name => $value) {
			$sensorModel = $this->getServiceLocator()->get('SensorModel');
			$sensor = $sensorModel->getSensorByName($name);
			if ($sensor instanceof Sensor) {
				$sensorValue = $sensor->getNewSensorValue();
				$sensorValue->setValue($value);
				$sensorValues[] = $sensorValue;
			}
		}
		
		return $sensorValues;
	}
}