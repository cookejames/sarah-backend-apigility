<?php
return array(
    'router' => array(
        'routes' => array(
            'sensors.rest.node' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/sensors/node[/:node_id]',
                    'defaults' => array(
                        'controller' => 'Sensors\\V1\\Rest\\Node\\Controller',
                    ),
                ),
            ),
            'sensors.rest.sensor' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/sensors/sensor[/:sensor_id]',
                    'defaults' => array(
                        'controller' => 'Sensors\\V1\\Rest\\Sensor\\Controller',
                    ),
                ),
            ),
            'sensors.rest.sensor-value' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/sensors/sensor-value[/:sensor_value_id]',
                    'defaults' => array(
                        'controller' => 'Sensors\\V1\\Rest\\SensorValue\\Controller',
                    ),
                ),
            ),
            'sensors.rpc.update-weather' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/update-weather',
                    'defaults' => array(
                        'controller' => 'Sensors\\V1\\Rpc\\UpdateWeather\\Controller',
                        'action' => 'updateWeather',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'sensors.rest.node',
            1 => 'sensors.rest.sensor',
            2 => 'sensors.rest.sensor-value',
            3 => 'sensors.rpc.update-weather',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Sensors\\V1\\Rest\\Node\\NodeResource' => 'Sensors\\V1\\Rest\\Node\\NodeResourceFactory',
            'Sensors\\V1\\Rest\\Sensor\\SensorResource' => 'Sensors\\V1\\Rest\\Sensor\\SensorResourceFactory',
            'Sensors\\V1\\Rest\\SensorValue\\SensorValueResource' => 'Sensors\\V1\\Rest\\SensorValue\\SensorValueResourceFactory',
        ),
    ),
    'zf-rest' => array(
        'Sensors\\V1\\Rest\\Node\\Controller' => array(
            'listener' => 'Sensors\\V1\\Rest\\Node\\NodeResource',
            'route_name' => 'sensors.rest.node',
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
            'entity_class' => 'Sarah\\Entity\\Node',
            'collection_class' => 'Sensors\\V1\\Rest\\Node\\NodeCollection',
            'service_name' => 'node',
        ),
        'Sensors\\V1\\Rest\\Sensor\\Controller' => array(
            'listener' => 'Sensors\\V1\\Rest\\Sensor\\SensorResource',
            'route_name' => 'sensors.rest.sensor',
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
            'entity_class' => 'Sarah\\Entity\\Sensor',
            'collection_class' => 'Sensors\\V1\\Rest\\Sensor\\SensorCollection',
            'service_name' => 'sensor',
        ),
        'Sensors\\V1\\Rest\\SensorValue\\Controller' => array(
            'listener' => 'Sensors\\V1\\Rest\\SensorValue\\SensorValueResource',
            'route_name' => 'sensors.rest.sensor-value',
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
            'page_size' => '1000',
            'page_size_param' => 'page_size',
            'entity_class' => 'Sarah\\Entity\\SensorValue',
            'collection_class' => 'Sensors\\V1\\Rest\\SensorValue\\SensorValueCollection',
            'service_name' => 'sensorValue',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Sensors\\V1\\Rest\\Node\\Controller' => 'HalJson',
            'Sensors\\V1\\Rest\\Sensor\\Controller' => 'HalJson',
            'Sensors\\V1\\Rest\\SensorValue\\Controller' => 'HalJson',
            'Sensors\\V1\\Rpc\\UpdateWeather\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Sensors\\V1\\Rest\\Node\\Controller' => array(
                0 => 'application/vnd.sensors.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Sensors\\V1\\Rest\\Sensor\\Controller' => array(
                0 => 'application/vnd.sensors.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Sensors\\V1\\Rest\\SensorValue\\Controller' => array(
                0 => 'application/vnd.sensors.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Sensors\\V1\\Rpc\\UpdateWeather\\Controller' => array(
                0 => 'application/vnd.sensors.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Sensors\\V1\\Rest\\Node\\Controller' => array(
                0 => 'application/vnd.sensors.v1+json',
                1 => 'application/json',
            ),
            'Sensors\\V1\\Rest\\Sensor\\Controller' => array(
                0 => 'application/vnd.sensors.v1+json',
                1 => 'application/json',
            ),
            'Sensors\\V1\\Rest\\SensorValue\\Controller' => array(
                0 => 'application/vnd.sensors.v1+json',
                1 => 'application/json',
            ),
            'Sensors\\V1\\Rpc\\UpdateWeather\\Controller' => array(
                0 => 'application/vnd.sensors.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Sarah\\Entity\\Node' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sensors.rest.node',
                'route_identifier_name' => 'node_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
            ),
            'Sensors\\V1\\Rest\\Node\\NodeCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sensors.rest.node',
                'route_identifier_name' => 'node_id',
                'is_collection' => true,
            ),
            'Sarah\\Entity\\Sensor' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sensors.rest.sensor',
                'route_identifier_name' => 'sensor_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
            ),
            'Sensors\\V1\\Rest\\Sensor\\SensorCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sensors.rest.sensor',
                'route_identifier_name' => 'sensor_id',
                'is_collection' => true,
            ),
            'Sarah\\Entity\\SensorValue' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sensors.rest.sensor-value',
                'route_identifier_name' => 'sensor_value_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
            ),
            'Sensors\\V1\\Rest\\SensorValue\\SensorValueCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'sensors.rest.sensor-value',
                'route_identifier_name' => 'sensor_value_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Sensors\\V1\\Rest\\Node\\Controller' => array(
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
            'Sensors\\V1\\Rest\\Sensor\\Controller' => array(
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
            'Sensors\\V1\\Rest\\SensorValue\\Controller' => array(
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
        'Sensors\\V1\\Rest\\Node\\Controller' => array(
            'input_filter' => 'Sensors\\V1\\Rest\\Node\\Validator',
        ),
        'Sensors\\V1\\Rest\\SensorValue\\Controller' => array(
            'input_filter' => 'Sensors\\V1\\Rest\\SensorValue\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Sensors\\V1\\Rest\\Node\\Validator' => array(),
        'Sensors\\V1\\Rest\\SensorValue\\Validator' => array(
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
    'controllers' => array(
        'factories' => array(
            'Sensors\\V1\\Rpc\\UpdateWeather\\Controller' => 'Sensors\\V1\\Rpc\\UpdateWeather\\UpdateWeatherControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'Sensors\\V1\\Rpc\\UpdateWeather\\Controller' => array(
            'service_name' => 'updateWeather',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'sensors.rpc.update-weather',
        ),
    ),
);
