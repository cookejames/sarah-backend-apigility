<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
	'logPath' => 'logs/log',
	'watering' => array(
		'hysterisis' => 3600, //number of seconds before pump will run since last run
		'pumpName'	=> 'p1', //the sensor name of our pump
	),
);
