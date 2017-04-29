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
* The ParameterCollection Class could hold additional parameter values
*/
class ParameterCollection
{
	/**
	* @var array
	*/
	protected $params = [];
	
		/**
	* Constructor
	*
	* @param mixed  $params
	*/
	public function __construct($params = [])
	{
		$this->params = $params;
	}
	
	/**
	* @param string $name
	* @param mixed  $value
	*/
	public function setValue($name, $value)
	{
		$this->params[$name] = $value;
	}
	
	/**
	* @param $name
	*
	* @return array|mixed
	*/
	public function getValue($name)
	{
		if (isset($this->params[$name]))
		{
			return $this->params[$name];
		}
		return null;
	}
	
	/**
	* Checks if there are any params.
	*
	* @return bool
	*/
	public function hasParams()
	{
		return (count($this->params) > 0);
	}
	
	/**
	* Returns an escaped string for a param value.
	*
	* @param string $value
	*
	* @return string
	*/
	private function escapeValue($value)
	{
		$value = str_replace(array('\\', "\n"), array('\\\\', '\\n'), $value);
		$value = str_replace('"', '\"', $value, $count);
		if (strpos($value, ';') !== false 
			|| strpos($value, ',') !== false 
			|| strpos($value, ':')  !== false 
			|| $count)
		{
			$value = '"' . $value . '"';
		}
		return $value;
	}
	
	/**
	* @return string
	*/
	public function toString()
	{
		$line = '';
		foreach ($this->params as $param => $paramValues) 
		{
			//echo "Param ".$param. ".toString() ";
			if (!is_array($paramValues)) 
			{
				$paramValues = [$paramValues];
			}
			
			foreach ($paramValues as $k => $v) 
			{
				//$paramValues[$k] = $this->escapeParamValue($v);
				$paramValues[$k] = $v;
			}
		
			if ('' != $line) 
			{
				$line .= ';';
			}
			$line .= $param . '=' . implode(',', $paramValues);
		}
		return $line;
	}
	
	/**
	* @return string
	*/
	public function __toString()
	{
		return $this->toString();
	}
}

?>