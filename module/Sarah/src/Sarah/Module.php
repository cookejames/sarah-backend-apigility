<?php
namespace Sarah;

use Zend\Mvc\MvcEvent;
use Zend\Log\Logger;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;

class Module implements DependencyIndicatorInterface
{
	public function onBootstrap(MvcEvent $e)
	{
		//Set default timezone
		date_default_timezone_set('UTC');
	
		//set the logger
		$logger = $e->getApplication()->getServiceManager()->get('logger');
		Logger::registerErrorHandler($logger);
	}

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array('Zend\Loader\StandardAutoloader' => array('namespaces' => array(
            __NAMESPACE__ => __DIR__,
        )));
    }
    
    public function getModuleDependencies()
    {
    	return array(
    		'DoctrineModule',
    		'DoctrineORMModule',
    	);
    }
}
