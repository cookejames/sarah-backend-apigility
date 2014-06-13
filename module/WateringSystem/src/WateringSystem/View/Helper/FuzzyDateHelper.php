<?php

namespace WateringSystem\View\Helper;

use Zend\View\Helper\AbstractHelper;

class FuzzyDateHelper extends AbstractHelper 
{

	/**
	 * Get a fuzzy date eg 1 min ago
	 * @param \DateTime $date
	 */
	public function __invoke(\DateTime $date)
	{
		$now = new \DateTime();
		//get difference in seconds
		$seconds = $now->getTimestamp() - $date->getTimestamp();
		$minutes = (int) ($seconds / 60);
		$hours = (int) ($minutes / 60);
		
		if ($seconds < 60) {
			return 'less than a minute';
		} elseif ($seconds == 60) {
			return 'a minute ago';
		} elseif ($seconds < 60 * 60) {
			return $minutes . ' minutes ago';
		} elseif ($seconds == 60 * 60) {
			return 'an hour ago';
		} elseif ($seconds < 60 * 60 * 24) {
			return $hours . ' hours ago';
		} else {
			return 'over a day ago';
		}
	}
}
