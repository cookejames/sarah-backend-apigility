<?php

namespace WateringSystem\Model;

use WateringSystem\Model\WateringSystemModelAbstract;
use WateringSystem\Entity\SensorValue;

/**
 * Get details about sensor values
 * @author James Cooke
 *
 */
class SensorValueModel extends WateringSystemModelAbstract 
{
	protected $repository = 'WateringSystem\Entity\SensorValue';
	
	/**
	 * Get all sensor values
	 * @return SensorValue[]
	 */
	public function getSensorValues()
	{
		return $this->getRepository()->findAll();
	}
}