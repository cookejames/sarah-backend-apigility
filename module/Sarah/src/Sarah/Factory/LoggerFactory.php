<?php
namespace Sarah\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Log\Writer\Stream;
use Zend\Log\Logger;

class LoggerFactory implements FactoryInterface
{
	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService (\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
	{
		$config = $serviceLocator->get('config');
		$writer = new Stream($config['logPath']);
		$logger = new Logger();
		$logger->addWriter($writer);
		 
		return $logger;
	}
}