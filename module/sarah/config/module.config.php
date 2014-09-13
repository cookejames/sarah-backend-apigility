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
            'sarah.rpc.update-weather' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/update-weather',
                    'defaults' => array(
                        'controller' => 'sarah\\V1\\Rpc\\UpdateWeather\\Controller',
                        'action' => 'updateWeather',
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
            3 => 'sarah.rpc.update-weather',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'sarah\\V1\\Rest\\Node\\NodeResource' => 'sarah\\V1\\Rest\\Node\\NodeResourceFactory',
            'sarah\\V1\\Rest\\Sensor\\SensorResource' => 'sarah\\V1\\Rest\\Sensor\\SensorResourceFactory',
            'sarah\\V1\\Rest\\SensorValue\\SensorValueResource' => 'sarah\\V1\\Rest\\SensorValue\\SensorValueResourceFactory',
            'ZfrCors\\Mvc\\CorsRequestListener' => 'sarah\\Factory\\CustomCorsRequestListenerFactory',
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
            'collection_name' => 'sensor-value',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(
                0 => 'sensors',
                1 => 'from',
                2 => 'to',
            ),
            'page_size' => '2000',
            'page_size_param' => 'page_size',
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
            'sarah\\V1\\Rpc\\UpdateWeather\\Controller' => 'Json',
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
            'sarah\\V1\\Rpc\\UpdateWeather\\Controller' => array(
                0 => 'application/vnd.sarah.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
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
            'sarah\\V1\\Rpc\\UpdateWeather\\Controller' => array(
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
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
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
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
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
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
            ),
            'sarah\\V1\\Rest\\Sensor\\Controller' => array(
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
            ),
            'sarah\\V1\\Rest\\SensorValue\\Controller' => array(
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
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
        'sarah\\V1\\Rest\\SensorValue\\Controller' => array(
            'input_filter' => 'sarah\\V1\\Rest\\SensorValue\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'sarah\\V1\\Rest\\Node\\Validator' => array(),
        'sarah\\V1\\Rest\\SensorValue\\Validator' => array(
            0 => array(
                'name' => 'sensor',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\Int',
                        'options' => array(),
                    ),
                ),
                'description' => '(int) The sensor id that this value belongs to',
                'error_message' => 'Sensor id is required and must be an integer',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            1 => array(
                'name' => 'value',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '255',
                            'min' => '1',
                        ),
                    ),
                ),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => '(float) The value of the sensor',
                'error_message' => 'The value must be a string between 1 and 255 characters',
            ),
            2 => array(
                'name' => 'date',
                'required' => false,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\Int',
                        'options' => array(),
                    ),
                ),
                'description' => '(int)(option) - The date as a unix timestamp',
                'error_message' => 'The date must be an integer',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            3 => array(
                'name' => 'id',
                'required' => false,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\Int',
                        'options' => array(),
                    ),
                ),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => '(int) the id of this value',
            ),
        ),
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
    'controllers' => array(
        'factories' => array(
            'sarah\\V1\\Rpc\\UpdateWeather\\Controller' => 'sarah\\V1\\Rpc\\UpdateWeather\\UpdateWeatherControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'sarah\\V1\\Rpc\\UpdateWeather\\Controller' => array(
            'service_name' => 'updateWeather',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'sarah.rpc.update-weather',
        ),
    ),
);
