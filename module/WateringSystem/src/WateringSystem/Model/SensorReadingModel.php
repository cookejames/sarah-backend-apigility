<?php

namespace WateringSystem\Model;

/**
 * Retrieve sensor readings
 * @author James Cooke
 *
 */
class SensorReadingModel extends WateringSystemModelAbstract 
{
	public function getSensorReadings()
	{
		$response = '{"result":{"h1":"62.0", "t1":"23.0", "t2":"21.7", "l1":"773"}}';
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