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
		
			// Extract dispatcher settings from request
		$argumentPrefix = strtolower('tx_' . $config['extensionName'] . '_' . $config['name']);
		$dispatcherParams = t3lib_div::_GP($argumentPrefix);
		
			// Extract module settings from its registration in ext_tables.php
		$controllers = array_keys($config['controllerActions']);
		$defaultController = array_shift($controllers);
		$actions = t3lib_div::trimExplode(',', $config['controllerActions'][$defaultController], true);
		$defaultAction = $actions[0];
		
			// Determine the controller and action to use
		$controller = $defaultController;
		if (isset($dispatcherParams['controller'])) {
			$requestedController = $dispatcherParams['controller'];
			if (in_array($requestedController, $controllers)) {
				$controller = $requestedController;
			}
		}
		$action = $defaultAction;
		if (isset($dispatcherParams['action'])) {
			$requestedAction = $dispatcherParams['action'];
			$controllerActions = t3lib_div::trimExplode(',', $config['controllerActions'][$controller], true);
			if (in_array($requestedAction, $controllerActions)) {
				$action = $requestedAction;
			}
		}
		
		$extbaseConfiguration = array(
			'userFunc' => 'tx_extbase_dispatcher->dispatch',
			'pluginName' => $module,
			'extensionName' => $config['extension'],
			'enableAutomaticCacheClearing' => 1,
			'controller' => $controller,
			'action' => $action,
			'switchableControllerActions.' => array()
		);
		
		$i = 1;
		foreach ($config['controllerActions'] as $controller => $actions) {
			$extbaseConfiguration['switchableControllerActions.'][$i++ . '.'] = array(
				'controller' => $controller,
				'actions' => $actions,
			);
		}
				
			// BACK_PATH is the path from the typo3/ directory from within the
			// directory containing the controller file. We are using mod.php dispatcher
			// and thus we are already within typo3/ because we call typo3/mod.php
		$GLOBALS['BACK_PATH'] = '';
		
		echo $this->dispatch('Here comes Extbase BE Module', $extbaseConfiguration);
	}
	
}
?>