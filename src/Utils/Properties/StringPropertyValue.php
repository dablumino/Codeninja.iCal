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

/**
 * The StringPropertyValue Class represents a single String.
 */
class StringPropertyValue implements IPropertyValue
{
	/**
	* The value
	*
	* @var array
	*/
	protected $value;
	
	/**
	* @param array $values
	*/
	public function __construct($value)
	{
		$this->value = $value;
	}
	
	/**
	* @param string $value
	*
	* @return $this
	*/
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}
	
	/**
	* @return string
	*/
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	* @return escaped string
	*/
	public function getEscapedValue()
	{
		$value = $this->value;
		$value = str_replace('\\', '\\\\', $value);
		$value = str_replace('"', '\\"', $value);
		$value = str_replace(',', '\\,', $value);
		$value = str_replace(';', '\\;', $value);
		$value = str_replace("\n", '\\n', $value);
		$value = str_replace([
			"\x00", "\x01", "\x02", "\x03", "\x04", "\x05", "\x06", "\x07",
			"\x08", "\x09", /* \n*/ "\x0B", "\x0C", "\x0D", "\x0E", "\x0F",
			"\x10", "\x11", "\x12", "\x13", "\x14", "\x15", "\x16", "\x17",
			"\x18", "\x19", "\x1A", "\x1B", "\x1C", "\x1D", "\x1E", "\x1F",
			"\x7F",
		], '', $value);
		return $value;
	}

}

?>