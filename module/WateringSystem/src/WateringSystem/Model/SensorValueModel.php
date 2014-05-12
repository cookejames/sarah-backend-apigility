<?php

namespace WateringSystem\Model;

use WateringSystem\Model\WateringSystemModelAbstract;
use WateringSystem\Entity\SensorValue;
use Doctrine\ORM\Query\Expr;

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
	 * @param mixed the last value must equals this
	 */
	public function getLastValue($sensorId, $whereValueEquals = null)
	{
		$parameters = array('sensor' => $sensorId);
		
		if (!is_null($whereValueEquals)) {
			$parameters['value'] = $whereValueEquals;
		}
		
		return $this->getRepository()->findOneBy($parameters, array('date' => 'DESC'));
		
	}
	
	/**
	 * Get enabled sensor values since this date
	 * @param \DateTime $from
	 * @return SensorValue[]
	 */
	public function getSensorValuesBetween(\DateTime $from, \DateTime $to, $order = 'DESC')
	{
		$queryBuilder = $this->createQueryBuilder();
		$result = $queryBuilder
			->select('sensorValues')
			->from($this->repository, 'sensorValues')
			->innerJoin('WateringSystem\Entity\Sensor', 'sensors', 'WITH', 'sensorValues.sensor = sensors.id')
			->andWhere($queryBuilder->expr()->gte('sensorValues.date', ':from'))
			->andWhere($queryBuilder->expr()->lt('sensorValues.date', ':to'))
			->andWhere($queryBuilder->expr()->eq('sensors.isEnabled', ':enabled'))
			->setParameters(array(':enabled' => true, ':from' => $from, ':to' => $to))
			->orderBy('sensorValues.date', $order);

		$query = $queryBuilder->getQuery();
		return $query->getResult();
	}
}