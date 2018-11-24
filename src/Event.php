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

namespace Codeninja\iCal;

use Codeninja\iCal\Utils\Component;
use Codeninja\iCal\Utils\Property;
use Codeninja\iCal\Utils\PropertyCollection;
use Codeninja\iCal\Utils\Properties\DateTimeProperty;

/**
 * Implementation of the EVENT component.
 */
class Event extends Component
{
	const TIME_TRANSPARENCY_OPAQUE = 'OPAQUE';
	const TIME_TRANSPARENCY_TRANSPARENT = 'TRANSPARENT';
	
	const STATUS_TENTATIVE = 'TENTATIVE';
	const STATUS_CONFIRMED = 'CONFIRMED';
	const STATUS_CANCELLED = 'CANCELLED';
	
	/**
	* This property defines the calendar scale used for the calendar information specified in the iCalendar object.
	*
	* According to RFC 5545: 3.7.1. Calendar Scale
	*
	* @see http://tools.ietf.org/html/rfc5545#section-3.7
	 */
	const CALSCALE_GREGORIAN = 'GREGORIAN';
	
	/**
	* @var string
	*/
	protected $uniqueId;
	
	/**
	* The property indicates the date/time that the instance of
	* the iCalendar object was created.
	*
	* The value MUST be specified in the UTC time format.
	*
	* @var \DateTime
	*/
	protected $dtStamp;
	
	/**
	* @var \DateTime
	*/
	protected $created;
	
	/**
	* @var \DateTime
	*/
	protected $dtStart;
	
	/**
	* Preferentially chosen over the duration if both are set.
	*
	* @var \DateTime
	*/
	protected $dtEnd;
	
	/**
	* @var \DateInterval
	*/
	protected $duration;
	
	/**
	* @var bool
	*/
	protected $isAllDay = false;
	
	/**
	* @var string
	*/
	protected $url;
	
	/**
	* @var string
	*/
	protected $location;
	
	/**
	* @var string
	*/
	protected $locationTitle;
	
	/**
	* @see https://tools.ietf.org/html/rfc5545#section-3.8.2.7
	*
	* @var string
	*/
	protected $transparency = self::TIME_TRANSPARENCY_OPAQUE;
	
	/**
	* If set to true the time input will be in UTC.
	*
	* @var bool
	*/
	protected $useUtc = false;
	
	/**
	* If set to true the timezone will be added to the event.
	*
	* @var bool
	*/
	protected $useTimezone = false;
	/**
	* If set will we used as the timezone identifier.
	*
	* @var string
	*/
	protected $timezoneString = '';
	
	/**
	* @see https://tools.ietf.org/html/rfc5545#section-3.8.7.4
	*
	* @var int
	*/
	protected $sequence = 0;
	
	/**
	* @see https://tools.ietf.org/html/rfc5545#section-3.8.8.3
	*
	* @var string
	*/
	protected $status;

	/**
	* @var bool
	*/
	protected $isCancelled;
	
	/**
	* @var string
	*/
	protected $summary;
	
	/**
	* @var string
	*/
	protected $description;
	
	/**
	* @var bool
	*/
	protected $isPrivate;
	
	public function __construct()
	{
	}
	
	/**
	* @param $uniqueId
	*
	* @return $this
	*/
	public function setUniqueId($uniqueId)
	{
		$this->uniqueId = $uniqueId;
		return $this;
	}
	
	/**
	* @return string
	*/
	public function getUniqueId()
	{
		return $this->uniqueId;
	}
	
	/**
	* @param $dtValue
	*
	* @return $this
	*/
	public function setDtStamp($dtValue)
	{
		$this->dtStamp = $dtValue;
		return $this;
	}
	
	/**
	* @param $dtValue
	*
	* @return $this
	*/
	public function setCreated($dtValue)
	{
		$this->created = $dtValue;
		return $this;
	}
	
	/**
	* @param $dtStart
	*
	* @return $this
	*/
	public function setDtStart($dtStart)
	{
		$this->dtStart = $dtStart;
		return $this;
	}
	
	/**
	* @return date
	*/
	public function getDtStart()
	{
		return $this->dtStart;
	}
	
	/**
	* @param $dtEnd
	*
	* @return $this
	*/
	public function setDtEnd($dtEnd)
	{
		$this->dtEnd = $dtEnd;
		return $this;
	}
	
	/**
	* @return date
	*/
	public function getDtEnd()
	{
		return $this->dtEnd;
	}
	
	/**
	 * @param $duration
	 *
	 * @return $this
	 */
	public function setDuration($duration)
	{
		$this->duration = $duration;
		return $this;
	}
	
	/**
		* @param $isAllDay
		*
		* @return $this
		*/
	public function setIsAllDay($isAllDay)
	{
		$this->isAllDay = $isAllDay;
		return $this;
	}
	
	/**
	* @param $url
	*
	* @return $this
	*/
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}
	
	/**
	* @param $useUtc
	*
	* @return $this
	*/
	public function setUseUtc($useUtc)
	{
		$this->useUtc = $useUtc;
		return $this;
	}
	
	/**
	* @param $useTimezone
	*
	* @return $this
	*/
	public function setUseTimezone($useTimezone)
	{
		$this->useTimezone = $useTimezone;
		return $this;
	}
	
	/**
	* @return bool
	*/
	public function getUseTimezone()
	{
		return $this->useTimezone;
	}
	
	/**
	* @param $timezoneString
	*
	* @return $this
	*/
	public function setTimezoneString($timezoneString)
	{
		$this->timezoneString = $timezoneString;
		return $this;
	}
	
	/**
	* @return bool
	*/
	public function getTimezoneString()
	{
		return $this->timezoneString;
	}
	
	/**
	* @param int $sequence
	*
	* @return $this
	*/
	public function setSequence($sequence)
	{
	$this->sequence = $sequence;
		return $this;
	}
	
	/**
	* @return int
	*/
	public function getSequence()
	{
		return $this->sequence;
	}

	/**
	* @param $status
	*
	* @return $this
	*
	* @throws \InvalidArgumentException
	*/
	public function setStatus($status)
	{
		switch(strtoupper($status))
		{
			case self::STATUS_TENTATIVE:
			case self::STATUS_CONFIRMED:
			case self::STATUS_CANCELLED:
				$this->status = $status;
			
			default:
				throw new \InvalidArgumentException('Invalid value for status');
		}
		return $this;
	}
	
	/**
	* @param $status
	*
	* @return $this
	*/
	public function setIsCancelled($status)
	{
		$this->isCancelled = (bool) $status;
		return $this;
	}
	
	/**
	* @param string     $location
	* @param string     $title
	*
	* @return $this
	*/
	public function setLocation($location, $title = '')
	{
		$this->location = $location;
		$this->locationTitle = $title;
		return $this;
	}
	
	/**
	* @param $summary
	*
	* @return $this
	*/
	public function setSummary($summary)
	{
		$this->summary = $summary;
		return $this;
	}
	
	/**
	* @param $description
	*
	* @return $this
	*/
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	
	/**
	* @return string
	*/
	public function getDescription()
	{
		return $this->description;
	}
	
	/**
	* The type of the Component
	*/
	public function getType()
	{
		return 'VEVENT';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildPropertyCollection()
	{
		$properties = new PropertyCollection();
		// Required properties
		$properties->set('UID', $this->uniqueId);
		$properties->add(new DateTimeProperty('DTSTART', $this->dtStart, $this->isAllDay, $this->useTimezone, $this->useUtc, $this->timezoneString));
		$properties->set('SEQUENCE', $this->sequence);
		
		if ($this->status)
		{
			$properties->set('STATUS', $this->status);
		}
		
		if ($this->isCancelled)
		{
			$propertyBag->set('STATUS', self::STATUS_CANCELLED);
		}
		
		// An event can have a 'dtend' or 'duration', but not both.
		if ($this->dtEnd !== null) 
		{
			if ($this->isAllDay === true) 
			{
				$this->dtEnd->add(new \DateInterval('P1D'));
			}
			$properties->add(new DateTimeProperty('DTEND', $this->dtEnd, $this->isAllDay, $this->useTimezone, $this->useUtc, $this->timezoneString));
		}
		elseif ($this->duration !== null)
		{
			$properties->set('DURATION', $this->duration->format('P%dDT%hH%iM%sS'));
		}
		
		$properties->add(new DateTimeProperty('DTSTAMP', $this->dtStamp ?: new \DateTimeImmutable(), false, false, true));
		if ($this->created)
		{
			$properties->add(new DateTimeProperty('CREATED', $this->created, false, false, true));
		}
		
		if ($this->isAllDay) 
		{
			$properties->set('X-MICROSOFT-CDO-ALLDAYEVENT', 'TRUE');
		}
		
		// optional properties
		if (null != $this->url) 
		{
			$properties->set('URL', $this->url);
		}
		
		if (null != $this->location) 
		{
			$properties->set('LOCATION', $this->location);
		}
		
		if (null != $this->summary) 
		{
			$properties->set('SUMMARY', $this->summary);
		}
		
		$properties->set('CLASS', $this->isPrivate ? 'PRIVATE' : 'PUBLIC');
		
		if (null != $this->description) 
		{
			$properties->set('DESCRIPTION', $this->description);
		}
		
		return $properties;
	}
}

?>