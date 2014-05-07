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
	public function __invoke(array $sensorValues, $useScaledValues = false, $returnEncoded = true)
	{
		$data = array();
		foreach ($sensorValues as $sensorValue) {
			if ($sensorValue instanceof SensorValue) {
				if (!isset($data[$sensorValue->getSensor()->getId()])) {
					$data[$sensorValue->getSensor()->getId()] = array(
						'name'			=> $sensorValue->getSensor()->getDescription(),
						'data'			=> array(),
						'scalingFactor'	=> $sensorValue->getSensor()->getScalingFactor(),
						'valueType'		=> $sensorValue->getSensor()->getValueType(),
						'units'			=> $sensorValue->getSensor()->getUnits(),
					);
				}
				
				$value = ($useScaledValues) ? $sensorValue->getScaledValue() : $sensorValue->getCalibratedValue();
				$data[$sensorValue->getSensor()->getId()]['data'][] = array(
					'x' => $sensorValue->getDate()->getTimestamp(),
					'y' => $value,
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
}
