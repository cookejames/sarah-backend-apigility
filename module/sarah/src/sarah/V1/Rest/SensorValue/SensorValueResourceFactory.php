<?php
namespace sarah\V1\Rest\SensorValue;

class SensorValueResourceFactory
{
    public function __invoke($services)
    {
        return new SensorValueResource();
    }
}
