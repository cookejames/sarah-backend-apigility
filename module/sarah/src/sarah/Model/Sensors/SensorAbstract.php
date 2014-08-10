<?php

namespace sarah\Model\Sensors;

/**
 * An abstract for different methods which interface with sensors
 * @author James Cooke
 *
 */
abstract class SensorAbstract
{
	protected $port;
	/** time to wait for a response when reading from serial port*/
	protected $timeout = 2;
	/** carriage return character */
	protected $carriageReturn = '\n';
	
	public function __construct(array $parameters)
	{
		if (!isset($parameters['port']) || !is_string($parameters['port'])) {
			throw new \Exception('Sensor port must be set');
		} else {
			$this->port = $parameters['port'];
		}
	
		if (isset($parameters['timeout']) && is_numeric($parameters['timeout'])) {
			$this->timeout = (int) $parameters['timeout'];
		}
	
		if (isset($parameters['bytesToRead']) && is_numeric($parameters['bytesToRead'])) {
			$this->bytesToRead = (int) $parameters['bytesToRead'];
		}
	
		if (isset($parameters['carriageReturn'])) {
			$this->carriageReturn = $parameters['carriageReturn'];
		}
	}
	
	/**
	 * Read a message from the sensors
	 * @return String the message
	 */
	abstract function readMessage();
	
	/**
	 * Send a message to the sensors
	 * @param String $message
	 */
	abstract function sendMessage($message);
}

?>