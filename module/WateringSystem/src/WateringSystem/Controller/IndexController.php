<?php
namespace WateringSystem\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends WateringSystemControllerAbstract
{
    public function indexAction()
    {
    	try {
    		$readings = $this->getSensorReadingModel()->getSensorReadings();
    	} catch (\Exception $e) {
    		$readings = false;
    		$this->flashMessenger()->addErrorMessage($e->getMessage());
    	}
    	
        return new ViewModel(array('sensorReadings' => $readings));
    }
}
