<?php
namespace WateringSystem\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends WateringSystemControllerAbstract
{
    public function indexAction()
    {
    	$from = new \DateTime();
    	$from->sub(new \DateInterval('P1D'));
    	$to = new \DateTime();
    	
        return new ViewModel(
        		array(
        				'sensors' => $this->getSensorModel()->getSensors(),
        				'sensorValues' => $this->getSensorValueModel()->getSensorValuesBetween($from, $to, 'ASC'),
        		)
        );
    }
}
