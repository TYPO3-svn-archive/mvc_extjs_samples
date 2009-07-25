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
class Tx_MvcExtjsSamples_Controller_ListModuleController extends Tx_MvcExtjsSamples_ExtJS_Controller_ActionController {
	
	/**
	* holds reference to the template class
	* 
	* @var template
	*/
	protected $doc;
	
	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		if (!$this->checkAccess($config)) {
			die('No Access!');
		}
		
		// prepare template class
		$this->doc = t3lib_div::makeInstance('template'); 
		$this->doc->backPath = $GLOBALS['BACK_PATH'];
		
		
		#t3lib_div::debug($this);
		
		$this->view->assign('title', 'List Module!');
		
		// template page
		
		$this->view->assign('startPage', $this->doc->startPage('List Module'));
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
	
	
}
?>