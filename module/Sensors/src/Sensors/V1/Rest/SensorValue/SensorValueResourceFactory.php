<?php
namespace Sensors\V1\Rest\SensorValue;

class SensorValueResourceFactory
{
    public function __invoke($services)
    {
        return new SensorValueResource(
        	$services->get('SensorValueModel'), 
        	new SensorValueHydrator($services->get('SensorModel'))
		);
    }
}
