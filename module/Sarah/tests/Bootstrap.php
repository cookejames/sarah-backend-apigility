<?php
namespace SarahTest;
error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use RuntimeException;
use ZF\MvcAuth\Identity\GuestIdentity;

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
	/**
	 * @var ServiceManager
	 */
	protected static $serviceManager;
	protected static $baseDir = __DIR__;
	protected static $modules = array(
		'DoctrineModule',
		'DoctrineORMModule',
		'Sarah',
	);

	public static function init()
	{
		$zf2ModulePaths = array(
			dirname(dirname(static::$baseDir))
		);
		if (($path = static::findParentPath('vendor')) == true) {
			$zf2ModulePaths[] = $path;
		}
		if (($path = static::findParentPath('module')) !== $zf2ModulePaths[0]) {
			$zf2ModulePaths[] = $path;
		}
		
		static::initAutoloader();
		
		// use ModuleManager to load this module and it's dependencies
		$config = array(
			'module_listener_options' => array(
				'module_paths' => $zf2ModulePaths,
			),
			'modules' => static::$modules,
		);
		

		$autoloaderPath = dirname(dirname(dirname(static::$baseDir))) . '/config/autoload/';
		if (!is_dir($autoloaderPath)) {
			$autoloaderPath = static::findParentPath('config');
		}
		if ($autoloaderPath) {
			$config['module_listener_options']['config_glob_paths'] = array(
				$autoloaderPath . '{,*.}{global,local,phpunit}.php'
			);
		}

		$serviceManager = new ServiceManager(new ServiceManagerConfig());
		$serviceManager->setService('ApplicationConfig', $config);
		$serviceManager->get('ModuleManager')->loadModules();
		$serviceManager->setService('api-identity', new GuestIdentity());
		static::$serviceManager = $serviceManager;
	}

	public static function chroot()
	{
		$rootPath = dirname(static::findParentPath('module'));
		chdir($rootPath);
	}

	/**
	 * @return \Zend\ServiceManager\ServiceManager
	 */
	public static function getServiceManager()
	{
		return static::$serviceManager;
	}

	protected static function initAutoloader()
	{
		$vendorPath = static::findParentPath('vendor');
		
		$zf2Path = getenv('ZF2_PATH');
		if (! $zf2Path) {
			if (defined('ZF2_PATH')) {
				$zf2Path = ZF2_PATH;
			} elseif (is_dir($vendorPath . '/ZF2/library')) {
				$zf2Path = $vendorPath . '/ZF2/library';
			} elseif (is_dir($vendorPath . '/zendframework/zendframework/library')) {
				$zf2Path = $vendorPath . '/zendframework/zendframework/library';
			}
		}
		
		if (! $zf2Path) {
			throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or' . ' define a ZF2_PATH environment variable.');
		}
		
		if (file_exists($vendorPath . '/autoload.php')) {
			include $vendorPath . '/autoload.php';
		}
		
		include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
		AutoloaderFactory::factory(array(
			'Zend\Loader\StandardAutoloader' => array(
				'autoregister_zf' => true,
				'namespaces' => array(
					__NAMESPACE__ => static::$baseDir . '/' . __NAMESPACE__
				)
			)
		));
	}

	protected static function findParentPath($path)
	{
		$dir = static::$baseDir;
		$previousDir = '.';
		while (! is_dir($dir . '/' . $path)) {
			$dir = dirname($dir);
			if ($previousDir === $dir) {
				return false;
			}
			$previousDir = $dir;
		}
		return $dir . '/' . $path;
	}
}

Bootstrap::init();
Bootstrap::chroot();