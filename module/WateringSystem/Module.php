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
use WateringSystem\View\Helper\FuzzyDateHelper;
use WateringSystem\Model\PumpModel;
use WateringSystem\Model\WeatherModel;
use Zend\ServiceManager\ServiceManager;
use WateringSystem\Model\WateringModel;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    	//Set default timezone
    	date_default_timezone_set('UTC');
    	
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
    		->setInvokableClass('SensorModel', 'WateringSystem\Model\SensorModel')
    		->setInvokableClass('NodeModel', 'WateringSystem\Model\NodeModel');
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
	    	->setFactory('WateringModel', function($serviceLocator){
	    		$config = $serviceLocator->get('Config');
	    		if (isset($config['watering']) && isset($config['watering']['hysterisis'])) {
	    			return new WateringModel($config['watering']['hysterisis']);
	    		} else {
	    			return new WateringModel();
	    		}
	    	})
	    	->setFactory('WeatherModel', function($serviceLocator){
	    		$config = $serviceLocator->get('Config');
	    		if (isset($config['weather'])) {
	    			return new WeatherModel($config['weather']);
	    		} else {
	    			throw new \Exception('Could not find config item weather');
	    		}
	    	})
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
    		->setFactory('PumpModel', function($serviceLocator){
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
    			return new PumpModel($sensor);
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
				'FuzzyDate' => function ($sm) {
					return new FuzzyDateHelper($sm);
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
    
    /**
     * @param ServiceManager $serviceManager
     */
    public function setupServiceManager(ServiceManager $serviceManager)
    {
    	$this->setFactories($serviceManager)
		     ->setInvokables($serviceManager);
    }
}
