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
    'logPath' => '/var/www/api.sarah.local/logs/log',
    'db' => array(
        'adapters' => array(
            'sarah' => array(),
        ),
    ),
);
