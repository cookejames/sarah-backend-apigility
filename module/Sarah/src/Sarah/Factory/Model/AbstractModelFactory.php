<?php
namespace Sarah\Factory\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractModelFactory implements FactoryInterface
{
	protected function getEntityManager()
	{
		return $this->getServiceLocator()->get('VrApi\VrDatabase\Doctrine\CamspatialEntityManager');
	}
	
	/**
	 * @var ServiceLocatorInterface
	 */
	private $serviceLocator;
	
	/**
	 * @return \Zend\ServiceManager\ServiceLocatorInterface
	*/
	protected function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
	abstract protected function getModel();
	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		return $this->getModel();
	}
}