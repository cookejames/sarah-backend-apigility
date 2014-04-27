<?php
namespace WateringSystem\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends WateringSystemControllerAbstract
{
    public function indexAction()
    {
    	$readings = $this->getSensorReadingModel()->getSensorReadings();
        return new ViewModel(array('sensorReadings' => $readings));
    }
}
