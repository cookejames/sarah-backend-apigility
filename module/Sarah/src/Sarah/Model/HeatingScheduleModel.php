<?php

namespace Sarah\Model;

use Sarah\Model\SarahModelAbstract;

/**
 * Get details about a heating schedule
 * @author James Cooke
 *
 */
class HeatingScheduleModel extends SarahModelAbstract 
{
	protected $entity = 'Sarah\Entity\HeatingSchedule';
	
	/**
	 * Get all heating schedules
	 * @return Ambigous <\Doctrine\ORM\Tools\Pagination\Paginator, \Sarah\Model\multitype:, multitype:, \Doctrine\ORM\mixed, mixed, \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed>
	 */
	public function getHeatingSchedules()
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder->select('schedules')
			->from($this->entity, 'schedules')
			->orderBy('schedules.id', 'asc');
		
		return $this->returnResults($queryBuilder->getQuery());
	}
	
	/**
	 * Get a schedule by its id
	 * @param int $id
	 * @return Ambigous <\Doctrine\ORM\mixed, NULL, mixed, multitype:, \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed>
	 */
	public function getHeatingScheduleById($id)
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder->select('schedules')
			->from($this->entity, 'schedules')
			->andWhere($queryBuilder->expr()->eq('schedules.id', ':id'))
			->setParameters(array(':id' => $id));
		
		return $this->returnOneOrNullResult($queryBuilder->getQuery());
	}
}