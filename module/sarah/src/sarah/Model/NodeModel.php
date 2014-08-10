<?php

namespace sarah\Model;

use sarah\Model\WateringSystemModelAbstract;
use sarah\Entity\Node;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator as Paginator;
use Doctrine\ORM\Query;

/**
 * Get details about node
 * @author James Cooke
 *
 */
class NodeModel extends WateringSystemModelAbstract 
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
		$query->setHydrationMode(Query::HYDRATE_ARRAY);
		return new ORMPaginator($query, false);
	}
	
	/**
	 * Get a node by its id
	 * @param int $id
	 * @return Node
	 */
	public function getNodeById($id)
	{
		return $this->getRepository()->find($id);
	}
	
	/**
	 * Get a node by its name
	 * @param String $name
	 * @return Node
	 */
	public function getNodeByName($name)
	{
		return $this->getRepository()->findOneBy(array('name' => $name));
	}
}