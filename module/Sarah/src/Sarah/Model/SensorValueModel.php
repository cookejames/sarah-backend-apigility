<?php

namespace Sarah\Model;

use Sarah\Model\SarahModelAbstract;

/**
 * Get details about sensor values
 * @author James Cooke
 *
 */
class SensorValueModel extends SarahModelAbstract 
{
	protected $entity = 'Sarah\Entity\SensorValue';
	
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
			->from($this->entity, 'sensorValue')	
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

		return $this->returnResults($queryBuilder->getQuery());
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
			->from($this->entity, 'sensorValue')
			->andWhere('sensorValue.id = :id')
			->setParameters(array(':id' => $id));
		
		return $this->returnOneOrNullResult($queryBuilder->getQuery());
	}
}