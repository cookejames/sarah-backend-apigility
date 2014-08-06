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
    public function getSensorValuesAction()
    {
    	$request = $this->getRequest();
    	if ($request->isGet() && $request->getQuery('node', false)
    			 && $request->getQuery('from', false) && $request->getQuery('to', false)) {
    		try {
    			//get the maximum date
    			$fromTimestamp = $request->getQuery('from');
    			$toTimestamp = $request->getQuery('to');
    			$nodeId = $request->getQuery('node');
    			
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
    			$array = array();
    			foreach ($sensorValues as $sensorValue) {
    				$array[] = array(
    					'id'			=> $sensorValue->getId(),
    					'sensor'		=> $sensorValue->getSensor()->getId(),
    					'timestamp'		=> $sensorValue->getDate()->getTimestamp(),
    					'value'			=> $sensorValue->getCalibratedValue(),
    					'rawValue'		=> $sensorValue->getValue(),
    					'isCalibrated'	=> true
    				);
    			}
    			return new JsonModel(array('_embeded' => $array	
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
    
    public function getNodesAction()
    {
    	$nodes = $this->getNodeModel()->getNodes();
    	$array = array();
    	foreach ($nodes as $node) {
    		$array[] = array(
    			'id'		=> $node->getId(),
    			'name'		=> $node->getName(),
    			'isEnabled'	=> $node->getIsEnabled()
    		);
    	}
    	return new JsonModel(array('_embeded' => $array
    	));
    }
    
    public function getSensorsAction()
    {
//     	$request = $this->getRequest();
//     	if ($request->isPost() && $request->getPost('node', false)) {
    		$sensors = $this->getSensorModel()->getSensors();
    		$array = array();
    		foreach ($sensors as $sensor) {
    			$array[] = $sensor->toArray();
    		}
    		return new JsonModel(array('_embeded' => $array
    		));
//     	}
    			
    }
}
