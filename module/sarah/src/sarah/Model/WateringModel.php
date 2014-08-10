<?php

namespace sarah\Model;

use sarah\Entity\Sensor;
use sarah\Entity\SensorValue;
/**
 * Determines whether the plants should be watered
 * @author James Cooke
 *
 */
class WateringModel extends WateringSystemModelAbstract 
{	
	protected $hysterisis;
	
	/**
	 * 
	 * @param int $hysterisis the number of seconds since pump last run 
	 * 							until it is eligable to run again
	 */
	public function __construct($hysterisis = 3600)
	{
		$this->hysterisis = (int) $hysterisis;
	}
	
	/**
	 * Should a pump activate based on hysterisis and sensor values
	 * @param Sensor $pump
	 * @param array $sensorValues
	 * @return boolean
	 */
	public function shouldPumpActivate(Sensor $pump, array $sensorValues)
	{
		if ($this->isPumpInHysterisisPeriod($pump)) {
			$this->log('Should not activate pump, it is in hysterisis period');
			return false;
		}
		
		$errors = false;
		$shouldActivate = false;
		//iterate through sensor values and check if below the lower threshold 
		//and not above the upper threshold
		foreach ($sensorValues as $sensorValue) {
			if ($sensorValue instanceof SensorValue) {
				if ($sensorValue->getSensor()->getIsWateringSensor()) {
					$lower = $sensorValue->getSensor()->getWateringThresholdLower();
					$upper = $sensorValue->getSensor()->getWateringThresholdUpper();
					
					//if below the lower threshold we should activate
					if (!is_null($lower) && $sensorValue->getCalibratedValue() < $lower) {
						$shouldActivate = true;
					}
					
					//if above the upper threshold we should never activate
					if (!is_null($upper) && $sensorValue->getCalibratedValue() > $upper) {
						$this->log('Sensor ' . $sensorValue->getSensor()->getDescription() . ' value ' 
							. $sensorValue->getCalibratedValue() . ' is above upper threshold ' . $upper);
						$errors = true;
					}
				}
			} else {
				$this->log('Variable is not a sensor value: ' . print_r($sensorValue, true));
			}
		}
		
		return (!$errors && $shouldActivate);
	}
	
	/**
	 * Was the pumps last activation time less that the hysterisis period?
	 * @param Sensor $pump
	 */
	protected function isPumpInHysterisisPeriod(Sensor $pump)
	{
		$sensorValueModel = $this->getServiceLocator()->get('SensorValueModel');
		
		//Get the last pumpvalue if we don't get one the pump hasn't run before
		$pumpValue = $sensorValueModel->getLastValue($pump->getId(), true);
		if (!$pumpValue instanceof SensorValue) {
			return false;
		}
		
		$now = new \DateTime();
		$lastRun = $pumpValue->getDate();

		$seconds = $now->getTimestamp() - $lastRun->getTimestamp();
		
		return $seconds < $this->hysterisis;
	}
}