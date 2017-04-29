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

/**
* Custom Autoloader Class for the iCal package.
*/
class Autoloader
{
	private static $loader;

	public static function loadClassLoader()
	{
		if (null !== self::$loader) 
		{
			return self::$loader;
		}
		self::$loader = new Autoloader();
	}
	
	private static $namespaces;
	
	public static function setNamespaceMap($value)
	{
		self::$namespaces = $value;
	}
		
	public function __construct()
	{
		$this->register();
	}

	/**
	 * Loads the given class or interface.
	 *
	 * @param  string    $class The name of the class
	 * @return bool|null True if loaded, null otherwise
	 */
	public function loadClass($class)
	{
		//autoload psr-4 replace
		if(self::$namespaces)
		{
			foreach(self::$namespaces as $source => $target)
			{
				$class = str_replace($source, $target, $class);
			}
		}
		
		$file = __DIR__ .'/'.str_replace('\\','/', $class).'.php';
		if(file_exists($file))
		{
			require_once($file);
			return true;
		}
	}
	
	/**
	* Registers this instance as an autoloader.
	*
	* @param bool $prepend Whether to prepend the autoloader or not
	*/
	public function register($prepend = false)
	{
		spl_autoload_register(array($this, 'loadClass'), true, $prepend);
	}

	/**
	 * Unregisters this instance as an autoloader.
	 */
	public function unregister()
	{
		spl_autoload_unregister(array($this, 'loadClass'));
	}
}

Autoloader::setNamespaceMap(array('Codeninja\iCal' => 'src'));
Autoloader::loadClassLoader();
	
?>
