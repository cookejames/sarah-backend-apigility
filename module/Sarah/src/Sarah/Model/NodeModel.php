<?php

namespace Sarah\Model;

use Sarah\Model\SarahModelAbstract;
use Sarah\Entity\Node;

/**
 * Get details about node
 * @author James Cooke
 *
 */
class NodeModel extends SarahModelAbstract 
{
	protected $entity = 'Sarah\Entity\Node';
	
	/**
	 * Get all sensors
	 * @return Node[]
	 */
	public function getNodes()
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder->select('node')
			->from($this->entity, 'node')
			->andWhere($queryBuilder->expr()->eq('node.isEnabled', true))
			->orderBy('node.id', 'asc');
		
		return $this->returnResults($queryBuilder->getQuery());
	}
	
	/**
	 * Get a node by its id
	 * @param int $id
	 * @return Node
	 */
	public function getNodeById($id)
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder->select('node')
			->from($this->entity, 'node')
			->andWhere($queryBuilder->expr()->eq('node.isEnabled', true))
			->andWhere($queryBuilder->expr()->eq('node.id', ':node'))
			->setParameters(array(':node' => $id));
		
		return $this->returnOneOrNullResult($queryBuilder->getQuery());
	}
}