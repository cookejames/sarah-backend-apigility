<?php

namespace Sarah\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\Logger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Sarah\Entity\SarahEntityInterface;
use Doctrine\ORM\Query;

/**
 * Abstract class to carry out common model functions
 * @author James Cooke
 *
 */
abstract class SarahModelAbstract implements ServiceLocatorAwareInterface
{
	protected $serviceLocator;
	protected $entityManager;
	protected $repository;
	protected $hydrationMode = Query::HYDRATE_SCALAR;
	
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
	 * @return EntityRepository
	 */
	protected function getRepository()
	{
		return $this->getEntityManager()->getRepository($this->repository);
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
}
