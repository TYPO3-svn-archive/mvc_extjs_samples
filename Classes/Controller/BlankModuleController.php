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
		
		$this->toolbar->setButtonViewCallback('Ext.Msg.alert("Toolbar Button Clicked!", "You clicked on the VIEW button!");');
		$this->toolbar->addButton(
			'EXT:mvc_extjs_samples/Resources/Public/Icons/movie_add.png',
			'Ext.Msg.alert("Movie Management", "You want to add a movie!");',
			'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/extjs.Movie.xml:index.movie.add'
		);
		
		$this->addJsInlineCode('
			var mod1 = new Ext.Panel({
				title: "Blank Module / First Action",
				html: "<p>Here is the really great Blank Module content with ' .
					'<a href=\"' . $this->URIFor('mod.php', 'index', array(), 'SimpleForm') . '\">a link to the SimpleForm controller</a>.</p>' .
					'<p>BTW, did you clicked on the magnifier toolbar button?</p>",
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
		
		$this->toolbar->setButtonEditCallback('Ext.Msg.alert("Toolbar Button Clicked!", "You clicked on the EDIT button!");');
		$this->toolbar->setButtonSaveCallback('Ext.Msg.alert("Toolbar Button Clicked!", "You clicked on the SAVE button!");');
		
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
				html: "Very well, this is the third and last action available. Did you see that it creates a Flash message?",
				border: false
			});
		');
		
			// Add a flash message 
		$message = t3lib_div::makeInstance('t3lib_FlashMessage',
			sprintf('Initiated by action "%s". Current date is %s', $this->request->getControllerActionName(), date('d.m.Y h:i:s', time())),
			'Flash title: ' . $this->request->getPluginName(),
			t3lib_FlashMessage::INFO
		);
		$this->pushFlashMessage($message);
		
		$this->renderExtJSModule('mod1');
	}
	
}
?>