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
 * The Intrface base for all property values.
 */
interface IPropertyValue
{
	/**
	* Set the value of the Property
	*
	* @return $this
	*/
	public function setValue($value);
	
	/**
	* Return the value of the Property
	*
	* @return $this
	*/
	public function getValue();
	
	/**
	* Return the value of the Property as an escaped string
	*
	* @return string
	*/
	public function getEscapedValue();
}

?>