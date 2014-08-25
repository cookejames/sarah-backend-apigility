<?php
namespace sarah\V1\Rest\Sensor;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use sarah\Model\SensorModel;
use Zend\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginator;
use sarah\Rest\SarahAbstractResourceListener;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Doctrine\ORM\Query;
use sarah\Paginator\DoctrineHydratingArrayAdapter;

class SensorResource extends SarahAbstractResourceListener
{
	/**
	 * @var SensorModel
	 */
	protected $model;
	
	public function __construct(SensorModel $model, HydratorInterface $hydrator = null, $prototype = null)
	{
		parent::__construct($model, $hydrator, $prototype);
		$this->model->setHydrationMode(Query::HYDRATE_SCALAR);
	}
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
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
        $obj = $this->model->getSensorById($id);
        return $obj;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
    	if (!is_array($params['nodes']) && !is_null($params['nodes'])) {
    		return new ApiProblem(400, 'Parameter nodes is not an array');
    	}

    	$nodes = $params['nodes'];

    	$sensors = $this->model->getSensors();
    	return new SensorCollection(new DoctrineHydratingArrayAdapter($sensors, $this->hydrator, $this->prototype));
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
