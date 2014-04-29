<?php
namespace WateringSystem;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use WateringSystem\Model\SensorReadingModel;
use WateringSystem\Model\SensorModel;
use WateringSystem\Model\SensorValueModel;
use WateringSystem\View\Helper\MessageHelper;
use Zend\Log\Writer\Stream;
use Zend\Log\Logger;
use WateringSystem\Model\Sensors\SensorAbstract;
use WateringSystem\View\Helper\SensorValueHelper;
use WateringSystem\View\Helper\SensorToJsonHelper;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $this->setInvokables($e->getApplication()->getServiceManager())
        	 ->setFactories($e->getApplication()->getServiceManager());
        
        //set the logger
        $logger = $e->getApplication()->getServiceManager()->get('logger');
        Logger::registerErrorHandler($logger);
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
    		->setInvokableClass('SensorValueModel', 'WateringSystem\Model\SensorValueModel')
    		->setInvokableClass('SensorModel', 'WateringSystem\Model\SensorModel');
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
    			$sensor;
    			if (isset($config['sensor'])) {
    				$params = $config['sensor'];
    				if (isset($params['class'])) {
    					$class = $params['class'];
    					$sensor = new $class($params);
    				}
    			} 
    			if (($sensor instanceof SensorAbstract) == false) {
    				throw new \Exception('Could not create a sensor from configuration');
    			}
    			return new SensorReadingModel($sensor);
    		})
    		->setFactory('logger', function($serviceLocator){
    			$config = $serviceLocator->get('config');
    			$writer = new Stream($config['logPath']);
    			$logger = new Logger();
    			$logger->addWriter($writer);
    			
    			return $logger;
    		});
    	return $this;
    }
    
    public function getViewHelperConfig()
    {
    	//set customer view helpers
		return array (
			'factories' => array (
				'Messages' => function ($sm) {
					return new MessageHelper($sm);
				},
				'SensorValue' => function ($sm) {
					return new SensorValueHelper($sm);
				},
				'SensorToJson' => function ($sm) {
					return new SensorToJsonHelper($sm);
				},
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
