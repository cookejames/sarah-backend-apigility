<?php
namespace Sensors\V1\Rpc\UpdateWeather;

class UpdateWeatherControllerFactory
{
    public function __invoke(Zend\Mvc\Controller\ControllerManager $controllers)
    {
        $model = $controllers->getServiceLocator()->get('WeatherModel');
        return new UpdateWeatherController($model);
    }
}
