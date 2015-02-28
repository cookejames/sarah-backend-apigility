<?php

namespace Sarah\Model;

use Sarah\Model\SarahModelAbstract;
use Sarah\Entity\Sensor;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Doctrine\ORM\Query;

/**
 * Get details about sensors
 * @author James Cooke
 *
 */
class SensorModel extends SarahModelAbstract 
{
	protected $repository = 'Sarah\Entity\Sensor';
	
	/**
	 * Get all sensors
	 * @return Sensor[]
	 */
	public function getSensors(array $nodes = null)
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder
			->select('sensor')
			->from($this->repository, 'sensor')
			->andWhere('sensor.isEnabled = true')
			->orderBy('sensor.id', 'ASC');

		if (count($nodes) > 0) {
			$queryBuilder
			->andWhere('sensor.node IN(:nodes)')
			->setParameter(':nodes', $nodes);
		}
		if ($this->hydrationMode === Query::HYDRATE_SCALAR) {
			$queryBuilder->addSelect('IDENTITY(sensor.node) as sensor_node');
		}
		
		$query = $queryBuilder->getQuery();
		$query->setHydrationMode($this->hydrationMode);
		return new ORMPaginator($query, false);
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
			->from($this->repository, 'sensor')
			->andWhere('sensor.id = :id')
			->setParameters(array(':id' => $id));
		
		if ($this->hydrationMode === Query::HYDRATE_SCALAR) {
			$queryBuilder->addSelect('IDENTITY(sensor.node) as sensor_node');
		}
		
		return $queryBuilder->getQuery()->getOneOrNullResult($this->hydrationMode);
	}
}