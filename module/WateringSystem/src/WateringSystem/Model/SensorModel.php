<?php

namespace WateringSystem\Model;

use WateringSystem\Model\WateringSystemModelAbstract;
use WateringSystem\Entity\Sensor;

/**
 * Get details about sensors
 * @author James Cooke
 *
 */
class SensorModel extends WateringSystemModelAbstract 
{
	protected $repository = 'WateringSystem\Entity\Sensor';
	
	/**
	 * Get all sensors
	 * @return Sensor[]
	 */
	public function getSensors()
	{
		return $this->getRepository()->findAll();
	}
	
	/**
	 * Get a sensor by its id
	 * @param int $id
	 * @return Sensor
	 */
	public function getSensorById($id)
	{
		return $this->getRepository()->find($id);
	}
	
	/**
	 * Get a sensor by its name
	 * @param String $name
	 * @return Sensor
	 */
	public function getSensorByName($name)
	{
		return $this->getRepository()->findOneBy(array('name' => $name));
	}
}