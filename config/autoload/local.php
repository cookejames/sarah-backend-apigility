<?php
return array(
    'zf-oauth2' => array(
        'storage' => 'ZF\\OAuth2\\Adapter\\PdoAdapter',
        'db' => array(
            'dsn_type' => 'PDO',
            'dsn' => 'mysql:host=localhost;dbname=watering_system',
            'username' => 'watering_system',
            'password' => 'watering_system',
        ),
    ),
	'db' => array(
		'adapters' => array(
			'sarah' => array(
				'driver' => 'Pdo_Mysql',
				'database' => 'watering_system',
				'username' => 'watering_system',
				'password' => 'watering_system',
				'hostname' => 'localhost',
			),
		),
	),
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\\DBAL\\Driver\\PDOMySql\\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'watering_system',
                    'password' => 'watering_system',
                    'dbname' => 'watering_system',
                ),
            ),
        ),
        'configuration' => array(
            'orm_default' => array(
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'hydration_cache' => 'array',
                'driver' => 'orm_default',
                'generate_proxies' => 1,
                'proxy_dir' => 'data/DoctrineORMModule/Proxy',
                'proxy_namespace' => 'DoctrineORMModule\\Proxy',
            ),
        ),
    ),
	'weather' => array(
		'url' => 'http://api.openweathermap.org/data/2.5/',
		'path' => 'weather?q=',
		'default_location' => 'Cambridge,UK',
		'api_id' => 'f361a96e9e3e42b0d4b4e8fbe4a855a8',
		'sensors' => array(
			'humidity' => 11,
			'coudiness' => 10,
			'pressure' => 8,
			'temperature' => 9,
		),
	),
);
