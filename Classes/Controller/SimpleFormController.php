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
class Tx_MvcExtjsSamples_Controller_SimpleFormController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
			// Load ExtJS libraries and stylesheets
		$GLOBALS['TSFE']->pageIncludes->loadExtJS();
		
		$ajaxUrl = $this->URIBuilder->URIFor($GLOBALS['TSFE']->id, 'genres');
		
			// Create a form with a textbox and a combobox (content loaded with AJAX)
		$GLOBALS['TSFE']->pageIncludes->addJsHandlerCode(
			'var genres = new Ext.data.Store({
				reader: new Ext.data.JsonReader({
					fields: ["id", "genre_name"],
					root: "rows"
				}),
				proxy: new Ext.data.HttpProxy({
					url: "' . $ajaxUrl . '"
				}),
				autoLoad: true
			});
			
			var movie_form = new Ext.FormPanel({
				title: "Movie Information Form",
				width: 250,
				items: [{
					xtype: "textfield",
					fieldLabel: "Title",
					name: "title",
					allowBlank: false
				},{
					xtype: "combo",
					name: "genre",
					fieldLabel: "Genre",
					mode: "local",
					store: genres,
					displayField: "genre_name",
					width: 120
				}]
			});
			
			movie_form.render("MvcExtjsSamples-SimpleForm");',
			t3lib_pageIncludes::JSHANDLER_EXTONREADY
		);
	}
	
	/**
	 * Returns a list of movive genres as JSON.
	 * 
	 * @see typo3/classes/class.typo3ajax.php
	 * @return void
	 */
	public function genresAction() {
		$arr = array(
			array('id' => 1, 'genre_name' => 'Comedy'),
			array('id' => 2, 'genre_name' => 'Drama'),
			array('id' => 3, 'genre_name' => 'Action'),
			array('id' => 4, 'genre_name' => 'Mystery'),
		);
				
			// Prepare the JSON response
		header('Content-type: text/html; charset=utf-8');
		header('X-JSON: true');
		echo '{rows:' . json_encode($arr) . '}';
		
			// Do not do further processing
		exit;
	}
	
}
?>