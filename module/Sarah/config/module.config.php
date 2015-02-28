<?php
return array(
    'service_manager' => array(
        'factories' => array(
        	'logger' => 'Sarah\Factory\LoggerFactory',
        	'WeatherModel' => 'Sarah\Factory\Model\WeatherModelFactory',
            'ZfrCors\Mvc\CorsRequestListener' => 'Sensors\Factory\Mvc\CustomCorsRequestListenerFactory',
        ),
    	'invokables' => array(
    		'SensorValueModel' =>  'Sarah\Model\SensorValueModel',
    		'SensorModel' => 'Sarah\Model\SensorModel',
    		'NodeModel' => 'Sarah\Model\NodeModel',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'sarah_driver' => array(
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    0 => __DIR__ . '/../src/Sarah/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Sarah\\Entity' => 'sarah_driver',
                ),
            ),
        ),
    ),
);
