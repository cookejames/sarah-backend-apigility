<?php

namespace WateringSystem\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WateringSystem\Entity\Sensor;
use WateringSystem\Model\SensorValueModel;

class SensorValueHelper extends AbstractHelper implements ServiceLocatorAwareInterface 
{
	protected $serviceLocator;
	/**
	 * @var SensorValueModel
	 */
	protected $sensorValueModel;
	
	public function __invoke()
	{
		$this->sensorValueModel = $this->getServiceLocator()->get('SensorValueModel');
		return $this;
	}
	
	public function lastValue(Sensor $sensor)
	{
		return $this->sensorValueModel->getLastValue($sensor->getId());
	}
	
	public function lastDaysValues($node)
	{
		$from = new \DateTime();
		$from->sub(new \DateInterval('P1D'));
		$to = new \DateTime();
		return $this->sensorValueModel->getSensorValuesBetween($from, $to, $node, 'ASC');
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
