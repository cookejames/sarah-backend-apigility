<?php
namespace Sensors\V1\Rest\SensorValue;

use Sarah\Entity\SensorValue;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
class SensorValueResourceFactory
{
    public function __invoke($services)
    {
        $resource = new SensorValueResource($services->get('SensorValueModel'), new SensorValueHydrator(), new SensorValueEntity());
        $resource
        	->setDoctrineHydrator(new DoctrineObject($services->get('doctrine.entitymanager.orm_default')))
        	->setDoctrinePrototype(new SensorValue());
        
        return $resource;
    }
}
