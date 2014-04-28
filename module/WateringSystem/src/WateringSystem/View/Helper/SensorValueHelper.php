<?php

namespace WateringSystem\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WateringSystem\Entity\Sensor;

class SensorValueHelper extends AbstractHelper implements ServiceLocatorAwareInterface 
{
	protected $serviceLocator;
	
	public function __invoke(Sensor $sensor)
	{
		$sensorValueModel = $this->getServiceLocator()->get('SensorValueModel');
		return $sensorValueModel->getLastValue($sensor->getId());
	}
	
	/**
	 * Set service locator
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	
		return $this;
	}
	
	/**
	 * Get service locator
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator() {
		return $this->serviceLocator->getServiceLocator();
	}
}
