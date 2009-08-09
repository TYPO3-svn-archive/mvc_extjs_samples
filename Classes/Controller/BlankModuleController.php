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
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_Controller_BlankModuleController extends Tx_MvcExtjs_ExtJS_Controller_ActionController {
	
	/**
	 * Initializes the menu entries.
	 */
	public function menuConfig() {
		$this->toolbar->setFunctionMenu(array(
			'BlankModule->first' => 'My first action',
			'BlankModule->second' => 'My second action',
			'BlankModule->third' => 'My third action',
		));
	}
	
	/**
	 * First action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function firstAction() {
		$this->initializeExtJSAction();
		
		$this->addJsInlineCode('
			var mod1 = new Ext.Panel({
				title: "Blank Module / First Action",
				html: "Here is the really great Blank Module content with ' .
					'<a href=\"' . $this->URIFor('mod.php', 'index', array(), 'SimpleForm') . '\">a link to the SimpleForm controller</a>.",
				border: false
			});
		');
		
		$this->renderExtJSModule('mod1');
	}
	
	/**
	 * Second action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function secondAction() {
		$this->initializeExtJSAction();
		
		$this->addJsInlineCode('
			var mod1 = new Ext.Panel({
				title: "Second Action",
				html: "Really Great! You just called yet another action.",
				border: false
			});
		');
		
		$this->renderExtJSModule('mod1');
	}
	
	/**
	 * Third action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function thirdAction() {
		$this->initializeExtJSAction();
		
		$this->addJsInlineCode('
			var mod1 = new Ext.Panel({
				title: "Third Action",
				html: "Very well, this is the third and last action available.",
				border: false
			});
		');
		
		$this->renderExtJSModule('mod1');
	}
	
}
?>