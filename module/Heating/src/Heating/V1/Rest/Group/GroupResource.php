<?php
namespace Heating\V1\Rest\Group;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Sarah\Model\HeatingGroupModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Stdlib\Hydrator\HydratorAwareInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Sarah\Entity\HeatingGroup;

class GroupResource extends AbstractResourceListener implements HydratorAwareInterface
{
	/**
	 * @var HeatingGroupModel
	 */
	private $heatingGroupModel;
	/**
	 * @var HydratorInterface
	 */
	private $hydrator;
	
	public function __construct(HeatingGroupModel $heatingGroupModel)
	{
		$this->heatingGroupModel = $heatingGroupModel;
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
    	$this->heatingGroupModel->saveEntity($entity);
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
    	$group = $this->heatingGroupModel->getHeatingGroupById($id);
    	if (is_null($group)) {
    		return new ApiProblem(404, 'Heating group with that id not found');
    	}
    	$this->heatingGroupModel->removeEntity($group);
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
        $group = $this->heatingGroupModel->getHeatingGroupById($id);
    	if (is_null($group)) {
    		return new ApiProblem(404, 'Heating group with that id not found');
    	}
    	
    	return $group;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $heatingGroups = $this->heatingGroupModel->paginateResults(true)->getHeatingGroups();
        return new GroupCollection(new DoctrinePaginator($heatingGroups));
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
    	$entity = $this->heatingGroupModel->getHeatingGroupById($id);
    	if (!$entity instanceof HeatingGroup) {
    		return new ApiProblem(404, 'Heating group not found');
    	}
        $values = $this->getInputFilter()->getValues();
        unset($values['id']);
    	$entity = $this->hydrator->hydrate($values, $entity);
    	$this->heatingGroupModel->saveEntity($entity);
    	return $entity;
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
