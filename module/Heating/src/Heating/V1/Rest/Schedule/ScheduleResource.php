<?php
namespace Heating\V1\Rest\Schedule;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Sarah\Model\HeatingScheduleModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Stdlib\Hydrator\HydratorAwareInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Sarah\Entity\HeatingSchedule;

class ScheduleResource extends AbstractResourceListener implements HydratorAwareInterface
{
	/**
	 * @var HeatingScheduleModel
	 */
	private $heatingScheduleModel;
	/**
	 * @var HydratorInterface
	 */
	private $hydrator;
	
	public function __construct(HeatingScheduleModel $heatingScheduleModel)
	{
		$this->heatingScheduleModel = $heatingScheduleModel;
	}
	
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
    	$class = $this->getEntityClass();
    	$entity = $this->hydrator->hydrate($this->getInputFilter()->getValues(), new $class);
    	$this->heatingScheduleModel->saveEntity($entity);
    	return $entity;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
    	$schedule = $this->heatingScheduleModel->getHeatingScheduleById($id);
    	if (is_null($schedule)) {
    		return new ApiProblem(404, 'Heating schedule with that id not found');
    	}
    	$this->heatingScheduleModel->removeEntity($schedule);
    	return true;
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $schedule = $this->heatingScheduleModel->getHeatingScheduleById($id);
    	if (is_null($schedule)) {
    		return new ApiProblem(404, 'Heating schedule with that id not found');
    	}
    	
    	return $schedule;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $schedules = $this->heatingScheduleModel->paginateResults(true)->getHeatingSchedules();
        return new ScheduleCollection(new DoctrinePaginator($schedules));
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
    	$entity = $this->heatingScheduleModel->getHeatingScheduleById($id);
    	if (!$entity instanceof HeatingSchedule) {
    		return new ApiProblem(404, 'Heating schedule not found');
    	}
        $values = $this->getSetValues($data);
        unset($values['id']);
    	$entity = $this->hydrator->hydrate($values, $entity);
    	
    	if (!$this->isValidStartAndEndTime($entity->getStartHour(), $entity->getStartMin(), $entity->getEndHour(), $entity->getEndMin())) {
    		return new ApiProblem(422, 'Failed Validation', null, null, array(
    			'validation_messages' => array('time' => array('invalidStartEndTime' => 'The start time must be before the end time')),
    		));
    	}
    	
    	$this->heatingScheduleModel->saveEntity($entity);
    	return $entity;
    }
    
    /**
     * Check if the start time is before the end time
     * @param unknown $startHour
     * @param unknown $startMin
     * @param unknown $endHour
     * @param unknown $endMin
     * @return boolean
     */
    private function isValidStartAndEndTime($startHour, $startMin, $endHour, $endMin)
    {
    	$start = $startHour * 60 + $startMin;
    	$end = $endHour * 60 + $endMin;
    	
    	return $start < $end;
    }
    
    private function getSetValues($data)
    {
    	$setValues = array();
    	
    	foreach ($data as $key => $value) {
    		$setValues[$key] = $this->getInputFilter()->getValue($key);
    	}
    	
    	return $setValues;
    }
    
    /* (non-PHPdoc)
     * @see \Zend\Stdlib\Hydrator\HydratorAwareInterface::getHydrator()
    */
    public function getHydrator ()
    {
    	return $this->hydrator;
    }
    
    /* (non-PHPdoc)
     * @see \Zend\Stdlib\Hydrator\HydratorAwareInterface::setHydrator()
    */
    public function setHydrator (\Zend\Stdlib\Hydrator\HydratorInterface $hydrator)
    {
    	$this->hydrator = $hydrator;
    }
}
