<?php
namespace sarah\V1\Rest\SensorValue;

use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Converts the array copy of a SensorValue to a SensorValueEntity
 * The difference between the two is that the date is represented
 * as a timestamp not a datetime
 * @author James Cooke
 *
 */
class SensorValueHydrator implements HydratorInterface
{
	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\Hydrator\HydrationInterface::hydrate()
	 */
	public function hydrate(array $data, $object)
	{
		if (!$object instanceof SensorValueEntity) {
			throw new \Exception('object must be a SensorValueEntity');
		}
		if (!is_array($data)) {
			return $data;
		}

		$object->id = $data['sensorValue_id'];
		$object->sensor = (int)$data['sensorValue_sensor'];
		$object->date = $data['sensorValue_date']->getTimestamp();
		$object->value = (float)$data['sensorValue_value'];
		
		return $object;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\Extractor\ExtractionInterface::extract()
	 */
	public function extract($object)
	{
		return (array)$object;
	}
}
