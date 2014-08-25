<?php
namespace sarah\Mvc;

use ZfrCors\Mvc\CorsRequestListener;
use Zend\Mvc\MvcEvent;

class CustomCorsRequestListener extends CorsRequestListener
{
	public function onCorsRequest(MvcEvent $event)
	{
		try {
			parent::onCorsRequest($event);
		} catch(\Exception $e) {
			// I have an exception.... but I ignore it!
		}
	}
}