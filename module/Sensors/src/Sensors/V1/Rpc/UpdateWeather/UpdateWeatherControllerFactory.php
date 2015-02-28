<?php
namespace Sensors\V1\Rpc\UpdateWeather;

use Zend\Mvc\Controller\ControllerManager;
class UpdateWeatherControllerFactory
{
    public function __invoke(ControllerManager $controllers)
    {
        $model = $controllers->getServiceLocator()->get('WeatherModel');
        return new UpdateWeatherController($model);
    }
}
