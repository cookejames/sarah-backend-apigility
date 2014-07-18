<?php

namespace WateringSystem\View\Helper;

use Zend\View\Helper\AbstractHelper;
use WateringSystem\Entity\Sensor;
use WateringSystem\Entity\SensorValue;

class SensorToJsonHelper extends AbstractHelper
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
					$data[$sensorValue->getSensor()->getId()] = array(
							'name'			=> $sensorValue->getSensor()->getDescription(),
							'data'			=> array(),
							'graphStart'		=> $sensorValue->getSensor()->getGraphStart(),
							'valueType'		=> $sensorValue->getSensor()->getValueType(),
							'units'			=> $sensorValue->getSensor()->getUnits(),
					);
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
}
