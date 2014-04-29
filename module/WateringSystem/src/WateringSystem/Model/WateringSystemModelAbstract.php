<?php

namespace WateringSystem\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\Logger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * Abstract class to carry out common model functions
 * @author James Cooke
 *
 */
abstract class WateringSystemModelAbstract implements ServiceLocatorAwareInterface
{
	protected $serviceLocator;
	protected $entityManager;
	protected $repository;
	
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
}
