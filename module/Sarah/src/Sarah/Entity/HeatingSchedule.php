<?php

namespace Sarah\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * An individual heating schedule
 * @ORM\Entity
 * @ORM\Table(name="heatingSchedules")
 */
class HeatingSchedule implements SarahEntityInterface
{
	/** 
	 * @ORM\Id @ORM\Column(type="integer", options={"unsigned":true})
	 * @ORM\GeneratedValue
	 */
	private $id;
	/**
	 * @ORM\ManyToOne(targetEntity="HeatingGroup", inversedBy="schedules")
	 * @ORM\JoinColumn(name="`group`", referencedColumnName="id")
	 * */
	private $group;
	/** @ORM\Column(type="boolean", options={"unsigned":true}) */
	private $heatingOn;
	/** @ORM\Column(type="boolean", options={"unsigned":true}) */
	private $waterOn;
	/** @ORM\Column(type="integer", length=1, options={"unsigned":true}) */
	private $startHour;
	/** @ORM\Column(type="integer", length=1, options={"unsigned":true}) */
	private $startMin;
	/** @ORM\Column(type="integer", length=1, options={"unsigned":true}) */
	private $endHour;
	/** @ORM\Column(type="integer", length=1, options={"unsigned":true}) */
	private $endMin;	
	/** @ORM\Column(name="mon", type="boolean", options={"unsigned":true}) */
	private $monday;
	/** @ORM\Column(name="tue", type="boolean", options={"unsigned":true}) */
	private $tuesday;
	/** @ORM\Column(name="wed", type="boolean", options={"unsigned":true}) */
	private $wednesday;
	/** @ORM\Column(name="thu", type="boolean", options={"unsigned":true}) */
	private $thursday;
	/** @ORM\Column(name="fri", type="boolean", options={"unsigned":true}) */
	private $friday;
	/** @ORM\Column(name="sat", type="boolean", options={"unsigned":true}) */
	private $saturday;
	/** @ORM\Column(name="sun", type="boolean", options={"unsigned":true}) */
	private $sunday;
	/**
	 * @return the $id
	 */
	public function getId ()
	{
		return $this->id;
	}

	/**
	 * @return the $group
	 */
	public function getGroup ()
	{
		return $this->group;
	}

	/**
	 * @return the $heatingOn
	 */
	public function getHeatingOn ()
	{
		return $this->heatingOn;
	}

	/**
	 * @return the $waterOn
	 */
	public function getWaterOn ()
	{
		return $this->waterOn;
	}

	/**
	 * @return the $monday
	 */
	public function getMonday ()
	{
		return $this->monday;
	}

	/**
	 * @return the $tuesday
	 */
	public function getTuesday ()
	{
		return $this->tuesday;
	}

	/**
	 * @return the $wednesday
	 */
	public function getWednesday ()
	{
		return $this->wednesday;
	}

	/**
	 * @return the $thursday
	 */
	public function getThursday ()
	{
		return $this->thursday;
	}

	/**
	 * @return the $friday
	 */
	public function getFriday ()
	{
		return $this->friday;
	}

	/**
	 * @return the $saturday
	 */
	public function getSaturday ()
	{
		return $this->saturday;
	}

	/**
	 * @return the $sunday
	 */
	public function getSunday ()
	{
		return $this->sunday;
	}

	/**
	 * @param field_type $id
	 */
	public function setId ($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @param field_type $group
	 */
	public function setGroup ($group)
	{
		$this->group = $group;
		return $this;
	}

	/**
	 * @param field_type $heatingOn
	 */
	public function setHeatingOn ($heatingOn)
	{
		$this->heatingOn = $heatingOn;
		return $this;
	}

	/**
	 * @param field_type $waterOn
	 */
	public function setWaterOn ($waterOn)
	{
		$this->waterOn = $waterOn;
		return $this;
	}

	/**
	 * @param field_type $monday
	 */
	public function setMonday ($monday)
	{
		$this->monday = $monday;
		return $this;
	}

	/**
	 * @param field_type $tuesday
	 */
	public function setTuesday ($tuesday)
	{
		$this->tuesday = $tuesday;
		return $this;
	}

	/**
	 * @param field_type $wednesday
	 */
	public function setWednesday ($wednesday)
	{
		$this->wednesday = $wednesday;
		return $this;
	}

	/**
	 * @param field_type $thursday
	 */
	public function setThursday ($thursday)
	{
		$this->thursday = $thursday;
		return $this;
	}

	/**
	 * @param field_type $friday
	 */
	public function setFriday ($friday)
	{
		$this->friday = $friday;
		return $this;
	}

	/**
	 * @param field_type $saturday
	 */
	public function setSaturday ($saturday)
	{
		$this->saturday = $saturday;
		return $this;
	}

	/**
	 * @param field_type $sunday
	 */
	public function setSunday ($sunday)
	{
		$this->sunday = $sunday;
		return $this;
	}
	/**
	 * @return the $startHour
	 */
	public function getStartHour ()
	{
		return $this->startHour;
	}

	/**
	 * @return the $startMin
	 */
	public function getStartMin ()
	{
		return $this->startMin;
	}

	/**
	 * @return the $endHour
	 */
	public function getEndHour ()
	{
		return $this->endHour;
	}

	/**
	 * @return the $endMin
	 */
	public function getEndMin ()
	{
		return $this->endMin;
	}

	/**
	 * @param field_type $startHour
	 */
	public function setStartHour ($startHour)
	{
		$this->startHour = (int)$startHour;
		return $this;
	}

	/**
	 * @param field_type $startMin
	 */
	public function setStartMin ($startMin)
	{
		$this->startMin = (int)$startMin;
		return $this;
	}

	/**
	 * @param field_type $endHour
	 */
	public function setEndHour ($endHour)
	{
		$this->endHour = (int)$endHour;
		return $this;
	}

	/**
	 * @param field_type $endMin
	 */
	public function setEndMin ($endMin)
	{
		$this->endMin = (int)$endMin;
		return $this;
	}


}
