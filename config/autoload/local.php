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
	//weather details
	'weather' => array(
			'url' => 'http://api.openweathermap.org/data/2.5/',
			'path' => 'weather?q=',
			'default_location' => 'Cambridge,UK',
			'api_id' => 'f361a96e9e3e42b0d4b4e8fbe4a855a8',
	),
	//doctrine config
	'doctrine' => array(
		'connection' => array(
			'orm_default' => array(
					'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
					'params' => array(
							'host'     => 'localhost',
							'port'     => '3306',
							'user'     => 'watering_system',
							'password' => 'watering_system',
							'dbname'   => 'watering_system',
					)
			)
		),
		// Configuration details for the ORM.
		// See http://docs.doctrine-project.org/en/latest/reference/configuration.html
		'configuration' => array(
			// Configuration for service `doctrine.configuration.orm_default` service
			'orm_default' => array(
				// metadata cache instance to use. The retrieved service name will
				// be `doctrine.cache.$thisSetting`
				'metadata_cache'    => 'array',
		
				// DQL queries parsing cache instance to use. The retrieved service
				// name will be `doctrine.cache.$thisSetting`
				'query_cache'       => 'array',
		
				// ResultSet cache to use.  The retrieved service name will be
				// `doctrine.cache.$thisSetting`
				'result_cache'      => 'array',
		
				// Hydration cache to use.  The retrieved service name will be
				// `doctrine.cache.$thisSetting`
				'hydration_cache'   => 'array',
		
				// Mapping driver instance to use. Change this only if you don't want
				// to use the default chained driver. The retrieved service name will
				// be `doctrine.driver.$thisSetting`
				'driver'            => 'orm_default',
		
				// Generate proxies automatically (turn off for production)
				'generate_proxies'  => 2,
		
				// directory where proxies will be stored. By default, this is in
				// the `data` directory of your application
				'proxy_dir'         => 'data/DoctrineORMModule/Proxy',
		
				// namespace for generated proxy classes
				'proxy_namespace'   => 'DoctrineORMModule\Proxy',
			)
		),
	),
);
