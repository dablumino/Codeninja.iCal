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
use Codeninja\iCal\Utils\PropertyCollection;

/**
* Implementation of the Calendar component.
*/
class Calendar extends Component
{
	/**
	* Methods for calendar components.
	*
	* According to RFC 5545: 3.7.2. Method
	*
	* @see http://tools.ietf.org/html/rfc5545#section-3.7.2
	*/
	const METHOD_PUBLISH = 'PUBLISH';
	const METHOD_REQUEST = 'REQUEST';
	const METHOD_REPLY = 'REPLY';
	const METHOD_ADD = 'ADD';
	const METHOD_CANCEL = 'CANCEL';
	const METHOD_REFRESH = 'REFRESH';
	const METHOD_COUNTER = 'COUNTER';
	const METHOD_DECLINECOUNTER = 'DECLINECOUNTER';
	
	/**
	* This property defines the calendar scale used for the calendar information specified in the iCalendar object.
	*
	* According to RFC 5545: 3.7.1 Calendar Scale
	*
	* @see http://tools.ietf.org/html/rfc5545#section-3.7
	*/
	const CALSCALE_GREGORIAN = 'GREGORIAN';
	
	/**
	* This property specifies the identifier corresponding to the highest version number or the minimum and maximum range of the iCalendar specification that is required in order to interpret the iCalendar object.
	*
	* According to RFC 5545: 3.7.4 Version
	*
	* @see https://tools.ietf.org/html/rfc5545#section-3.7.4
	*/
	const VERSION = '2.0';
	
	/**
	* The Product Identifier.
	*
	* According to RFC 5545: 3.7.3 Product Identifier
	*
	* This property specifies the identifier for the product that created the Calendar object.
	*
	* @see https://tools.ietf.org/html/rfc5545#section-3.7.3
	*
	* @var string
	*/
	protected $prodId = null;
	protected $method = null;
	protected $name = null;
	
	/**
	* The type of the Component
	*/
	public function getType()
	{
		return 'VCALENDAR';
	}
	
	/**
	* @return null|string
	*/
	public function getProdId()
	{
		return $this->prodId;
	}
	
	/**
	* @param $method
	*
	* @return $this
	*/
	public function setMethod($method)
	{
		$this->method = $method;
		return $this;
	}
	
	/**
	* This property defines the calendar scale used for the calendar information specified in the iCalendar object.
	*
	* @var string
	*
	* @see https://tools.ietf.org/html/rfc5545#section-3.7.1
	* @see http://msdn.microsoft.com/en-us/library/ee237520(v=exchg.80).aspx
	*/
	protected $calendarScale = self::CALSCALE_GREGORIAN;
	
	/**
	* @param $calendarScale
	*
	* @return $this
	*/
	public function setCalendarScale($calendarScale)
	{
		$this->calendarScale = $calendarScale;
		return $this;
	}

	/**
	* @param $name
	*
	* @return $this
	*/
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Specifies a globally unique identifier for the calendar.
	 *
	 * @var string
	 *
	 * @see http://msdn.microsoft.com/en-us/library/ee179588(v=exchg.80).aspx
	 */
	protected $calId = null;
	
	public function __construct($prodId)
	{
		if (empty($prodId))
		{
			throw new \UnexpectedValueException('The value of PRODID cannot be empty!');
		}
		$this->prodId = $prodId;
	}

	/**
	* {@inheritdoc}
	 */
	public function buildPropertyCollection()
	{
		$properties = new PropertyCollection();
		$properties->set('VERSION', self::VERSION);
		$properties->set('PRODID', $this->prodId);
		if ($this->method) 
		{
			$properties->set('METHOD', $this->method);
		}
		
		if ($this->calendarScale)
		{
			$properties->set('CALSCALE', $this->calendarScale);
			$properties->set('X-MICROSOFT-CALSCALE', $this->calendarScale);
		}
		
		if ($this->calId)
		{
			$properties->set('X-WR-RELCALID', $this->calId);
		}
		
		return $properties;
	}
	
	/**
	* Alias for addComponent()
	*
	* @param Event $event
	*/
	public function addEvent(Event $event)
	{
		$this->addComponent($event);
	}
}

?>