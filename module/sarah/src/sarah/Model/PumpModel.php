<?php

namespace sarah\Model;

use sarah\Model\Sensors\SensorAbstract;
/**
 * Perform pump actions
 * @author James Cooke
 *
 */
class PumpModel extends WateringSystemModelAbstract 
{
	/** @var SensorAbstract */
	protected $sensor;
	
	public function __construct(SensorAbstract $sensor)
	{
		$this->sensor = $sensor;
	}
	
	/**
	 * Get sensor readings
	 * @throws \Exception
	 */
	public function turnPumpOn()
	{
		//send the status message
		$this->sensor->sendMessage('pumpon');
		$this->log('Turning pump on');
		return true;
	}
	
	/**
	 * Get the pump as specified in the config file
	 * @return Ambigous <NULL, \sarah\Entity\Sensor, object>
	 */
	public function getPumpFromConfig()
	{
		$config = $this->getServiceLocator()->get('config');
		 
		$pump = null;
		 
		if (isset($config['watering']) && isset($config['watering']['pumpName'])) {
			$pumpName = $config['watering']['pumpName'];
			$sensorModel = $this->getServiceLocator()->get('SensorModel');
			$pump = $sensorModel->getSensorByName($pumpName);
		}
		 
		return $pump;
	}

}