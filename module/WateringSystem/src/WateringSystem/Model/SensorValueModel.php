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
	
	/**
	 * Get the last value for a sensor
	 * @param int $sensorId
	 */
	public function getLastValue($sensorId)
	{
		return $this->getRepository()->findOneBy(array('sensor' => $sensorId), array('date' => 'DESC'));
		
	}
	
	/**
	 * Get sensor values since this date
	 * @param \DateTime $date
	 * @return SensorValue[]
	 */
	public function getSensorValuesSince(\DateTime $date, $order = 'DESC')
	{
		$queryBuilder = $this->createQueryBuilder();
		$result = $queryBuilder
			->select('sensorValues')
			->from($this->repository, 'sensorValues')
			->where($queryBuilder->expr()->gte('sensorValues.date', ':date'))
			->setParameter(':date', $date)
			->orderBy('sensorValues.date', $order);

		$query = $queryBuilder->getQuery();
		return $query->getResult();
	} 
}