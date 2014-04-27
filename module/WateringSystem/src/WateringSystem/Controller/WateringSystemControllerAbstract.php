<?php

namespace WateringSystem\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use WateringSystem\Model\SensorReadingModel;

abstract class WateringSystemControllerAbstract extends AbstractActionController
{
	/**
	 * @return SensorReadingModel
	 */
	public function getSensorReadingModel()
	{
		return $this->getServiceLocator()->get('SensorReadingModel');
	}
}
