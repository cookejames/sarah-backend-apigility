<?php
namespace Heating\V1\Rest\Schedule;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Sarah\Entity\HeatingGroup;
use Sarah\Entity\HeatingSchedule;
use Sarah\Model\HeatingGroupModel;
class ScheduleHydrator implements HydratorInterface
{
	/**
	 * @var HeatingGroupModel
	 */
	private $heatingGroupModel;
	
	public function __construct(HeatingGroupModel $heatingGroupModel)
	{
		$this->heatingGroupModel = $heatingGroupModel;
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
		if (!$object instanceof HeatingSchedule) {
			throw new \Exception('$object must be an instance of HeatingSchedule');
		}
		
		if (isset($data['group']) && ($group = $this->heatingGroupModel->getHeatingGroupById($data['group'])) instanceof HeatingGroup) {
			$object->setGroup($group);
			unset($data['group']);
		}
		
		foreach ($data as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (method_exists($object, $method)) {
				$object->{$method}($value);
			}
		}
		
		return $object;
	}

	
}