<?php
namespace WateringSystem\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends WateringSystemControllerAbstract
{
    public function indexAction()
    {
        return new ViewModel(
        		array(
        				'nodes' => $this->getNodeModel()->getNodes()
        		)
        );
    }
}
