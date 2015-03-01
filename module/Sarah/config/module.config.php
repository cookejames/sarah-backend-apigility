<?php
return array(
    'service_manager' => array(
        'factories' => array(
        	'logger' => 'Sarah\Factory\LoggerFactory',
        	'WeatherModel' => 'Sarah\Factory\Model\WeatherModelFactory',
            'ZfrCors\Mvc\CorsRequestListener' => 'Sensors\Factory\Mvc\CustomCorsRequestListenerFactory',
        ),
    	'invokables' => array(
    		'HeatingGroupModel' => 'Sarah\Model\HeatingGroupModel',
    		'HeatingScheduleModel' => 'Sarah\Model\HeatingScheduleModel',
    		'NodeModel' => 'Sarah\Model\NodeModel',
    		'SensorModel' => 'Sarah\Model\SensorModel',
    		'SensorValueModel' =>  'Sarah\Model\SensorValueModel',
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
