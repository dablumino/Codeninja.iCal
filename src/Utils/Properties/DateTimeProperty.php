<?php
/*
 * This file is part of the Codeninja/iCal package.
 *
 * @Copyright (C) Daniel Blum. All rights reserved.
 * @website http://codeninja.eu
 *
 * Use of this source code is governed by an MIT-style license that can be
 * found in the LICENSE file.
 */

namespace Codeninja\iCal\Utils\Properties;

use Codeninja\iCal\Utils\Property;

/**
 * The DateTimeProperty Class represents a single Property.
 */
class DateTimeProperty extends Property
{
	
	/**
	* @param string             $name
	* @param \DateTimeInterface $dateTime
	* @param bool               $isAllDay
	* @param bool               $useTimezone
	* @param bool               $useUtc
	* @param string             $timezoneString
	*/
	public function __construct($name, \DateTimeInterface $dateTime = null, $isAllDay = false, $useTimezone = false, $useUtc = false, $timezoneString = '')
	{
		if (empty($dateTime))
		{
			$dateTime = new \DateTimeImmutable();
		}
		
		$dateString = $dateTime->format($this->getDateFormat($isAllDay, $useTimezone, $useUtc));
		$params = $this->getDefaultParams($dateTime, $isAllDay, $useTimezone, $timezoneString);
		parent::__construct($name, $dateString, $params);
	}
	
	/**
	* @return string
	*/
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	* @param \DateTimeInterface $dateTime
	* @param bool               $isAllDay
	* @param bool               $useTimezone
	* @param string             $timezoneString
	*
	* @return string
	*/
	public function getDefaultParams(\DateTimeInterface $dateTime = null, $isAllDay = false, $useTimezone = false, $timezoneString = '')
	{
		$params = [];
		if ($useTimezone && $isAllDay === false)
		{
			$timeZone = $timezoneString === '' ? $dateTime->getTimezone()->getName() : $timezoneString;
			$params['TZID'] = $timeZone;
		}
		if ($isAllDay)
		{
			$params['VALUE'] = 'DATE';
		}
		return $params;
	}
	
	/**
	* @param bool               $isAllDay
	* @param bool               $useTimezone
	* @param bool               $useUtc
	*
	* @return string
	*/
	private function getDateFormat($isAllDay = false, $useTimezone = false, $useUtc = false)
	{
		// Do not use UTC time (Z) if timezone support is enabled.
		if ($useTimezone || !$useUtc) 
		{
			return $isAllDay ? 'Ymd' : 'Ymd\THis';
		}
		return $isAllDay ? 'Ymd' : 'Ymd\THis\Z';
	}

}

?>