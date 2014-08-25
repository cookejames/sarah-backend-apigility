<?php

namespace sarah\Model;

use sarah\Model\SarahModelAbstract;
use sarah\Entity\Node;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Doctrine\ORM\Query;

/**
 * Get details about sensor values
 * @author James Cooke
 *
 */
class SensorValueModel extends SarahModelAbstract 
{
	protected $repository = 'sarah\Entity\SensorValue';
	
	/**
	 * Get sensor values between two dates and for specified sensors
	 * @param \DateTime||null $from optional 
	 * @param \DateTime||null $to optional
	 * @param array $sensors array of sensor ids to limit the results to, empty array for all
	 * @param string $order
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator
	 */
	public function getSensorValuesBetween($from = null, $to = null, array $sensors = null, $order = 'DESC')
	{		
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder
			->select('sensorValue')
			->from($this->repository, 'sensorValue')	
			->orderBy('sensorValue.date', $order);
		
		if ($from instanceof \DateTime) {
			$queryBuilder
				->andWhere('sensorValue.date >= :from')
				->setParameter(':from', $from);
		}
		if ($to instanceof \DateTime) {
			$queryBuilder
			->andWhere('sensorValue.date < :to')
			->setParameter(':to', $to);
		}
		if (is_array($sensors)) {
			$queryBuilder
				->andWhere('sensorValue.sensor IN(:sensors)')
				->setParameter(':sensors', $sensors);
		}
		if ($this->hydrationMode === Query::HYDRATE_SCALAR) {
			$queryBuilder->addSelect('IDENTITY(sensorValue.sensor) as sensorValue_sensor');
		}

		$query = $queryBuilder->getQuery();
		$query->setHydrationMode($this->hydrationMode);
		return new ORMPaginator($query, false);
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $hydrationMode
	 * @return SensorValue||null
	 */
	public function getSensorValueById($id)
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder->select('sensorValue')
			->from($this->repository, 'sensorValue')
			->andWhere('sensorValue.id = :id')
			->setParameters(array(':id' => $id));
		
		if ($this->hydrationMode === Query::HYDRATE_SCALAR) {
			$queryBuilder->addSelect('IDENTITY(sensorValue.sensor) as sensorValue_sensor');
		}
	
		return $queryBuilder->getQuery()->getOneOrNullResult($this->hydrationMode);
	}
}