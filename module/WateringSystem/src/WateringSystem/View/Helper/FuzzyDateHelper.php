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
		$diff = $now->diff($date);
		
		$minutes = $diff->h * 60 + $diff->m;
		$hours = $diff->h;
		
		if ($minutes == 0) {
			return 'less than a minute';
		} elseif ($minutes == 1) {
			return 'a minute ago';
		} elseif ($minutes < 60) {
			return $minutes . ' minutes ago';
		} elseif ($hours == 1) {
			return 'an hour ago';
		} elseif ($hours < 24) {
			return $hours . ' hours ago';
		} else {
			return 'over a day';
		}
	}
}
