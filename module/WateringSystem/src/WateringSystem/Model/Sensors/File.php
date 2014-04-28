<?php

namespace WateringSystem\Model\Sensors;

class File extends SensorAbstract
{
	/** number of bytes to read at a time */
	protected $bytesToRead = 128;
	
	public function __construct(array $parameters)
	{
		parent::__construct($parameters);
		if (isset($parameters['File']['bytesToRead']) && is_numeric($parameters['File']['bytesToRead'])) {
			$this->bytesToRead = (int) $parameters['File']['bytesToRead'];
		}
	}
	/**
	 * Get a file pointer to the serial port
	 * @return filepointer|false false if cannot open
	 */
	protected function getPointer()
	{
		$pointer = @fopen($this->port, "w+");
		if ($pointer === false) {
			throw new \Exception('Could not open serial port');
		}
		return $pointer;
	}
	
	/**
	 * Read from the serial port for a maximum of $this->readWait seconds 
	 * or until we receive a carriage return (\r\n)
	 * @param unknown $pointer
	 * @return string
	 */
	public function readMessage()
	{
		$pointer = $this->getPointer();
		$message = '';
		$startTime = time();

		while (time() < $startTime + $this->timeout) {
			$bytes = @fread($pointer, $this->bytesToRead);
			if (($pos = strpos($bytes, $this->carriageReturn)) == true) {
				$split = explode($this->carriageReturn, $bytes);
				$bytes = $split[0];
			}
			$message .= $bytes;
			if ($pos) {
				break;
			}
			usleep(100);
		}
		$this->log('Read sensor message: ' . $message);
		$this->close($pointer);
		return $message;
	}
	
	/**
	 * Close the pointer
	 * @param unknown $pointer
	 * @return boolean
	 */
	protected function close($pointer)
	{
		@fclose($pointer);
		return true;
	}
	
	/**
	 * Send a message to the serial port
	 * @param unknown $pointer
	 * @param String $message
	 * @return boolean
	 */
	function sendMessage($message)
	{
		$pointer = $this->getPointer();
		$result = @fwrite($pointer, $message);
		$this->close($pointer);
		return ($result !== false);
	}
}

?>