<?php

namespace Sarah\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * A heating group
 * @ORM\Entity
 * @ORM\Table(name="heatingGroups")
 */
class HeatingGroup implements SarahEntityInterface
{
	/** 
	 * @ORM\Id @ORM\Column(type="integer", options={"unsigned":true})
	 * @ORM\GeneratedValue
	 */
	private $id;
	/** @ORM\Column(length=255) */
	private $name;
	/** @ORM\Column(type="boolean") */
	private $isEnabled;
	/** @ORM\OneToMany(targetEntity="HeatingSchedule", mappedBy="group") **/
	private $schedules;
	
	public function __construct() {
		$this->schedules = new ArrayCollection();
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
	 * @return ArrayCollection $schedules
	 */
	public function getSchedules() {
		return $this->schedules;
	}
}
