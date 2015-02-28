<?php
namespace Sensors;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Log\Logger;
use Zend\ServiceManager\ServiceManager;
use Zend\Uri\UriFactory;

class Module implements ApigilityProviderInterface
{
	public function onBootstrap(MvcEvent $e)
	{
		//Set default timezone
		date_default_timezone_set('UTC');
	
		//set the logger
		$logger = $e->getApplication()->getServiceManager()->get('logger');
		Logger::registerErrorHandler($logger);
		
		$this->registerUriScheme();
	}
	
	/**
	 * Register valid uri schemes
	 */
	protected function registerUriScheme()
	{
	    UriFactory::registerScheme('chrome-extension', 'Zend\Uri\Uri');
	}
	
	/**
	 * @param ServiceManager $serviceManager
	 */
	public function setupServiceManager(ServiceManager $serviceManager)
	{
		$this->setFactories($serviceManager)
		->setInvokables($serviceManager);
	}
	
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'ZF\Apigility\Autoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}
