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

namespace Codeninja\iCal\Utils;

use Codeninja\iCal\Utils\Properties\ArrayPropertyValue;
use Codeninja\iCal\Utils\Properties\StringPropertyValue;
use Codeninja\iCal\Utils\Properties\IPropertyValue;

/**
 * The Property Class represents a property as defined in RFC 5545.
 *
 * The content of a line (unfolded) will be rendered in this class.
 *
 * @see https://tools.ietf.org/html/rfc5545#section-3.5
 */
class Property
{
	/**
	* The name of the Property
	*
	* @var string
	*/
	protected $name;
	
	/**
	* The value of the Property
	*
	* @var ValueInterface
	*/
	protected $value;
	
	/**
	* The params of the Property
	*
	* @var ParameterCollection
	*/
	protected $parameterCollection;
	
	/**
	* @param				$name
	* @param				$value
	* @param array	$params
	*/
	public function __construct($name, $value, $params = [])
	{
		$this->name = $name;
		$this->setValue($value);
		$this->parameterCollection = new ParameterCollection($params);
	}

	/**
	* Renders the collection parameters as line.
	*
	* @return string
	*/
	public function toLine()
	{
		// Property-name
		$line = $this->getName();
		if ($this->parameterCollection && $this->parameterCollection->hasParams()) 
		{
			$line .= ';' . $this->parameterCollection->toString();
		}
		// Property value
		$line .= ':' . $this->value->getEscapedValue();
		//e.g. DTSTART;TZID=Asia/Kolkata:20170501T080000
		return $line;
	}
	
	/**
	* @param mixed $value
	*
	* @return $this
	*
	* @throws \Exception
	*/
	public function setValue($value)
	{
		if (is_scalar($value))
		{
			$this->value = new StringPropertyValue($value);
		}
		elseif (is_array($value))
		{
			$this->value = new ArrayPropertyValue($value);
		}
		else
		{
			if (!$value instanceof IPropertyValue)
			{
				throw new \Exception('The value must implement the PropertyValueInterface');
			}
			$this->value = $value;
		}
		return $this;
	}
	
	/**
	* @return mixed
	*/
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	* @return string
	*/
	public function getName()
	{
		return $this->name;
	}
}

?>