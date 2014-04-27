<?php
namespace WateringSystem;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $this->setInvokables($e->getApplication()->getServiceManager());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /**
     * Set invokables
     * @param ServiceLocatorInterface $serviceLocator
     * @return \WateringSystem\Module
     */
    protected function setInvokables(ServiceLocatorInterface $serviceLocator)
    {
    	$serviceLocator
    		->setInvokableClass('SensorReadingModel', 'WateringSystem\Model\SensorReadingModel');
    	return $this;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
