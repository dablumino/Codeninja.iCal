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
* Abstract Calender Component Class
*/
abstract class Component
{
	/**
	* Array of Components.
	*
	* @var Component[]
	*/
	protected $components = [];

	/**
	* The type of the Component
	*
	* @abstract
	*
	* @return string
	*/
	abstract public function getType();
	
	/**
	* Building the PropertyCollection.
	*
	* @abstract
	*
	* @return PropertyBag
	*/
	abstract public function buildPropertyCollection();
	
	/**
	* Renders an array containing the lines of the iCal file.
	*
	* @return array
	*/
	public function build()
	{
		$lines = [];
		
		//BEGIN:VCALENDAR
		$lines[] = sprintf('BEGIN:%s', $this->getType());
		
		/** @var $property Property */
		foreach ($this->buildPropertyCollection() as $property)
		{
			$lines[] = $property->toLine();
		}
		
		//Build also other assinged components
		$this->buildComponents($lines);
		
		$lines[] = sprintf('END:%s', $this->getType());
		//END:VCALENDAR';
		
		return $lines;
	}
	
	/**
	* Adds a Component to the collection.
	*
	* @param Component $component The Component object that will be added
	* @param null $identifier The identifier of the Component entry
	*/
	public function addComponent(Component $component, $identifier = null)
	{
		if (null == $identifier) 
		{
			$this->components[] = $component;
		}
		else
		{
			$this->components[$identifier] = $component;
		}
	}
	
	/**
	* Renders the iCal output.
	*
	* @return string
	*/
	public function render()
	{
		return implode("\r\n", $this->build());
	}
	
	/**
	* Renders the output when treating the class as a string.
	*
	* @return string
	*/
	public function __toString()
	{
		return $this->render();
	}
	
	/**
	* @param $lines
	*
	* @return array
	*/
	private function buildComponents(array &$lines)
	{
		foreach ($this->components as $component)
		{
			$type = $component->getType();
			foreach ($component->build() as $line)
			{
				$lines[] = $line;
			}
		}
	}

}

?>