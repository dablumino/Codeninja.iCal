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
 * The ArrayPropertyValue Class represents a array of values.
 */
class ArrayPropertyValue implements IPropertyValue
{
	/**
	* The value.
	*
	* @var array
	*/
	protected $values;
	
	/**
	* @param array	$values
	*/
	public function __construct(array $values)
	{
		$this->values = $values;
	}
	
	/**
	* @param array $values
	*
	* @return $this
	*/
	public function setValue(array $values)
	{
		$this->values = $values;
		return $this;
	}
	
	/**
	* @return array
	*/
	public function getValue()
	{
		return $this->value;
	}
	
	public function getEscapedValue() : string
	{
		return implode(',', array_map(function (string $value): string { return (new StringValue($value))->getEscapedValue();}, $this->values));
	}

}

?>