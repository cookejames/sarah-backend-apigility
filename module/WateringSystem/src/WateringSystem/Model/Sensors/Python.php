<?php

namespace WateringSystem\Model\Sensors;

class Python extends SensorAbstract 
{
	/** path to the python script */
	protected $script;
	
	public function __construct(array $parameters)
	{
		parent::__construct($parameters);
		if (isset($parameters['Python']['script'])) {
			$this->script = $parameters['Python']['script'];
		}
		if (!file_exists($this->script)) {
			throw new \Exception('Could not find script');
		}
		//add port to command
		$this->script .= ' -p ' . $this->port;
	}
	
	public function sendMessage($message) 
	{
		exec($this->script . ' -m "' . $message . '"');
	}
	public function readMessage() 
	{
		$result = exec($this->script);
		return $result;
	}
}

?>