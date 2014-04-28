<?php

namespace WateringSystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * The value of a sensor at a particular time
 * @ORM\Entity
 * @ORM\Table(name="sensorValues")
 */
class SensorValue
{
	/** 
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	private $id;
	
	/** 
	 * @ORM\ManyToOne(targetEntity="Sensor")
     * @ORM\JoinColumn(name="sensor", referencedColumnName="id") 
	 * */
	private $sensor;
	/** @ORM\Column(length=255) */
	private $value;
	/** @ORM\Column(type="datetime") */
	private $date;
	
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
	 * @return Sensor
	 */
	public function getSensor() {
		return $this->sensor;
	}

	/**
	 * @param Sensor $sensor
	 */
	public function setSensor($sensor) {
		$this->sensor = $sensor;
		return $this;
	}

	/**
	 * @return the $value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param field_type $value
	 */
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param field_type $date
	 */
	public function setDate($date) {
		$this->date = $date;
		return $this;
	}

}
