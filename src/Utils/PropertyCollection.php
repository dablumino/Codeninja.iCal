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

/**
* The PropertyCollection Class
*/
class PropertyCollection implements \IteratorAggregate
{
	/**
	* @var array
	*/
	protected $elements = [];

	/**
	* Creates a new Property with $name, $value and $params.
	*
	* @param       $name
	* @param       $value
	* @param array $params
	*
	* @return $this
	*/
	public function set($name, $value, $params = [])
	{
		$this->add(new Property($name, $value, $params));
		return $this;
	}
	
	/**
	* @param string $name
	*
	* @return null|Property
	*/
	public function get(string $name)
	{
		if (isset($this->elements[$name]))
		{
			return $this->elements[$name];
		}
		return null;
	}
	
	/**
	* Adds a Property. If Property already exists an Exception will be thrown.
	*
	* @param Property $property
	*
	* @return $this
	*
	* @throws \Exception
	*/
	public function add(Property $property)
	{
		$name = $property->getName();
		if (isset($this->elements[$name]))
		{
			throw new \Exception("Property with same name '{$name}' already exists");
		}
		$this->elements[$name] = $property;
		return $this;
	}
	
	public function getIterator()
	{
		return new \ArrayObject($this->elements);
	}
	
	/**
	* @return string
	*/
	public function toString()
	{
		$line = '';
		foreach ($this->elements as $param => $paramValues) 
		{
			if (!is_array($paramValues)) 
			{
				$paramValues = [$paramValues];
			}
			
			foreach ($paramValues as $k => $v) 
			{
				$paramValues[$k] = $this->escapeParamValue($v);
			}
		
			if ('' != $line) 
			{
				$line .= ';';
			}
			$line .= $param . '=' . implode(',', $paramValues);
		}
		return $line;
	}
}

?>