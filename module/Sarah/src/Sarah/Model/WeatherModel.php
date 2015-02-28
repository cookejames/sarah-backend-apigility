<?php

namespace Sarah\Model;

use Sarah\Entity\Sensor;
use Sarah\Entity\SensorValue;
use Doctrine\ORM\Query;
/**
 * Get weather information for locations
 * @author James Cooke
 *
 */
class WeatherModel extends SarahModelAbstract 
{
	protected $url;
	protected $path;
	protected $default_location;
	protected $apiId;
	protected $sensorIds;
	
	public function __construct(array $config)
	{
		if (!isset($config['url']) || !isset($config['path']) || !isset($config['default_location'])) {
			throw new \Exception('Missing required config option');
		}
		
		$this->url                = $config['url'];
		$this->path               = $config['path'];
		$this->default_location   = $config['default_location'];
		$this->apiId              = (empty($config['api_id'])) ? null : $config['api_id'];
		$this->sensorIds          = (is_array($config['sensors'])) ? $config['sensors'] : array();
	}
	
	/**
	 * Get the weather for a location
	 * @param string $location
	 * @return boolean|mixed
	 */
	public function getWeather($location = null)
	{
		if (is_null($location)) {
			$location = $this->default_location;
		}
		$json = file_get_contents($this->getApiUrl($location));
		$object = json_decode($json);
		
		$result = array();
		
		//get api measurements
		if (($value = $this->getApiCloudiness($object)) == true) {
			$result[] = $value;
		}
		
		if (($value = $this->getApiHumidity($object)) == true) {
			$result[] = $value;
		}
		
		if (($value = $this->getApiPressure($object)) == true) {
			$result[] = $value;
		}
		
		if (($value = $this->getApiTemperature($object)) == true) {
			$result[] = $value;
		}
		
		return $result;
	}
	
	/**
	 * @return SensorModel
	 */
	protected function getSensorModel()
	{
		$model = $this->getServiceLocator()->get('SensorModel');
		$model->setHydrationMode(Query::HYDRATE_OBJECT);
		return $model;
	}
	
	/**
	 * Get the api pressure from the parsed json object
	 * @param \stdClass $object
	 * @return boolean|\sarah\Entity\SensorValue
	 */
	protected function getApiPressure(\stdClass $object)
	{
		if (!isset($object->main) || !isset($object->main->pressure) || !isset($this->sensorIds['pressure'])) {
			return false;
		}
		
		return $this->getApiReading($object->main->pressure, $this->sensorIds['pressure']);
	}
	
	/**
	 * Get the api temperature from the parsed json object
	 * @param \stdClass $object
	 * @return boolean|\sarah\Entity\SensorValue
	 */
	protected function getApiTemperature(\stdClass $object)
	{
		if (!isset($object->main) || !isset($object->main->temp) || !isset($this->sensorIds['temperature'])) {
			return false;
		}
	
		return $this->getApiReading($object->main->temp, $this->sensorIds['temperature']);
	}
	
	/**
	 * Get the api cloudiness from the parsed json object
	 * @param \stdClass $object
	 * @return boolean|\sarah\Entity\SensorValue
	 */
	protected function getApiCloudiness(\stdClass $object)
	{
		if (!isset($object->clouds) || !isset($object->clouds->all) || !isset($this->sensorIds['cloudiness'])) {
			return false;
		}
	
		return $this->getApiReading($object->clouds->all, $this->sensorIds['cloudiness']);
	}
	
	/**
	 * Get the api humidity from the parsed json object
	 * @param \stdClass $object
	 * @return boolean|\sarah\Entity\SensorValue
	 */
	protected function getApiHumidity(\stdClass $object)
	{
		if (!isset($object->main) || !isset($object->main->humidity) || !isset($this->sensorIds['humidity'])) {
			return false;
		}
	
		return $this->getApiReading($object->main->humidity, $this->sensorIds['humidity']);
	}
	
	/**
	 * Get a sensor value for a sensor
	 * @param \stdClass $object
	 * @return boolean|\sarah\Entity\SensorValue
	 */
	protected function getApiReading($value, $sensorId)
	{
		$sensor = $this->getSensorModel()->getSensorById($sensorId);
		if ($sensor instanceof Sensor) {
			$sensorValue = new SensorValue();
			$sensorValue->setSensor($sensor)
						->setValue($value);
				
			return $sensorValue;
		}
	
		return false;
	}
	
	/**
	 * Get a contructed api url for a specified location
	 * @param string $location
	 * @return string
	 */
	protected function getApiUrl($location)
	{
		$url = $this->url . $this->path . $location;
		return (is_null($this->apiId)) ? $url : $url . '&APPID=' . $this->apiId;
	}
}