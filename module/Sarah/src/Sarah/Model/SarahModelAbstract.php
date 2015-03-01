<?php

namespace Sarah\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\Logger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Sarah\Entity\SarahEntityInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

/**
 * Abstract class to carry out common model functions
 * @author James Cooke
 *
 */
abstract class SarahModelAbstract implements ServiceLocatorAwareInterface
{
	protected $serviceLocator;
	protected $entityManager;
	protected $entity;
	protected $paginateResults = false;
	protected $hydrationMode = Query::HYDRATE_OBJECT;
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
	/**
	 * Log a message
	 * @param String $message
	 * @param String $priority
	 */
	protected function log($message, $priority = Logger::INFO)
	{
		$logger = $this->getServiceLocator()->get('logger');
		$logger->log($priority, $message);
		return $this;
	}
	
	/**
	 * @return EntityManager
	 */
	protected function getEntityManager()
	{
		if (null === $this->entityManager) {
			$this->entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->entityManager;
	}
	
	/**
	 * @return QueryBuilder
	 */
	protected function createQueryBuilder()
	{
		return $this->getEntityManager()->createQueryBuilder();
	}
	
	/**
	 * Persist and flush an entity
	 * @param SarahEntityInterface $entity
	 * @return \sarah\Model\SarahModelAbstract
	 */
	public function saveEntity(SarahEntityInterface $entity)
	{
		$this->getEntityManager()->persist($entity);
		$this->getEntityManager()->flush();
		return $this;
	}
	
	/**
	 * Remove and flush an entity
	 * @param SarahEntityInterface $entity
	 * @return \Sarah\Model\SarahModelAbstract
	 */
	public function removeEntity(SarahEntityInterface $entity)
	{
		$this->getEntityManager()->remove($entity);
		$this->getEntityManager()->flush();
		return $this;		
	}
	
	/**
	 * Set the doctrine hydration mode for all queries
	 * @param unknown $hydrationMode
	 * @return \sarah\Model\SarahModelAbstract
	 */
	public function setHydrationMode($hydrationMode)
	{
		$this->hydrationMode = $hydrationMode;
		return $this;
	}
	
	/**
	 * Get the hydration mode being used in all queries
	 * @return Query::<constant>
	 */
	public function getHydrationMode()
	{
		return $this->hydrationMode;
	}
	
	/**
	 * Should the results of queries that could return multiple results be paginated
	 * @param boolean $paginate
	 * @return SarahModelAbstract
	 */
	public function paginateResults($paginate)
	{
		$this->paginateResults = ($paginate == true);
		return $this;
	}
	
	/**
	 * Return a paginator or array depending on whether pagination has been requested
	 * @param Query $query
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator|multitype:
	 */
	protected function returnResults(Query $query, $hydrationMode = null)
	{
		//Set the result hydration mode
		$hydrationMode = ($hydrationMode) ?: $this->hydrationMode;

		//Return a straight query or paginator
		if ($this->paginateResults) {
			$query->setHydrationMode($hydrationMode);
			return new ORMPaginator($query, false);
		} else {
			return $query->getResult($hydrationMode);
		}
	}
	
	/**
	 * Return a single result or null
	 * @param Query $query
	 * @return \Doctrine\ORM\mixed
	 */
	protected function returnOneOrNullResult(Query $query, $hydrationMode = null)
	{
		return $query->getOneOrNullResult(($hydrationMode) ?: $this->hydrationMode);
	}
}
