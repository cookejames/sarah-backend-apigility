<?php

namespace sarah\Model;

use sarah\Model\SarahModelAbstract;
use sarah\Entity\Node;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Doctrine\ORM\Query;

/**
 * Get details about node
 * @author James Cooke
 *
 */
class NodeModel extends SarahModelAbstract 
{
	protected $repository = 'sarah\Entity\Node';
	
	/**
	 * Get all sensors
	 * @return Node[]
	 */
	public function getNodes()
	{
		$queryBuilder = $this->createQueryBuilder();
		$queryBuilder->select('node')
			->from($this->repository, 'node')
			->andWhere($queryBuilder->expr()->eq('node.isEnabled', true))
			->orderBy('node.id', 'asc');
		
		$query = $queryBuilder->getQuery();
		$query->setHydrationMode($this->hydrationMode);
		return new ORMPaginator($query, false);
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
			->from($this->repository, 'node')
			->andWhere($queryBuilder->expr()->eq('node.isEnabled', true))
			->andWhere($queryBuilder->expr()->eq('node.id', ':node'))
			->setParameters(array(':node' => $id));
		
		return $queryBuilder->getQuery()->getOneOrNullResult($this->hydrationMode);
	}
}