<?php

namespace WateringSystem\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of an individual sensor
 * @ORM\Entity
 * @ORM\Table(name="sensors")
 */
class Sensor implements WateringSystemEntityInterface
{
	/** 
	 * @ORM\Id @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	private $id;
	/** @ORM\Column(length=255) */
	private $name;
	/**
	 * @ORM\ManyToOne(targetEntity="Node", inversedBy="sensors")
	 * @ORM\JoinColumn(name="node", referencedColumnName="id")
	 * */
	private $node;
	/** @ORM\Column(length=255, unique=true) */
	private $description;
	/** @ORM\Column(length=255) */
	private $valueType;
	/** @ORM\Column(length=255, nullable=true) */
	private $units;
	/** this will be the multiple to convert an int to a float
	 *  eg 0.01 to convert a sensor reading from 10000 to 100.00 
	 * @ORM\Column(type="float") */
	private $conversionFactor;
	/** @ORM\Column(type="boolean") */
	private $isRanged;
	/** @ORM\Column(type="float") */
	private $rangeMin;
	/** @ORM\Column(type="float") */
	private $rangeMax;
	/** @ORM\Column(type="float") */
	private $calibration;
	/** @ORM\Column(type="float") */
	private $graphStart;
	/** @ORM\Column(type="boolean") */
	private $isEnabled;
	/** is this sensor used to determine if we will trigger the watering 
	 * @ORM\Column(type="boolean") */
	private $isWateringSensor;
	/** @ORM\Column(type="float") */
	private $wateringThresholdLower;
	/** @ORM\Column(type="float") */
	private $wateringThresholdUpper;
	
	/** Valid value types */
	const TYPE_BOOLEAN	= 'boolean';
	const TYPE_FLOAT	= 'float';
	const TYPE_INT		= 'int';
	const TYPE_STRING	= 'string';
	public static $VALUE_TYPES = array(self::TYPE_BOOLEAN, self::TYPE_FLOAT, self::TYPE_INT, self::TYPE_STRING);
	
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
	 * @return the $name
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
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param field_type $description
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return the $valueType
	 */
	public function getValueType() {
		return $this->valueType;
	}

	/**
	 * @param field_type $valueType
	 */
	public function setValueType($valueType) {
		if (!in_array($valueType, self::$VALUE_TYPES)) {
			throw new \Exception('Invalid value type');
		}
		$this->valueType = $valueType;
		return $this;
	}

	/**
	 * @return the $units
	 */
	public function getUnits() {
		return $this->units;
	}

	/**
	 * @param field_type $units
	 */
	public function setUnits($units) {
		$this->units = $units;
		return $this;
	}

	/**
	 * @return the $isRanged
	 */
	public function getIsRanged() {
		return $this->isRanged;
	}

	/**
	 * @param field_type $isRanged
	 */
	public function setIsRanged($isRanged) {
		$this->isRanged = $isRanged;
		return $this;
	}

	/**
	 * @return the $rangeMin
	 */
	public function getRangeMin() {
		return $this->rangeMin;
	}

	/**
	 * @param field_type $rangeMin
	 */
	public function setRangeMin($rangeMin) {
		$this->rangeMin = $rangeMin;
		return $this;
	}

	/**
	 * @return the $rangeMax
	 */
	public function getRangeMax() {
		return $this->rangeMax;
	}

	/**
	 * @param field_type $rangeMax
	 */
	public function setRangeMax($rangeMax) {
		$this->rangeMax = $rangeMax;
		return $this;
	}
	
	/**
	 * Get a new sensor value with the id of this sensor
	 * @return SensorValue
	 */
	public function getNewSensorValue()
	{
		$sensorValue = new SensorValue();
		$sensorValue->setSensor($this);
		return $sensorValue;
	}
	
	/**
	 * Get the range  (rangeMax - rangeMin)
	 * @return double|null
	 */
	public function getRange()
	{
		if ($this->getIsRanged() && !is_null($this->getRangeMin()) && !is_null($this->getRangeMax())) {
			return (double)$this->getRangeMax() - (double)$this->getRangeMin(); 
		}
		
		return null;
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
	 * @return the $calibration
	 */
	public function getCalibration() {
		return $this->calibration;
	}

	/**
	 * @param field_type $calibration
	 */
	public function setCalibration($calibration) {
		$this->calibration = $calibration;
		return $this;
	}
	/**
	 * @return the $isWateringSensor
	 */
	public function getIsWateringSensor() {
		return $this->isWateringSensor;
	}

	/**
	 * @param field_type $isWateringSensor
	 */
	public function setIsWateringSensor($isWateringSensor) {
		$this->isWateringSensor = $isWateringSensor;
		return $this;
	}

	/**
	 * @return the $wateringThresholdLower
	 */
	public function getWateringThresholdLower() {
		return $this->wateringThresholdLower;
	}

	/**
	 * @param field_type $wateringThresholdLower
	 */
	public function setWateringThresholdLower($wateringThresholdLower) {
		$this->wateringThresholdLower = $wateringThresholdLower;
		return $this;
	}

	/**
	 * @return the $wateringThresholdUpper
	 */
	public function getWateringThresholdUpper() {
		return $this->wateringThresholdUpper;
	}

	/**
	 * @param field_type $wateringThresholdUpper
	 */
	public function setWateringThresholdUpper($wateringThresholdUpper) {
		$this->wateringThresholdUpper = $wateringThresholdUpper;
		return $this;
	}
	/**
	 * @return the $conversionFactor
	 */
	public function getConversionFactor() {
		return $this->conversionFactor;
	}

	/**
	 * @param field_type $conversionFactor
	 */
	public function setConversionFactor($conversionFactor) {
		$this->conversionFactor = $conversionFactor;
		return $this;
	}
	/**
	 * @return Node $node
	 */
	public function getNode() {
		return $this->node;
	}

	/**
	 * @param field_type $node
	 */
	public function setNode(Node $node) {
		$this->node = $node;
		return $this;
	}
	/**
	 * @return the $startGraphFrom
	 */
	public function getGraphStart() {
		return $this->graphStart;
	}

	/**
	 * @param field_type $graphStart
	 */
	public function setGraphStart($graphStart) {
		$this->graphStart = $graphStart;
		return $this;
	}

}
