<?php

namespace WateringSystem\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * A helper with convenience methods for counting
 * 
 * @author James Cooke
 *
 */
class CounterHelper extends AbstractHelper 
{
	private $elements = array();
	
	public function __invoke()
	{
		return $this;
	}
	
	/**
	 * Get an elements counter, initialises it to 0 if
	 * it doesn't exist already
	 * @param string $name
	 * @return int:
	 */
	private function getElement($name)
	{
		if (!isset($this->elements[$name])) {
			$this->elements[$name] = 0;
		}
		
		return $this->elements[$name];
	}
	
	/**
	 * Increment an elements counter
	 * @param unknown $name
	 */
	private function increment($name)
	{
		$this->elements[$name]++;
	}
	
	/**
	 * Is this element the first of this name? 
	 * @param string $name
	 * @return boolean
	 */
	public function isFirst($name = '')
	{
		$element = $this->getElement($name);
		
		$first = false;
		if ($element === 0) {
			$first = true;
		}
		
		$this->increment($name);
		return $first;
	}
	
	private function isNthInColumn($name, $columns, $n)
	{
		$element = $this->getElement($name);
		
		$nth = false;
		if ($element % $columns == $n) {
			$nth = true;
		}
		
		$this->increment($name);
		return $nth;
	}

	public function isLastInColumn($name = '', $columns = 0)
	{
		return $this->isNthInColumn($name, $columns, $columns - 1);
	}
	
	public function isFirstInColumn($name = '', $columns = 0)
	{
		return $this->isNthInColumn($name, $columns, 0);
	}
}
