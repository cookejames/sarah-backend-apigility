<?php

namespace WateringSystem\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WateringSystem\Entity\Sensor;
use WateringSystem\Entity\SensorValue;
use Doctrine\ORM\EntityManager;

class SensorToJsonHelper extends AbstractHelper implements ServiceLocatorAwareInterface 
{
	public function __invoke()
	{
		return $this;
	}
	
	/**
	 * @param Sensor[] $sensor
	 * @param SensorValue[] $sensorValues
	 */
	public function getGraphData(array $sensorValues, $returnEncoded = true)
	{
		$data = array();
		foreach ($sensorValues as $sensorValue) {
			if ($sensorValue instanceof SensorValue) {
				if (!isset($data[$sensorValue->getSensor()->getId()])) {
					$sensor = $sensorValue->getSensor();
					$this->getEntityManager()->initializeObject($sensor);
					$data[$sensorValue->getSensor()->getId()] = $sensor->toArray();
					$data[$sensorValue->getSensor()->getId()]['data'] = array();
				}
				
				$data[$sensorValue->getSensor()->getId()]['data'][] = array(
						'x' => $sensorValue->getDate()->getTimestamp(),
						'y' => $sensorValue->getCalibratedValue(),
				);
			}
		}
		//do this to get an array rather than object references
		$json = array();
		foreach ($data as $sensor) {
			$json[] = $sensor;
		}
		return ($returnEncoded) ? json_encode($json) : $json;
	}
	
	/**
	 * Get an array of sensor details with the last calibrated sensor value
	 * @param unknown $sensors
	 * @param string $returnEncoded
	 * @return Ambigous <string, multitype:string >
	 */
	public function getSensorValuesJson($sensors, $returnEncoded = true)
	{
		$data = array();
		foreach ($sensors as $sensor) {
			if (!$sensor instanceof Sensor) continue;
			$array = $sensor->toArray();
			$sensorValueHelper = $this->getView()->plugin('SensorValue');
			$sensorValue = $sensorValueHelper()->lastValue($sensor);
			if ($sensorValue instanceof SensorValue) {
				switch ($sensorValue->getSensor()->getValueType()) {
					case Sensor::TYPE_BOOLEAN :
						$value = $sensorValue->getValue() ? 'On' : 'Off';
						break;
					default:
						$value = $sensorValue->getCalibratedValue();
						break;
				}
				
				$timestamp = $sensorValue->getDate()->getTimestamp();
			}
			$array['value'] = $value;
			$array['timestamp'] = $timestamp;
			$data[] = $array;
		}
		
		return ($returnEncoded) ? json_encode($data) : $data;
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
	
	/**
	 * @return EntityManager
	 */
	protected function getEntityManager()
	{
		return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	}
}
