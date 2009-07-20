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
		
			// Create a data store with movie genres
		$this->addJsInlineCode('
			var movies = new Ext.data.Store({
				reader: new Ext.data.JsonReader({
					fields: [
						"title",
						"director",
						{name: "releaseDate", type: "date"},
						"filmedIn",
						"isBad",
						"genre",
						"uid"
					],
					root: "results",
					totalProperty: "totalItems"
				}),
				proxy: new Ext.data.HttpProxy({
					url: "' . $ajaxUrl . '"
				}),
				autoLoad: true
			});
		');
		
			// Create the Grid
		$this->addJsInlineCode('
			var grid = new Ext.grid.GridPanel({
				title: "List of Movies",
				height: 200,
				width: 600,
				store: movies,
				stripeRows: true,
				loadMask: true,
				columns: [
					{header: "Title", dataIndex: "title"},
					{header: "Director", dataIndex: "director"},
					{header: "Released", dataIndex: "releaseDate",
					 renderer: Ext.util.Format.dateRenderer("d.m.Y")},
					{header: "Genre", dataIndex: "genre"}
				]
			});
			
			grid.render("MvcExtjsSamples-Movie");
		');
		
		$this->view->assign('movies', $this->movieRepository->findAll());
		
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
		
		echo json_encode(array(
			'totalItems' => count($arr),
			'results' => $arr,
		));
		
			// Do not do further processing
		exit;
	}

}
?>