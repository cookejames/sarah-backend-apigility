<?php
namespace Sarah\Factory\Model;

use Sarah\Model\WeatherModel;

class WeatherModelFactory extends AbstractModelFactory
{
	/* (non-PHPdoc)
	 * @see \Sarah\Factory\Model\AbstractModelFactory::getModel()
	 */
	protected function getModel ()
	{
		$config = $this->getServiceLocator()->get('Config');
		if (isset($config['weather'])) {
			return new WeatherModel($config['weather']);
		} else {
			throw new \Exception('Could not find config item weather');
		}
	}

}