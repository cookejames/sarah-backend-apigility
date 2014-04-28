<?php
namespace WateringSystem\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends WateringSystemControllerAbstract
{
    public function indexAction()
    {
        return new ViewModel(array('sensors' => $this->getSensorModel()->getSensors()));
    }
}
