<?php
namespace sarah\V1\Rest\Sensor;

use sarah\V1\Rest\Sensor\SensorHydrator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use sarah\Entity\SensorValue;
class SensorResourceFactory
{
    public function __invoke($services)
    {
    	$resource = new SensorResource($services->get('SensorModel'), new SensorHydrator(), new SensorEntity());
    	$resource
	    	->setDoctrineHydrator(new DoctrineObject($services->get('doctrine.entitymanager.orm_default')))
	    	->setDoctrinePrototype(new SensorValue());
    	
    	return $resource;
    }
}
