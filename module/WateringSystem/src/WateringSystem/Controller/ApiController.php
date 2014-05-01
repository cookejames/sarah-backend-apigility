<?php
namespace WateringSystem\Controller;

use Zend\View\Model\JsonModel;
use Zend\Mvc\MvcEvent;

class ApiController extends WateringSystemControllerAbstract
{
    public function fetchSensorValuesAction()
    {
    	$request = $this->getRequest();
    	if ($request->isPost() && $request->getPost('before', false)) {
    		try {
    			//get the maximum date
    			$before = $request->getPost('before');
    			$to = \DateTime::createFromFormat('Y-m-d H:i:s', $before);
    			if (!$to) {
    				throw new \Exception('invalid date format');
    			}
    			
    			$from = clone $to;
    			$from->sub(new \DateInterval('P1D'));
    			
    			$sensorValues = $this->getSensorValueModel()->getSensorValuesBetween($from, $to, 'ASC');
    			$helper = $this->getServiceLocator()->get('viewhelpermanager')->get('SensorToJson');
    			return new JsonModel(array('result' => $helper($sensorValues, true, false)));
    		} catch (\Exception $e) {
    			return new JsonModel(array('result' => false, 'message' => $e->getMessage()));
    		}
    		
    	}
    	return new JsonModel(array('result' => false));
    }
}
