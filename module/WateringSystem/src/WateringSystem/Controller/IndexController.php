<?php
namespace WateringSystem\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends WateringSystemControllerAbstract
{
    public function indexAction()
    {
    	$date = new \DateTime();
    	$date->sub(new \DateInterval('P1D'));

        return new ViewModel(
        		array(
        				'sensors' => $this->getSensorModel()->getSensors(),
        				'sensorValues' => $this->getSensorValueModel()->getSensorValuesSince($date, 'ASC'),
        		)
        );
    }
}
