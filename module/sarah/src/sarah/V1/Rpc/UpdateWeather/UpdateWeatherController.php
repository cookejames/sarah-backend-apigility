<?php
namespace sarah\V1\Rpc\UpdateWeather;

use Zend\Mvc\Controller\AbstractActionController;
use sarah\Model\WeatherModel;

class UpdateWeatherController extends AbstractActionController
{
    /**
     * @var WeatherModel
     */
    private $model;
    
    public function __construct(WeatherModel $model)
    {
        $this->model = $model;
    }
    public function updateWeatherAction()
    {
        $weather = $this->model->getWeather();
        foreach ($weather as $entity) {
            $this->model->saveEntity($entity);
        }
        //TODO return correct HAL JSON links
        return array('sucess' => true);
    }
}
