<?php

namespace WateringSystem\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\Logger;

/**
 * Abstract class to carry out common model functions
 * @author James Cooke
 *
 */
abstract class WateringSystemModelAbstract implements ServiceLocatorAwareInterface
{
	protected $serviceLocator;
	
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
	public function log($message, $priority = Logger::INFO)
	{
		$logger = $this->getServiceLocator()->get('logger');
		$logger->log($priority, $message);
		return $this;
	}
}
