<?php
namespace Sarah\Factory\Mvc;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfrCors\Mvc\CorsRequestListener;
use ZfrCors\Service\CorsService;
use Sarah\Mvc\CustomCorsRequestListener;

/**
 * CustomCorsRequestListenerFactory
 */
class CustomCorsRequestListenerFactory implements FactoryInterface
{
	/**
	 * {@inheritDoc}
	 * @return CorsRequestListener
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		/* @var $corsService CorsService */
		$corsService = $serviceLocator->get('ZfrCors\Service\CorsService');

		return new CustomCorsRequestListener($corsService);
	}
}