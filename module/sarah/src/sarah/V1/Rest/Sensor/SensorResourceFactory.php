<?php
namespace sarah\V1\Rest\Sensor;

class SensorResourceFactory
{
    public function __invoke($services)
    {
        return new SensorResource();
    }
}
