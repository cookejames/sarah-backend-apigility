<?php

namespace WateringSystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * The value of a sensor at a particular time
 * @ORM\Entity
 * @ORM\Table(name="sensorValues")
 */
class SensorValue implements WateringSystemEntityInterface
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
	public function setSensor(Sensor $sensor) {
		$this->sensor = $sensor;
		return $this;
	}

	/**
	 * @return boolean|float|int|string
	 */
	public function getValue() {
		switch ($this->getSensor()->getValueType()) {
			case Sensor::TYPE_BOOLEAN:
				return (boolean) $this->value;
			case Sensor::TYPE_FLOAT:
				return (float) $this->value;
			case Sensor::TYPE_INT:
				return (int) $this->value;
			default:
				return $this->value;
		}
	}
	
	/**
	 * Get values with any calibration added
	 * @return boolean|float|int|string
	 */
	public function getCalibratedValue()
	{
		$value = $this->getValue();
		$calibration = $this->getSensor()->getCalibration();
		if (is_numeric($calibration) && (is_float($value) || is_int($value))) {
			$value += $calibration;
		}
		
		return $value;
	}
	
	/**
	 * Get the value scaled according to the scaling factor
	 * @return boolean|float|int|string
	 */
	public function getScaledValue() {
		if ($this->getSensor()->getValueType() == Sensor::TYPE_FLOAT 
			|| $this->getSensor()->getValueType() == Sensor::TYPE_INT) {
			$value = $this->getCalibratedValue();
			$value *= $this->getSensor()->getScalingFactor();
			
			if ($this->getSensor()->getValueType() == Sensor::TYPE_INT) {
				return (int) $value;
			} else {
				return $value;
			}
		}
	}

	/**
	 * @param field_type $value
	 */
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}

	/**
	 * @return \DateTime
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
