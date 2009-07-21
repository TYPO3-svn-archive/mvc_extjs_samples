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
 * The Movie controller for the MVC_ExtJS_Samples package.
 *
 * @category    Controller
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_Controller_MovieController extends Tx_MvcExtjsSamples_ExtJS_Controller_ActionController {

	/**
	 * @var Tx_MvcExtjsSamples_Domain_Model_MovieRepository
	 */
	protected $movieRepository;

	/**
	 * Initializes the current action.
	 *
	 * @return void
	 */
	public function initializeAction() {		
		$this->movieRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Model_MovieRepository');
	}

	/**
	 * Index action for this controller. Displays a list of movies.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->initializeExtJSAction();
		
		$ajaxUrl = $this->URIBuilder->URIFor($GLOBALS['TSFE']->id, 'movies');
		
			// Store the relative path to image directories
		$this->settingsExtJS->assign('coverPath', $this->extRelPath . 'Resources/Public/Images/');
		$this->settingsExtJS->assign('iconsPath', $this->extRelPath . 'Resources/Public/Icons/');
		
			// Create a data store with movies grouped by genre
		$this->addJsInlineCode('
			var movies = new Ext.data.GroupingStore({
				proxy: new Ext.data.HttpProxy({
					url: "' . $ajaxUrl . '"
				}),
				sortInfo: {
					field: "genre",
					direction: "ASC"
				},
				groupField: "genre",
				reader: ' . Tx_MvcExtjsSamples_ExtJS_Utility::getJSONReader('Tx_MvcExtjsSamples_Domain_Model_Movie') . ',
				autoLoad: true
			});
		');
		
			// Create renderer functions
		$this->addJsInlineCode('
			function title_img(val, x, store) {
				return "<img src=\"" + ' . $this->settingsExtJS->getExtJS('coverPath') . ' + "movie-" + store.data.uid + ".jpg\" style=\"width:50px; height:70px; float:left; margin-right:5px;\" />" +
					"<b style=\"text-size:larger;\">" + val + "</b><br />" +
					' . $this->getExtJSLabelKey('index.director') . ' + ": <i>" + store.data.director + "</i><br />" +
					store.data.tagline;
			}
		');
		
			// [START] Complex layout (split among multiple call to $this->addJsInlineCode)
		$this->addJsInlineCode('
			var complexLayout = new Ext.Panel({
				height: 400,
				layout: "border",
				items: [
		');
		
			// Create the toolbar
		$this->addJsInlineCode('
				{
					region: "north",
					xtype: "toolbar",
					height: 28,
					items: [{
						xtype: "tbspacer"
					},{
						xtype: "tbbutton",
						text: ' . $this->getExtJSLabelKey('index.movie.add') . ',
						icon: ' . $this->settingsExtJS->getExtJS('iconsPath') . ' + "movie_add.png",
						cls: "x-btn-text-icon",
						handler: function(btn) {
							Ext.Msg.alert("Movie", "Will now add a movie...");
						}
					},{
						xtype: "tbbutton",
						text: ' . $this->getExtJSLabelKey('index.movie.remove') . ',
						icon: ' . $this->settingsExtJS->getExtJS('iconsPath') . ' + "movie_delete.png",
						cls: "x-btn-text-icon",
						handler: function(btn) {
							Ext.Msg.alert("Movie", "Will now remove selected movie...");
						}
					}]
				},
		');
		
			// Create the movie edit form
		$this->addJsInlineCode('
				{
					region: "west",
					xtype: "panel",
					split: true,
					width: 300,
					html: "Movie edit form goes here..."
				},
		');
		
			// Create the movie grid
		$this->addJsInlineCode('
				{
					region: "center",
					xtype: "grid",
					store: movies,
					stripeRows: true,
					loadMask: true,
					columns: [ 
						{id: "title", header: ' . $this->getExtJSLabelKey('index.title') . ', dataIndex: "title", renderer: title_img},
						{header: ' . $this->getExtJSLabelKey('index.director') . ', dataIndex: "director", hidden: true},
						{header: ' . $this->getExtJSLabelKey('index.released') . ', dataIndex: "releaseDate", renderer: Ext.util.Format.dateRenderer("d.m.Y"), sortable: true},
						{header: ' . $this->getExtJSLabelKey('index.genre') . ', dataIndex: "genre", hidden: true, renderer: function(v,r,o){return v.name;}},
						{header: ' . $this->getExtJSLabelKey('index.tagline') . ', dataIndex: "tagline", hidden: true}
					],
					autoExpandColumn: "title",
					view: new Ext.grid.GroupingView()
				}
		');
				
			// [END] Copmlex layout: close it and... render it!
		$this->addJsInlineCode('
				]
			});
			
			complexLayout.render("MvcExtjsSamples-Movie");
		');
		
		$this->outputJsCode();
	}

	/**
	 * Shows a single movie.
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_Movie $movie The movie to show
	 * @return string The rendered view of a single movie
	 */
	public function showAction(Tx_MvcExtjsSamples_Domain_Model_Movie $movie) {
		$this->forward('index', 'Movie', NULL, array('movie' => $movie));
	}
	
	/**
	 * Returns a list of movies as JSON.
	 * 
	 * @see typo3/classes/class.typo3ajax.php
	 * @return void
	 * @ajax
	 */
	public function moviesAction() {
		$movieRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Model_MovieRepository');
		/* @var $movieRepository Tx_MvcExtjsSamples_Domain_Model_MovieRepository */
		
			// Retrieve all movies from repository
		$movies = $movieRepository->findAll();
		
			// Convert Tx_MvcExtjsSamples_Domain_Model_Movie objects to an array
		$arr = Tx_MvcExtjsSamples_ExtJS_Utility::decodeArrayForJSON($movies);
		
			// Prepare the JSON response
		header('Content-type: text/html; charset=utf-8');
		header('X-JSON: true');
		
		echo Tx_MvcExtjsSamples_ExtJS_Utility::getJSON($arr);
		
			// Do not do further processing
		exit;
	}

}
?>