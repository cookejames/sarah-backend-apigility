<?php
namespace Heating\V1\Rest\Group;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Sarah\Entity\HeatingGroup;
class GroupHydrator implements HydratorInterface
{
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
		if (!$object instanceof HeatingGroup) {
			throw new \Exception('$object must be an instance of HeatingGroup');
		}
		
		if (isset($data['id'])) {
			$object->setId($data['id']);
		}
		
		if (isset($data['name'])) {
			$object->setName($data['name']);
		}
		
		if (isset($data['isEnabled'])) {
			$object->setIsEnabled($data['isEnabled']);
		}
		
		return $object;
	}

	
}