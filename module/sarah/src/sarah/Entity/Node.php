<?php

namespace sarah\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * A node which is a collection of sensors
 * @ORM\Entity
 * @ORM\Table(name="nodes")
 */
class Node implements SarahEntityInterface
{
	/** 
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	private $id;
	/** @ORM\Column(length=255) */
	private $name;
	/** @ORM\Column(type="boolean") */
	private $isEnabled;
	/** @ORM\OneToMany(targetEntity="Sensor", mappedBy="node") **/
	private $sensors;
	
	public function __construct() {
		$this->sensors = new ArrayCollection();
	}
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	/**
	 * @return the $isEnabled
	 */
	public function getIsEnabled() {
		return $this->isEnabled;
	}

	/**
	 * @param field_type $isEnabled
	 */
	public function setIsEnabled($isEnabled) {
		$this->isEnabled = $isEnabled;
		return $this;
	}
	
	/**
	 * @return ArrayCollection $sensors
	 */
	public function getSensors() {
		return $this->sensors;
	}
	
	public function hydrate(array $data, $object)
	{
		
	}
	
	public function extract($object)
	{
		
	}
}
