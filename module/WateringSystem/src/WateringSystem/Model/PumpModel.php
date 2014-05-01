<?php

namespace WateringSystem\Model;

use WateringSystem\Model\Sensors\SensorAbstract;
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
	}

}