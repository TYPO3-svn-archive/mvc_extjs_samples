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
 * Creates a request and dispatches it to the backend controller which was
 * specified by {TBD}, FlexForm and returns the content to the v4 framework.
 *
 * @category    Extbase
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_BackendDispatcher extends Tx_Extbase_Dispatcher {
	
	/**
	 * Calls an Extbase Backend module.
	 *
	 * @param string $module 
	 * @return void
	 */
	public function callModule($module) {
		if (!isset($GLOBALS['TBE_EXTBASE_MODULES'][$module])) {
			die('No configuration found for module ' . $module);
		}
		
		$config = $GLOBALS['TBE_EXTBASE_MODULES'][$module];
		
			// Check permissions and exit if the user has no permission for entry
		$GLOBALS['BE_USER']->modAccess($config, 1);
		
		// TODO: prepare Extbase request stuff and extract the action to use, if any
		$action = $config['action'];
		
		// TODO: should this $extbaseConfiguration actually be stored in $config instead?
		$extbaseConfiguration = array(
			'userFunc' => 'tx_extbase_dispatcher->dispatch',
			'pluginName' => $module,
			'extensionName' => $config['extension'],
			'enableAutomaticCacheClearing' => 1,
			'controller' => $config['controller'],
			'action' => $action,
			'switchableControllerActions.' => array(
				'1.' => array(
					'controller' => $config['controller'],
					'actions' => $action,
				),
			),
		);
		
			// BACK_PATH is the path from the typo3/ directory from within the
			// directory containing the controller file
		$pathExt = substr(t3lib_extMgm::extPath($config['extensionKey']), strlen(PATH_site)) . 'Classes/Controller/';
		$subdirs = count(explode('/', $pathExt)) - 1;
		if (substr($pathExt, 0, strlen(TYPO3_mainDir)) === TYPO3_mainDir) {
				// Extension is within directory typo3/ (either global or system)
			$GLOBALS['BACK_PATH'] = str_repeat('../', $subdirs - 1);
		} else {
			$GLOBALS['BACK_PATH'] = str_repeat('../', $subdirs) . TYPO3_mainDir;
		}
				
		echo $this->dispatch('Problem with Extbase', $extbaseConfiguration);
	}
	
}
?>