<?php

namespace sarah\Model;

use sarah\Model\WateringSystemModelAbstract;
use sarah\Entity\SensorValue;
use Doctrine\ORM\Query\Expr;
use sarah\Entity\Node;

/**
 * Get details about sensor values
 * @author James Cooke
 *
 */
class SensorValueModel extends WateringSystemModelAbstract 
{
	protected $repository = 'sarah\Entity\SensorValue';
	
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
	 * @param Node $node the node to get the values for 
	 * @return SensorValue[]
	 */
	public function getSensorValuesBetween(\DateTime $from, \DateTime $to, Node $node, $order = 'DESC')
	{
		$queryBuilder = $this->createQueryBuilder();
		$result = $queryBuilder
			->select('sensorValues')
			->from($this->repository, 'sensorValues')
			->innerJoin('sarah\Entity\Sensor', 'sensors', 'WITH', 'sensorValues.sensor = sensors.id')
			->andWhere($queryBuilder->expr()->gte('sensorValues.date', ':from'))
			->andWhere($queryBuilder->expr()->lt('sensorValues.date', ':to'))
			->andWhere($queryBuilder->expr()->eq('sensors.isEnabled', ':enabled'))
			->andWhere($queryBuilder->expr()->eq('sensors.node', ':node'))
			->setParameters(array(':enabled' => true, ':from' => $from, ':to' => $to, ':node' => $node->getId()))
			->orderBy('sensorValues.date', $order);

		$query = $queryBuilder->getQuery();
		return $query->getResult();
	}
}