<?php

namespace WateringSystem\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use WateringSystem\Model\SensorReadingModel;
use Zend\Log\Logger;

abstract class WateringSystemControllerAbstract extends AbstractActionController
{
	/**
	 * @return SensorReadingModel
	 */
	public function getSensorReadingModel()
	{
		return $this->getServiceLocator()->get('SensorReadingModel');
	}
	
	/**
	 * @return Logger
	 */
	public function getLogger()
	{
		return $this->getServiceLocator()->get('logger');
	}
	
	/**
	 * Log a message
	 * @param String $message
	 * @param String $priority
	 */
	public function log($message, $priority = Logger::INFO)
	{
		$this->getLogger()->log($priority, $message);
		return $this;
	}
}
