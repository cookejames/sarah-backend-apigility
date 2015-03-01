<?php
return array(
    'router' => array(
        'routes' => array(
            'heating.rest.group' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/heating/group[/:group_id]',
                    'defaults' => array(
                        'controller' => 'Heating\\V1\\Rest\\Group\\Controller',
                    ),
                ),
            ),
            'heating.rest.schedule' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/heating/schedule[/:schedule_id]',
                    'defaults' => array(
                        'controller' => 'Heating\\V1\\Rest\\Schedule\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'heating.rest.group',
            1 => 'heating.rest.schedule',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Heating\\V1\\Rest\\Group\\GroupResource' => 'Heating\\V1\\Rest\\Group\\GroupResourceFactory',
            'Heating\\V1\\Rest\\Schedule\\ScheduleResource' => 'Heating\\V1\\Rest\\Schedule\\ScheduleResourceFactory',
        ),
    ),
    'zf-rest' => array(
        'Heating\\V1\\Rest\\Group\\Controller' => array(
            'listener' => 'Heating\\V1\\Rest\\Group\\GroupResource',
            'route_name' => 'heating.rest.group',
            'route_identifier_name' => 'group_id',
            'collection_name' => 'group',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Sarah\\Entity\\HeatingGroup',
            'collection_class' => 'Heating\\V1\\Rest\\Group\\GroupCollection',
            'service_name' => 'group',
        ),
        'Heating\\V1\\Rest\\Schedule\\Controller' => array(
            'listener' => 'Heating\\V1\\Rest\\Schedule\\ScheduleResource',
            'route_name' => 'heating.rest.schedule',
            'route_identifier_name' => 'schedule_id',
            'collection_name' => 'schedule',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Sarah\\Entity\\HeatingSchedule',
            'collection_class' => 'Heating\\V1\\Rest\\Schedule\\ScheduleCollection',
            'service_name' => 'schedule',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Heating\\V1\\Rest\\Group\\Controller' => 'HalJson',
            'Heating\\V1\\Rest\\Schedule\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Heating\\V1\\Rest\\Group\\Controller' => array(
                0 => 'application/vnd.heating.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Heating\\V1\\Rest\\Schedule\\Controller' => array(
                0 => 'application/vnd.heating.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Heating\\V1\\Rest\\Group\\Controller' => array(
                0 => 'application/vnd.heating.v1+json',
                1 => 'application/json',
            ),
            'Heating\\V1\\Rest\\Schedule\\Controller' => array(
                0 => 'application/vnd.heating.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Heating\\V1\\Rest\\Group\\GroupEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'heating.rest.group',
                'route_identifier_name' => 'group_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Heating\\V1\\Rest\\Group\\GroupCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'heating.rest.group',
                'route_identifier_name' => 'group_id',
                'is_collection' => true,
            ),
            'Heating\\V1\\Rest\\Schedule\\ScheduleEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'heating.rest.schedule',
                'route_identifier_name' => 'schedule_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Heating\\V1\\Rest\\Schedule\\ScheduleCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'heating.rest.schedule',
                'route_identifier_name' => 'schedule_id',
                'is_collection' => true,
            ),
            'Sarah\\Entity\\HeatingGroup' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'heating.rest.group',
                'route_identifier_name' => 'group_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
            ),
            'Sarah\\Entity\\HeatingSchedule' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'heating.rest.schedule',
                'route_identifier_name' => 'schedule_id',
                'hydrator' => 'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Heating\\V1\\Rest\\Group\\Controller' => array(
            'input_filter' => 'Heating\\V1\\Rest\\Group\\Validator',
            'PUT' => 'Heating\\V1\\Rest\\Group\\PutValidator',
        ),
        'Heating\\V1\\Rest\\Schedule\\Controller' => array(
            'input_filter' => 'Heating\\V1\\Rest\\Schedule\\Validator',
        	'PUT' => 'Heating\\V1\\Rest\\Schedule\\PutValidator',
        ),
    ),
    'input_filter_specs' => array(
        'Heating\\V1\\Rest\\Group\\Validator' => array(
            0 => array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripNewlines',
                        'options' => array(),
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => array(
                            'adapter' => 'sarah',
                            'table' => 'heatingGroups',
                            'field' => 'name',
                        ),
                    ),
                ),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            1 => array(
                'name' => 'isEnabled',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
        ),
        'Heating\\V1\\Rest\\Group\\PutValidator' => array(
            0 => array(
                'name' => 'name',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripNewlines',
                        'options' => array(),
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbNoRecordExists',
                        'options' => array(
                            'adapter' => 'sarah',
                            'table' => 'heatingGroups',
                            'field' => 'name',
                        ),
                    ),
                ),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            1 => array(
                'name' => 'isEnabled',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
        ),
        'Heating\\V1\\Rest\\Schedule\\Validator' => array(
            0 => array(
                'name' => 'group',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
                        'options' => array(
                            'adapter' => 'sarah',
                            'table' => 'heatingGroups',
                            'field' => 'id',
                        ),
                    ),
                ),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            1 => array(
                'name' => 'heatingOn',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            2 => array(
                'name' => 'waterOn',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            3 => array(
                'name' => 'startHour',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Between',
                        'options' => array(
                            'inclusive' => true,
                            'min' => '0',
                            'max' => '24',
                        ),
                    ),
                ),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            4 => array(
                'name' => 'startMin',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Between',
                        'options' => array(
                            'inclusive' => true,
                            'min' => '0',
                            'max' => '59',
                        ),
                    ),
                ),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            5 => array(
                'name' => 'endHour',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Between',
                        'options' => array(
                            'inclusive' => true,
                            'min' => '0',
                            'max' => '24',
                        ),
                    ),
                ),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            6 => array(
                'name' => 'endMin',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Between',
                        'options' => array(
                            'inclusive' => true,
                            'min' => '0',
                            'max' => '59',
                        ),
                    ),
                ),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            7 => array(
                'name' => 'monday',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            8 => array(
                'name' => 'tuesday',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            9 => array(
                'name' => 'wednesday',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            10 => array(
                'name' => 'thursday',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            11 => array(
                'name' => 'friday',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            12 => array(
                'name' => 'saturday',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            13 => array(
                'name' => 'sunday',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\Boolean',
                        'options' => array(),
                    ),
                ),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
        ),
    	'Heating\\V1\\Rest\\Schedule\\PutValidator' => array(
    		0 => array(
    			'name' => 'group',
    			'required' => false,
    			'filters' => array(),
    			'validators' => array(
    				0 => array(
    					'name' => 'ZF\\ContentValidation\\Validator\\DbRecordExists',
    					'options' => array(
    						'adapter' => 'sarah',
    						'table' => 'heatingGroups',
    						'field' => 'id',
    					),
    				),
    			),
    			'allow_empty' => false,
    			'continue_if_empty' => false,
    		),
    		1 => array(
    			'name' => 'heatingOn',
    			'required' => true,
    			'filters' => array(
    				0 => array(
    					'name' => 'Zend\\Filter\\Boolean',
    					'options' => array(),
    				),
    			),
    			'validators' => array(),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		2 => array(
    			'name' => 'waterOn',
    			'required' => true,
    			'filters' => array(
    				0 => array(
    					'name' => 'Zend\\Filter\\Boolean',
    					'options' => array(),
    				),
    			),
    			'validators' => array(),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		3 => array(
    			'name' => 'startHour',
    			'required' => false,
    			'filters' => array(),
    			'validators' => array(
    				0 => array(
    					'name' => 'Zend\\Validator\\Between',
    					'options' => array(
    						'inclusive' => true,
    						'min' => '0',
    						'max' => '24',
    					),
    				),
    			),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		4 => array(
    			'name' => 'startMin',
    			'required' => false,
    			'filters' => array(),
    			'validators' => array(
    				0 => array(
    					'name' => 'Zend\\Validator\\Between',
    					'options' => array(
    						'inclusive' => true,
    						'min' => '0',
    						'max' => '59',
    					),
    				),
    			),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		5 => array(
    			'name' => 'endHour',
    			'required' => false,
    			'filters' => array(),
    			'validators' => array(
    				0 => array(
    					'name' => 'Zend\\Validator\\Between',
    					'options' => array(
    						'inclusive' => true,
    						'min' => '0',
    						'max' => '24',
    					),
    				),
    			),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		6 => array(
    			'name' => 'endMin',
    			'required' => false,
    			'filters' => array(),
    			'validators' => array(
    				0 => array(
    					'name' => 'Zend\\Validator\\Between',
    					'options' => array(
    						'inclusive' => true,
    						'min' => '0',
    						'max' => '59',
    					),
    				),
    			),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		7 => array(
    			'name' => 'monday',
    			'required' => true,
    			'filters' => array(
    				0 => array(
    					'name' => 'Zend\\Filter\\Boolean',
    					'options' => array(),
    				),
    			),
    			'validators' => array(),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		8 => array(
    			'name' => 'tuesday',
    			'required' => true,
    			'filters' => array(
    				0 => array(
    					'name' => 'Zend\\Filter\\Boolean',
    					'options' => array(),
    				),
    			),
    			'validators' => array(),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		9 => array(
    			'name' => 'wednesday',
    			'required' => true,
    			'filters' => array(
    				0 => array(
    					'name' => 'Zend\\Filter\\Boolean',
    					'options' => array(),
    				),
    			),
    			'validators' => array(),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		10 => array(
    			'name' => 'thursday',
    			'required' => true,
    			'filters' => array(
    				0 => array(
    					'name' => 'Zend\\Filter\\Boolean',
    					'options' => array(),
    				),
    			),
    			'validators' => array(),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		11 => array(
    			'name' => 'friday',
    			'required' => true,
    			'filters' => array(
    				0 => array(
    					'name' => 'Zend\\Filter\\Boolean',
    					'options' => array(),
    				),
    			),
    			'validators' => array(),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		12 => array(
    			'name' => 'saturday',
    			'required' => true,
    			'filters' => array(
    				0 => array(
    					'name' => 'Zend\\Filter\\Boolean',
    					'options' => array(),
    				),
    			),
    			'validators' => array(),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    		13 => array(
    			'name' => 'sunday',
    			'required' => true,
    			'filters' => array(
    				0 => array(
    					'name' => 'Zend\\Filter\\Boolean',
    					'options' => array(),
    				),
    			),
    			'validators' => array(),
    			'allow_empty' => true,
    			'continue_if_empty' => true,
    		),
    	),
    ),
);
