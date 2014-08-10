<?php
chdir(realpath(__DIR__ . '/../../../'));

// Setup autoloading
require 'init_autoloader.php';

use Zend\Test\Util\ModuleLoader;

class PHPUnitBootstrap extends ModuleLoader {

	/** @var PHPUnitBootstrap */
	protected static $instance;

	public function __construct() 
	{
 		parent::__construct(require 'config/application.config.php');
		$this->getServiceManager()->setAllowOverride(true);
		$this->buildServiceManager();
	}
	
	public static function getInstance() {
		if (!self::$instance instanceof self) {
			self::$instance = new self ();
		}
		return self::$instance;
	}
	
	protected function buildServiceManager() {
		$serviceManagerSettings = $this->getServiceConfig();
		$instanceRequired = false;
		foreach ( $serviceManagerSettings ['service_manager'] as $type => $data ) {
			if (empty ( $data ))
				continue;
			switch ($type) {
				case 'factories' :
					$instanceRequired = true;
					$method = 'setFactory';
					break;
				case 'services' :
					$instanceRequired = true;
					$method = 'setService';
					break;
				case 'invokables' :
					$method = 'setInvokableClass';
					break;
				case 'aliases' :
					$method = 'setAlias';
					break;
				default :
					throw new \Exception ( 'Attempt to call a service manager method that has not been set in ' . __METHOD__ );
			}
			foreach ( $data as $identifierString => $namespace ) {
				if ($instanceRequired) {
					$this->getServiceManager ()->$method ( $identifierString, new $namespace () );
				} else
					$this->getServiceManager ()->$method ( $identifierString, $namespace );
			}
			$instanceRequired = false;
		}
		$module = new sarah\Module ();
		$module->setupServiceManager($this->getServiceManager());
	}

	public function getServiceConfig() {
		return array (
				'service_manager' => array (
						'factories' => array(),
						'services' => array(),
						'invokables' => array(),
						'aliases' => array() 
				) 
		);
	}
}

PHPUnitBootstrap::getInstance ();