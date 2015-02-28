<?php
namespace Sensors\V1\Rest\Node;

class NodeResourceFactory
{
    public function __invoke($services)
    {
        return new NodeResource($services->get('NodeModel'));
    }
}
