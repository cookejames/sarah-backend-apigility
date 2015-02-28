<?php
namespace Sensors\V1\Rest\SensorValue;

use ZF\ApiProblem\ApiProblem;
use Sarah\Model\SensorValueModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Rest\AbstractResourceListener;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;

class SensorValueResource extends AbstractResourceListener
{
	/**
	 * @var SensorValueModel
	 */
	protected $model;
	
	/**
	 * @var HydratorInterface
	 */
	protected $hydrator;
	
	public function __construct(SensorValueModel $model, HydratorInterface $hydrator)
	{
		$this->model = $model;
		$this->hydrator = $hydrator;
	}
	
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
    	unset($data->id);
    	
    	$entityClass = $this->getEntityClass();
    	$entity = $this->hydrator->hydrate((array)$data, new $entityClass);
    	
    	try {
    		$this->model->saveEntity($entity);
    	} catch (\Exception $e) {
    		return new ApiProblem(400, 'Could not save data');
    	}
        
    	return $this->fetch($entity->getId());
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
    	$sensorValue = $this->model->getSensorValueById($id);
    	if (is_null($sensorValue)) {
    		return new ApiProblem(404, 'Sensor value with that id not found');
    	}
    	
    	return $sensorValue;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
    	//Validate the parameters
    	if (!is_numeric($params['from']) && !is_null($params['from'])) {
    		return new ApiProblem(400, 'Parameter from is not an integer');
    	}
    	if (!is_numeric($params['to']) && !is_null($params['to'])) {
    		return new ApiProblem(400, 'Parameter to is not an integer');
    	}
    	if (!is_array($params['sensors']) && !is_null($params['sensors'])) {
    		return new ApiProblem(400, 'Parameter sensors is not an array');
    	}
    	
    	$sensors = $params['sensors']; 
    	$from = \DateTime::createFromFormat('U', $params['from']);
    	$to = \DateTime::createFromFormat('U', $params['to']);
    	
    	$sensorValues = $this->model->paginateResults(true)->getSensorValuesBetween($from, $to, $sensors);
    	return new SensorValueCollection(new DoctrinePaginator($sensorValues));
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
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
