<?php
namespace Sensors\V1\Rest\SensorValue;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Sarah\Entity\SensorValue;
use Sarah\Model\SensorModel;
use Sarah\Entity\Sensor;
class SensorValueHydrator implements HydratorInterface
{
	/**
	 * @var SensorModel
	 */
	private $sensorModel;
	public function __construct(SensorModel $sensorModel)
	{
		$this->sensorModel = $sensorModel;
	}
	
	/* (non-PHPdoc)
	 * @see \Zend\Stdlib\Extractor\ExtractionInterface::extract()
	 */
	public function extract ($object)
	{
		// TODO Auto-generated method stub
		
	}

	/* (non-PHPdoc)
	 * @see \Zend\Stdlib\Hydrator\HydrationInterface::hydrate()
	 */
	public function hydrate (array $data, $object)
	{
		if (!$object instanceof SensorValue) {
			throw new \Exception('Invalid object');
		}
		
		if (isset($data['date']) && ($date = \DateTime::createFromFormat('U', $data['date'])) instanceof \DateTime) {
			$object->setDate($date);
		}
		
		if (isset($data['id'])) {
			$object->setId($data['id']);
		}
		
		if (isset($data['sensor']) && ($sensor = $this->sensorModel->getSensorById($data['sensor'])) instanceof Sensor) {
			$object->setSensor($sensor);
		}
		
		if (isset($data['value'])) {
			$object->setValue($data['value']);
		}
		
		return $object;
	}
}