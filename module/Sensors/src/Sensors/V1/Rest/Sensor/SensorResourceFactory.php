<?php
namespace Sensors\V1\Rest\Sensor;

class SensorResourceFactory
{
    public function __invoke($services)
    {
    	return new SensorResource($services->get('SensorModel'));
    }
}
