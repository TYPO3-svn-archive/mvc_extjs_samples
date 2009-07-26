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
 * The Blank backend module controller for the MVC_ExtJS_Samples package.
 *
 * @category    Controller
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Steffen Kamper <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id: BlankModuleController.php 22770 2009-07-25 15:32:38Z xperseguers $
 */
class Tx_MvcExtjsSamples_Controller_OldStyleModuleController extends Tx_MvcExtjsSamples_ExtJS_Controller_ActionController {
	
	/**
	* holds reference to the template class
	* 
	* @var template
	*/
	protected $doc;
	
	/**
	* holds reference to t3lib_SCbase
	* 
	* @var t3lib_SCbase
	*/
	protected $scBase;
	
	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		if (!$this->checkAccess($config)) {
			die('No Access!');
		}
		
		
		$settings = Tx_Extbase_Dispatcher::getSettings();
		
		
		
		// prepare scBase
		$this->scBase = t3lib_div::makeInstance('t3lib_SCbase'); 
		$this->scBase->MCONF['name'] = $settings['pluginName'];
		$this->scBase->init();
		
		// prepare template class
		$this->doc = t3lib_div::makeInstance('template'); 
		$this->doc->backPath = $GLOBALS['BACK_PATH'];
		
		$this->menuConfig();
		
		
		
		
		// template page
		$this->view->assign('title', 'OldStyle Module!');  
		
		$this->view->assign('FUNC_MENU', t3lib_BEfunc::getFuncMenu(0, 'SET[function]', $this->scBase->MOD_SETTINGS['function'], $this->scBase->MOD_MENU['function']));
		
		$this->view->assign('CSH', t3lib_BEfunc::cshItem('_MOD_web_func', '', $GLOBALS['BACK_PATH']));
		$this->view->assign('SAVE', '<input type="image" class="c-inputButton" name="submit" value="Update"' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/savedok.gif', '') . ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.saveDoc', 1) . '" />');
		$this->view->assign('SHORTCUT',  $this->doc->makeShortcutIcon('', 'function', $settings['pluginName']));
		
		
		$this->view->assign('startPage', $this->doc->startPage('OldStyle Module'));
		$this->view->assign('endPage', $this->doc->endPage());
		
		
	}
	
	/**
	* put your comment there...
	* 	
	* @param mixed $conf
	* @return bool
	*/
	protected function checkAccess($conf) {
		
		#$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
		#$access = is_array($this->pageinfo) ? 1 : 0;
		
		return TRUE; #$access;
	}
	
	/**
	 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
	 *
	 * @return	void
	 */
	function menuConfig()	{
		$this->scBase->MOD_MENU = Array (
			'function' => Array (
				'1' => 'Menu 1',
				'2' => 'Menu 2',
				'3' => 'Menu 3',
			)
		);
		$this->scBase->menuConfig();
	}
	
	
}
?>