<?php
namespace WateringSystem\Controller;

use Zend\View\Model\JsonModel;
use Zend\Mvc\MvcEvent;
use WateringSystem\Entity\Sensor;
use WateringSystem\Entity\SensorValue;
use WateringSystem\Entity\Node;

class ApiController extends WateringSystemControllerAbstract
{
	protected $pumpSensorName = 'p1';
	/**
	 * Get the sensor values for 1 day before the specified date
	 * @param 'before' format 'Y-m-d H:i:s'
	 * @throws \Exception
	 * @return \Zend\View\Model\JsonModel
	 */
    public function fetchSensorValuesAction()
    {
    	$request = $this->getRequest();
    	if ($request->isPost() && $request->getPost('node', false)
    			 && $request->getPost('from', false) && $request->getPost('to', false)) {
    		try {
    			//get the maximum date
    			$fromTimestamp = $request->getPost('from');
    			$toTimestamp = $request->getPost('to');
    			$nodeId = $request->getPost('node');
    			
    			$to = \DateTime::createFromFormat('U', $toTimestamp);
    			$from = \DateTime::createFromFormat('U', $fromTimestamp);
    			if (!$to || !$to) {
    				throw new \Exception('invalid date format');
    			}
    			
    			$node = $this->getNodeModel()->getNodeById($nodeId);
    			if (!$node instanceof Node) {
    				throw new \Exception('invalid node id');
    			}
    			
    			$sensorValues = $this->getSensorValueModel()->getSensorValuesBetween($from, $to, $node, 'ASC');
    			$helper = $this->getServiceLocator()->get('viewhelpermanager')->get('SensorToJson');
    			return new JsonModel(array(
    					'result'	=> $helper()->getGraphData($sensorValues, false),
    					'from'		=> $fromTimestamp,
    					'to'		=> $toTimestamp,
    					'node'		=> $nodeId
    			));
    		} catch (\Exception $e) {
    			return new JsonModel(array('result' => false, 'message' => $e->getMessage()));
    		}
    		
    	}
    	return new JsonModel(array('result' => false));
    }
    
    /**
     * Turn the pump on
     * @return \Zend\View\Model\JsonModel
     */
    public function turnPumpOnAction()
    {
    	$request = $this->getRequest();
    	if ($request->isPost() && $request->getPost('pumpon', false)) {
    		try {
	    		$this->getPumpModel()->turnPumpOn();
	    		$pump = $this->getSensorModel()->getSensorByName($this->pumpSensorName);
	    		if ($pump instanceof Sensor) {
	    			$value = new SensorValue();
	    			$value->setValue(true)
	    				  ->setSensor($pump);
	    			$this->saveEntity($value);
	    		}
	    		return new JsonModel(array('result' => true));
    		} catch (\Exception $e) {
    			return new JsonModel(array('result' => false));
    		}
    	}
    }
}
