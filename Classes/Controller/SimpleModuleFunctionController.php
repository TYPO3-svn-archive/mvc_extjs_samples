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
 * The simple module function controller for the MVC_ExtJS_Samples package.
 *
 * @category    Controller
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_Controller_SimpleModuleFunctionController extends Tx_MvcExtjs_ExtJS_Controller_ExtensionObjectActionController {

	/**
	 * Initializes the menu entries.
	 */
	public function menuConfig() {
		$this->toolbar->setFunctionMenu(array(
			//'BlankModule->first' => 'My first action',
			//'BlankModule->second' => 'My second action',
			//'BlankModule->third' => 'My third action',
		));
	}

	/**
	 * Default action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->view->assign('title', 'This is my title');
	}

	/**
	 * Other action that is available from indexAction through a link.
	 * 
	 * @return string the rendered view
	 */
	public function otherAction() {
		// Nothing to do
	}

}
?>