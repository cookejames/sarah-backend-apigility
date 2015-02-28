<?php

namespace Sarah\Model;

use Sarah\Model\SarahModelAbstract;
use Sarah\Entity\Sensor;

/**
 * Get details about sensors
 * @author James Cooke
 *
 */
class SensorModel extends SarahModelAbstract 
{
	protected $entity = 'Sarah\Entity\Sensor';
	
	/**
	 * Get all sensors
	 * @return Sensor[]
	 */
	public function getSensors(array $nodes = null)
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder
			->select('sensor')
			->from($this->entity, 'sensor')
			->andWhere('sensor.isEnabled = true')
			->orderBy('sensor.id', 'ASC');

		if (count($nodes) > 0) {
			$queryBuilder
			->andWhere('sensor.node IN(:nodes)')
			->setParameter(':nodes', $nodes);
		}
		
		return $this->returnResults($queryBuilder->getQuery());
	}
	
	/**
	 * Get a sensor by its id
	 * @param int $id
	 * @return Sensor
	 */
	public function getSensorById($id)
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder->select('sensor')
			->from($this->entity, 'sensor')
			->andWhere('sensor.id = :id')
			->setParameters(array(':id' => $id));
		
		return $this->returnOneOrNullResult($queryBuilder->getQuery());
	}
}