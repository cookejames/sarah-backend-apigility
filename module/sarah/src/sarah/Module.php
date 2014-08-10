<?php
namespace sarah;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use sarah\Model\SensorReadingModel;
use sarah\Model\SensorModel;
use sarah\Model\SensorValueModel;
use sarah\View\Helper\MessageHelper;
use Zend\Log\Writer\Stream;
use Zend\Log\Logger;
use sarah\Model\Sensors\SensorAbstract;
use sarah\View\Helper\SensorValueHelper;
use sarah\View\Helper\SensorToJsonHelper;
use sarah\View\Helper\FuzzyDateHelper;
use sarah\Model\PumpModel;
use sarah\Model\WeatherModel;
use Zend\ServiceManager\ServiceManager;
use sarah\Model\WateringModel;
use sarah\View\Helper\CounterHelper;

class Module implements ApigilityProviderInterface
{
	public function onBootstrap(MvcEvent $e)
	{
		//Set default timezone
		date_default_timezone_set('UTC');

		$this->setInvokables($e->getApplication()->getServiceManager())
			->setFactories($e->getApplication()->getServiceManager());
	
		//set the logger
		$logger = $e->getApplication()->getServiceManager()->get('logger');
		Logger::registerErrorHandler($logger);
	}
	
	/**
	 * Set invokables
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return \sarah\Module
	 */
	protected function setInvokables(ServiceLocatorInterface $serviceLocator)
	{
		$serviceLocator
		->setInvokableClass('SensorValueModel', 'sarah\Model\SensorValueModel')
		->setInvokableClass('SensorModel', 'sarah\Model\SensorModel')
		->setInvokableClass('NodeModel', 'sarah\Model\NodeModel');
		return $this;
	}
	
	/**
	 * Set factories
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return \sarah\Model\SensorReadingModel|\sarah\Module
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
