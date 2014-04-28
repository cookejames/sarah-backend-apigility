<?php

namespace WateringSystem\Model;

use WateringSystem\Model\Sensors\SensorAbstract;
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
		$this->sensor->sendMessage($pointer, 'status');
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

}