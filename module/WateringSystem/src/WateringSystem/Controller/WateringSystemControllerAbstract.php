<?php

namespace WateringSystem\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use WateringSystem\Model\SensorReadingModel;
use Zend\Log\Logger;
use Doctrine\ORM\EntityManager;
use WateringSystem\Model\SensorValueModel;
use WateringSystem\Model\SensorModel;

abstract class WateringSystemControllerAbstract extends AbstractActionController
{
	protected $entityManager;
	
	/**
	 * @return SensorReadingModel
	 */
	protected function getSensorReadingModel()
	{
		return $this->getServiceLocator()->get('SensorReadingModel');
	}
	
	/**
	 * @return Logger
	 */
	protected function getLogger()
	{
		return $this->getServiceLocator()->get('logger');
	}
	
	/**
	 * Log a message
	 * @param String $message
	 * @param String $priority
	 */
	protected function log($message, $priority = Logger::INFO)
	{
		$this->getLogger()->log($priority, $message);
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
	 * @return SensorModel
	 */
	protected function getSensorModel()
	{
		return $this->getServiceLocator()->get('SensorModel');
	}
	
	/**
	 * @return SensorValueModel
	 */
	protected function getSensorValueModel()
	{
		return $this->getServiceLocator()->get('SensorValueModel');
	}
}
