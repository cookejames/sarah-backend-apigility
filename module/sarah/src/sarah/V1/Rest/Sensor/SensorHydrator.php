<?php
namespace sarah\V1\Rest\Sensor;

use Zend\Stdlib\Hydrator\HydratorInterface;
use sarah\V1\Rest\Sensor\SensorEntity;

/**
 * Converts the array copy of a Sensor to a SensorEntity
 * @author James Cooke
 *
 */
class SensorHydrator implements HydratorInterface
{
	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\Hydrator\HydrationInterface::hydrate()
	 */
	public function hydrate(array $data, $object)
	{
		if (!$object instanceof SensorEntity) {
			throw new \Exception('object must be a SensorEntity');
		}
		if (!is_array($data)) {
			return $data;
		}
		
		foreach ($data as $key => $value) {
			$object->{preg_replace('/sensor_/', '', $key)} = $value;
		}
		
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
