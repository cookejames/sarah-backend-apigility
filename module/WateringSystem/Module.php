<?php
namespace WateringSystem;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use WateringSystem\Model\SensorReadingModel;
use WateringSystem\View\Helper\MessageHelper;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $this->setInvokables($e->getApplication()->getServiceManager())
        	 ->setFactories($e->getApplication()->getServiceManager());
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
//     	$serviceLocator
//     		->setInvokableClass('SensorReadingModel', 'WateringSystem\Model\SensorReadingModel');
    	return $this;
    }

    /**
     * Set factories
     * @param ServiceLocatorInterface $serviceLocator
     * @return \WateringSystem\Model\SensorReadingModel|\WateringSystem\Module
     */
    protected function setFactories(ServiceLocatorInterface $serviceLocator)
    {
    	$serviceLocator
    		->setFactory('SensorReadingModel', function($serviceLocator){
    			$config = $serviceLocator->get('Config');
    			if (isset($config['sensor'])) {
    				$params = $config['sensor'];
    			} else {
    				$params = array();
    			}
    			return new SensorReadingModel($params);
    		});
    	return $this;
    }
    
    public function getViewHelperConfig()
    {
		return array (
			'factories' => array (
				'Messages' => function ($sm) {
					return new MessageHelper($sm);
				}
			)
    	);
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
