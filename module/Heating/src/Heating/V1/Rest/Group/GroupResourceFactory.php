<?php
namespace Heating\V1\Rest\Group;

class GroupResourceFactory
{
    public function __invoke($services)
    {
        $groupResource = new GroupResource($services->get('HeatingGroupModel'));
        $groupResource->setHydrator(new GroupHydrator());
        return $groupResource;
    }
}
