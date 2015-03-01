<?php
namespace Heating\V1\Rest\Schedule;

class ScheduleResourceFactory
{
    public function __invoke($services)
    {
        $resource = new ScheduleResource($services->get('HeatingScheduleModel'));
        $resource->setHydrator(new ScheduleHydrator($services->get('HeatingGroupModel')));
        return $resource;
    }
}
