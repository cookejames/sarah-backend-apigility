<?php

namespace Sarah\Model;

use Sarah\Model\SarahModelAbstract;

/**
 * Get details about a heating group
 * @author James Cooke
 *
 */
class HeatingGroupModel extends SarahModelAbstract 
{
	protected $entity = 'Sarah\Entity\HeatingGroup';
	
	/**
	 * Get all heating groups
	 * @return Ambigous <\Doctrine\ORM\Tools\Pagination\Paginator, \Sarah\Model\multitype:, multitype:, \Doctrine\ORM\mixed, mixed, \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed>
	 */
	public function getHeatingGroups()
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder->select('g')
			->from($this->entity, 'g')
			->orderBy('g.id', 'asc');
		
		return $this->returnResults($queryBuilder->getQuery());
	}
	
	/**
	 * Get a group by its id
	 * @param int $id
	 * @return Ambigous <\Doctrine\ORM\mixed, NULL, mixed, multitype:, \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed>
	 */
	public function getHeatingGroupById($id)
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder->select('g')
			->from($this->entity, 'g')
			->andWhere($queryBuilder->expr()->eq('g.id', ':id'))
			->setParameters(array(':id' => $id));
		
		return $this->returnOneOrNullResult($queryBuilder->getQuery());
	}
}