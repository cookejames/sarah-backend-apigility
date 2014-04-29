<?php

namespace WateringSystem\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WateringSystem\Entity\Sensor;
use WateringSystem\Entity\SensorValue;

class SensorToJsonHelper extends AbstractHelper 
{
	/**
	 * @param Sensor[] $sensor
	 * @param SensorValue[] $sensorValues
	 */
	public function __invoke(array $sensorValues, $useScaledValues = false)
	{
		$data = array();
		foreach ($sensorValues as $sensorValue) {
			if ($sensorValue instanceof SensorValue) {
				if (!isset($data[$sensorValue->getSensor()->getId()])) {
					$data[$sensorValue->getSensor()->getId()] = array(
						'name' => $sensorValue->getSensor()->getDescription(),
						'data' => array(),
					);
				}
				
				$value = ($useScaledValues) ? $sensorValue->getScaledValue() : $sensorValue->getValue();
				$data[$sensorValue->getSensor()->getId()]['data'][] = array(
					'x' => $sensorValue->getDate()->getTimestamp(),
					'y' => (int) $value,
				);
			}
		}
		//do this to get an array rather than object references
		$json = array();
		foreach ($data as $sensor) {
			$json[] = $sensor;
		}
		return json_encode($json);
	}
}
