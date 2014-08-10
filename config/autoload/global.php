<?php
return array(
    'router' => array(
        'routes' => array(
            'oauth' => array(
                'options' => array(
                    'route' => '/auth',
                ),
            ),
        ),
    ),
	'logPath' => realpath(__DIR__ . '/../../logs/log'),
);
