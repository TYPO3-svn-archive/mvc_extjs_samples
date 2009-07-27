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
 * Utilities to manage the modules of an extension.
 *
 * @category    Extbase
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_Utility_Module {

	/**
	 * Registers an Extbase module (main or sub) to the backend interface.
	 * FOR USE IN ext_tables.php FILES
	 *
	 * @param string $extensionName The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	 * @param string $controller This is the main controller of the module
	 * @param string $action This is the default action of the module's controller
	 * @param array $config The configuration options of the module (icon, locallang.xml file)
	 * @param string $main The main module key, $sub is the submodule key. So $main would be an index in the $TBE_MODULES array and $sub could be an element in the lists there. If $main is not set a blank $extensionName module is created
	 * @param string $sub The submodule key. If $sub is not set a blank $main module is created
	 * @param string $position This can be used to set the position of the $sub module within the list of existing submodules for the main module. $position has this syntax: [cmd]:[submodule-key]. cmd can be "after", "before" or "top" (or blank which is default). If "after"/"before" then submodule will be inserted after/before the existing submodule with [submodule-key] if found. If not found, the bottom of list. If "top" the module is inserted in the top of the submodule list.
	 * @return void
	 */
	public static function registerModule($extensionName, $controller, $action, $config = array(), $main = '', $sub = '', $position = '') {
		if (empty($extensionName)) {
			throw new InvalidArgumentException('The extension name was invalid (must not be empty and must match /[A-Za-z][_A-Za-z0-9]/)', 1239891989);
		}
		$extensionKey = $extensionName;
		$extensionName = str_replace(' ', '', ucwords(str_replace('_', ' ', $extensionName)));
		
		if (!isset($GLOBALS['TBE_EXTBASE_MODULES'])) {
			$GLOBALS['TBE_EXTBASE_MODULES'] = array();
		}
		
		if ($main && !isset($GLOBALS['TBE_MODULES'][$main])) {
			$main = $extensionName . ucfirst($main);
		} else {
			$main = $main ? $main : $extensionName;
		}
		
		if (!is_array($config) || count($config) == 0) {
			$config['access'] = 'admin';
			$config['icon'] = '';
			$config['labels'] = '';
		}
		
		$key = $main . ($sub ? '_' . $sub : '');
		
		$moduleConfig = array(
			'name' => $key,
			'extensionKey' => $extensionKey,	
			'extension' => $extensionName,
			'controller' => $controller,
			'action' => $action,
			'config' => $config,
		);
		$GLOBALS['TBE_EXTBASE_MODULES'][$key] = $moduleConfig;
		
			// Add the module to the backend
		$path = t3lib_extMgm::extPath('mvc_extjs_samples') . 'Classes/';
		t3lib_extMgm::addModule($main, $sub, $position, $path);
	}
	
}
?>