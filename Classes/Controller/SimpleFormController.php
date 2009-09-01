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
 * The SimpleForm controller for the MVC_ExtJS_Samples package.
 *
 * @category    Controller
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_Controller_SimpleFormController extends Tx_MvcExtjs_ExtJS_Controller_ActionController {
	
	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->initializeExtJSAction();
		
		if (TYPO3_MODE === 'FE') {
				// value 1249058971 is the same as in /Configuration/TypoScript/ajax.txt
			$this->uriBuilder->setTargetPageType(1249058971);
		}
		$ajaxUrl = $this->uriBuilder->uriFor('index', array(), 'Genre');
		
			// Create a data store with movie genres
		$this->addJsInlineCode('
			var genres = new Ext.data.Store({
				reader: ' . Tx_MvcExtjs_ExtJS_Utility::getJSONReader('Tx_MvcExtjsSamples_Domain_Model_Genre') . ',
				proxy: new Ext.data.HttpProxy({
					url: "' . $ajaxUrl . '"
				}),
				autoLoad: true
			});
		');
		
			// Create a form with a textbox and a combobox
		$this->addJsInlineCode('
			var movie_form = new Ext.FormPanel({
				title: ' . $this->getExtJSLabelKey('index.caption') . ',
				width: 250,
				items: [{
					xtype: "textfield",
					fieldLabel: ' . $this->getExtJSLabelKey('index.title') . ',
					name: "title",
					allowBlank: false
				},{
					xtype: "combo",
					triggerAction: "all",
					name: "genre",
					fieldLabel: ' . $this->getExtJSLabelKey('index.genre') . ',
					mode: "local",
					store: genres,
					displayField: "name",
					width: 120
				}]
			});
		');
		
		if (TYPO3_MODE === 'FE') {
			$this->addJsInlineCode('
				movie_form.render("MvcExtjsSamples-SimpleForm");
			');
			$this->outputJsCode();
		} else {	// TYPO3_MODE === 'BE'
			$this->renderExtJSModule('movie_form');	
		}	
	}
	
}
?>