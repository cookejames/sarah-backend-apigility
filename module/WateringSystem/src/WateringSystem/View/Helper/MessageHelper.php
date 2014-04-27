<?php

namespace WateringSystem\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MessageHelper extends AbstractHelper implements ServiceLocatorAwareInterface 
{
	protected $serviceLocator;
	protected $openFormat = '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>';
	protected $separatorString = '</li><li>';
	protected $closeString = '</li></ul></div>';
	
	public function __invoke($renderCurrent = false)
	{
		$flash = $this->getView()->flashMessenger();
		$flash->setMessageOpenFormat($this->openFormat)
			  ->setMessageSeparatorString($this->separatorString)
			  ->setMessageCloseString($this->closeString);
		
		//use render or renderCurrent?
		$method = ($renderCurrent) ? 'renderCurrent' : 'render';
		
		$message = '';
		$message .= $flash->{$method}('error',   array('alert', 'alert-dismissable', 'alert-danger'));
		$message .= $flash->{$method}('info',    array('alert', 'alert-dismissable', 'alert-info'));
		$message .= $flash->{$method}('default', array('alert', 'alert-dismissable', 'alert-warning'));
		$message .= $flash->{$method}('success', array('alert', 'alert-dismissable', 'alert-success'));
		
		//clear messages if we have used renderCurrent to stop them displaying on next page load
		if ($renderCurrent) {
			$flash->clearCurrentMessagesFromContainer();
		}
		
		return $message;
	}
	
	/**
	 * Set service locator
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	
		return $this;
	}
	
	/**
	 * Get service locator
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator() {
		return $this->serviceLocator->getServiceLocator();
	}
}
