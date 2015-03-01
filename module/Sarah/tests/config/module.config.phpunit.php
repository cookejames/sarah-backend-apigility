<?php
return array(
	//doctrine config
	'doctrine' => array(
		'connection' => array(
			'orm_default' => array(
					'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
					'params' => array(
						'memory' => true
					)
			)
		),
		'configuration' => array(
			'orm_default' => array(
				'metadata_cache'    => 'array',
				'query_cache'       => 'array',
				'result_cache'      => 'array',
				'hydration_cache'   => 'array',
				'driver'            => 'orm_default',
				'generate_proxies'  => 1,
				'proxy_dir'         => 'data/DoctrineORMModule/Proxy',
				'proxy_namespace'   => 'DoctrineORMModule\Proxy',
			)
		),
	),
);
