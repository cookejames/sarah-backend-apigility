<?php
return array(
    'router' => array(
        'routes' => array(
            'sarah.rest.node' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/node[/:node_id]',
                    'defaults' => array(
                        'controller' => 'sarah\\V1\\Rest\\Node\\Controller',
                    ),
                ),
            ),
            'sarah.rest.sensor' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/sensor[/:sensor_id]',
                    'defaults' => array(
                        'controller' => 'sarah\\V1\\Rest\\Sensor\\Controller',
                    ),
                ),
            ),
            'sarah.rest.sensor-value' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/sensor-value[/:sensor_value_id]',
                    'defaults' => array(
                        'controller' => 'sarah\\V1\\Rest\\SensorValue\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'sarah.rest.node',
            1 => 'sarah.rest.sensor',
            2 => 'sarah.rest.sensor-value',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'sarah\\V1\\Rest\\Node\\NodeResource' => 'sarah\\V1\\Rest\\Node\\NodeResourceFactory',
            'sarah\\V1\\Rest\\Sensor\\SensorResource' => 'sarah\\V1\\Rest\\Sensor\\SensorResourceFactory',
            'sarah\\V1\\Rest\\SensorValue\\SensorValueResource' => 'sarah\\V1\\Rest\\SensorValue\\SensorValueResourceFactory',
        ),
    ),
    'zf-rest' => array(
        'sarah\\V1\\Rest\\Node\\Controller' => array(
            'listener' => 'sarah\\V1\\Rest\\Node\\NodeResource',
            'route_name' => 'sarah.rest.node',
            'route_identifier_name' => 'node_id',
            'collection_name' => 'node',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => '25',
            'page_size_param' => null,
            'entity_class' => 'sarah\\V1\\Rest\\Node\\NodeEntity',
            'collection_class' => 'sarah\\V1\\Rest\\Node\\NodeCollection',
            'service_name' => 'node',
        ),
        'sarah\\V1\\Rest\\Sensor\\Controller' => array(
            'listener' => 'sarah\\V1\\Rest\\Sensor\\SensorResource',
            'route_name' => 'sarah.rest.sensor',
            'route_identifier_name' => 'sensor_id',
            'collection_name' => 'sensor',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'sarah\\V1\\Rest\\Sensor\\SensorEntity',
            'collection_class' => 'sarah\\V1\\Rest\\Sensor\\SensorCollection',
            'service_name' => 'sensor',
        ),
        'sarah\\V1\\Rest\\SensorValue\\Controller' => array(
            'listener' => 'sarah\\V1\\Rest\\SensorValue\\SensorValueResource',
            'route_name' => 'sarah.rest.sensor-value',
            'route_identifier_name' => 'sensor_value_id',
            'collection_name' => 'sensor_value',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'sarah\\V1\\Rest\\SensorValue\\SensorValueEntity',
            'collection_class' => 'sarah\\V1\\Rest\\SensorValue\\SensorValueCollection',
            'service_name' => 'sensorValue',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'sarah\\V1\\Rest\\Node\\Controller' => 'HalJson',
            'sarah\\V1\\Rest\\Sensor\\Controller' => 'HalJson',
            'sarah\\V1\\Rest\\SensorValue\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'sarah\\V1\\Rest\\Node\\Controller' => array(
                0 => 'application/vnd.sarah.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'sarah\\V1\\Rest\\Sensor\\Controller' => array(
                0 => 'application/vnd.sarah.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'sarah\\V1\\Rest\\SensorValue\\Controller' => array(
                0 => 'application/vnd.sarah.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'sarah\\V1\\Rest\\Node\\Controller' => array(
                0 => 'application/vnd.sarah.v1+json',
                1 => 'application/json',
            ),
            'sarah\\V1\\Rest\\Sensor\\Controller' => array(
                0 => 'application/vnd.sarah.v1+json',
                1 => 'application/json',
            ),
            'sarah\\V1\\Rest\\SensorValue\\Controller' => array(
                0 => 'application/vnd.sarah.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'sarah\\V1\\Rest\\Node\\NodeEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sarah.rest.node',
                'route_identifier_name' => 'node_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'sarah\\V1\\Rest\\Node\\NodeCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sarah.rest.node',
                'route_identifier_name' => 'node_id',
                'is_collection' => true,
            ),
            'sarah\\V1\\Rest\\Sensor\\SensorEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sarah.rest.sensor',
                'route_identifier_name' => 'sensor_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'sarah\\V1\\Rest\\Sensor\\SensorCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sarah.rest.sensor',
                'route_identifier_name' => 'sensor_id',
                'is_collection' => true,
            ),
            'sarah\\V1\\Rest\\SensorValue\\SensorValueEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sarah.rest.sensor-value',
                'route_identifier_name' => 'sensor_value_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'sarah\\V1\\Rest\\SensorValue\\SensorValueCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sarah.rest.sensor-value',
                'route_identifier_name' => 'sensor_value_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'sarah\\V1\\Rest\\Node\\Controller' => array(
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => true,
                    'PUT' => true,
                    'DELETE' => true,
                ),
                'collection' => array(
                    'GET' => false,
                    'POST' => true,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
            ),
            'sarah\\V1\\Rest\\Sensor\\Controller' => array(
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => true,
                    'PUT' => true,
                    'DELETE' => true,
                ),
                'collection' => array(
                    'GET' => false,
                    'POST' => true,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
            ),
            'sarah\\V1\\Rest\\SensorValue\\Controller' => array(
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => true,
                    'PUT' => true,
                    'DELETE' => true,
                ),
                'collection' => array(
                    'GET' => false,
                    'POST' => true,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
            ),
        ),
    ),
    'zf-content-validation' => array(
        'sarah\\V1\\Rest\\Node\\Controller' => array(
            'input_filter' => 'sarah\\V1\\Rest\\Node\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'sarah\\V1\\Rest\\Node\\Validator' => array(),
    ),
    'doctrine' => array(
        'driver' => array(
            'sarah_driver' => array(
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    0 => __DIR__ . '/../src/sarah/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'sarah\\Entity' => 'sarah_driver',
                ),
            ),
        ),
    ),
);
