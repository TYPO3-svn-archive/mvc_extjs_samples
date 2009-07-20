<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Xavier Perseguers <typo3@perseguers.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Utilities to handle Extbase objects with ExtJS
 *
 * @category    ExtJS
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_ExtJS_Utility {

	/**
	 * Decodes an array of objects to be used by JSON later on.
	 * 
	 * @param array $objects
	 * @return array
	 */
	public static function decodeArrayForJSON(array $objects) {
		$arr = array();
		
		foreach ($objects as $object) {
			$arr[] = self::decodeObjectForJSON($object);
		}
		
		return $arr;
	}
	
	/**
	 * Decodes an object to be used by JSON later on.
	 *
	 * @param object $object
	 * @return array
	 */
	public static function decodeObjectForJSON($object) {
		if ($object instanceof DateTime) {
			return $object->format(DATE_ATOM);
		} elseif (!($object instanceof Tx_Extbase_DomainObject_AbstractEntity)) {
			return $object;
		}
		
		$arr = array();
		
		$rc = new ReflectionClass(get_class($object));
		$properties = $rc->getProperties();
		
		foreach ($properties as $property) {
			$propertyGetterName = 'get' . ucfirst($property->name);
			
			if (method_exists($object, $propertyGetterName)) {
				$value = call_user_method($propertyGetterName, $object);
				if (is_array($value)) {
					$value = self::decodeArrayForJSON($value);
				} elseif (is_object($value)) {
					$value = self::decodeObjectForJSON($value);
				}
				$arr[$property->name] = $value;
			}
		}
		
		return $arr;
	}
	
}
?>