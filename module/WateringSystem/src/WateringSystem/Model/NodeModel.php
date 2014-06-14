<?php

namespace WateringSystem\Model;

use WateringSystem\Model\WateringSystemModelAbstract;
use WateringSystem\Entity\Node;

/**
 * Get details about node
 * @author James Cooke
 *
 */
class NodeModel extends WateringSystemModelAbstract 
{
	protected $repository = 'WateringSystem\Entity\Node';
	
	/**
	 * Get all sensors
	 * @return Node[]
	 */
	public function getNodes()
	{
		return $this->getRepository()->findBy(array('isEnabled' => true), array('name' => 'asc'));
	}
	
	/**
	 * Get a node by its id
	 * @param int $id
	 * @return Node
	 */
	public function getNodeById($id)
	{
		return $this->getRepository()->find($id);
	}
	
	/**
	 * Get a node by its name
	 * @param String $name
	 * @return Node
	 */
	public function getNodeByName($name)
	{
		return $this->getRepository()->findOneBy(array('name' => $name));
	}
}