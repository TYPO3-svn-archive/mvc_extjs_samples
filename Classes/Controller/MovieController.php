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
class Tx_MvcExtjsSamples_Controller_MovieController extends Tx_MvcExtjs_ExtJS_Controller_ActionController {

	/**
	 * @var Tx_MvcExtjsSamples_Domain_Repository_MovieRepository
	 */
	protected $movieRepository;

	/**
	 * Initializes the current action.
	 *
	 * @return void
	 */
	public function initializeAction() {
			// Do not forget to call parent's initializeAction method
		parent::initializeAction();
		
		$this->movieRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_MovieRepository');
	}

	/**
	 * Index action for this controller. Displays a list of movies.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->initializeExtJSAction();
		
			// Store the relative path to image directories
		$this->settingsExtJS->assign('coverPath', $this->extRelPath . 'Resources/Public/Images/');
		$this->settingsExtJS->assign('iconsPath', $this->extRelPath . 'Resources/Public/Icons/');
		
		$this->uriBuilder->reset();
		$this->settingsExtJS->assign('updateUrl', $this->uriBuilder->uriFor('update'));
		
			// Enable quick tips
		$this->enableExtJSQuickTips = TRUE;
		$this->addJsInlineCode('
			Ext.apply(Ext.QuickTips.getQuickTip(), {
				maxWidth: 200,
				minWidth: 100,
				showDelay: 50,
				trackMouse: true
			});
		');
		
			// Create a validation type for the movie form
		$this->addJsInlineCode('
			Ext.form.VTypes.nameVal  = /^([A-Z]{1})[A-Za-z\-]+ ([A-Z]{1})[A-Za-z\-]+/;
			Ext.form.VTypes.nameMask = /[A-Za-z\- ]/;
			Ext.form.VTypes.nameText = "Invalid Director Name.";
			Ext.form.VTypes.name = function(v) {
				return Ext.form.VTypes.nameVal.test(v);
			};
		');
		
			// Create a few functions to manage movies
		$this->addJsInlineCode('
			var Movies = function() {
				return {
					editDetails : function(grid, index) {
						var movie_form = Ext.getCmp("movie_view").findById("movie_form");
						if (!movie_form.isVisible()) { movie_form.expand(); }
						
						var values = grid.getSelectionModel().getSelected().data;
						
						// Sets the form action URL
						movie_form.getForm().url = ' . $this->settingsExtJS->getExtJS('updateUrl') . ';
						
						// TODO: Add this to a new setExtbaseValues() method on Ext.form.BasicForm
						var field, id;
						for(id in values){
							fieldId = (id == "uid") ? "__identity" : id;
							if(!Ext.isFunction(values[id]) && (field = movie_form.getForm().findField("tx_mvcextjssamples_movie[movie][" + fieldId + "]"))){
								try { // TODO: handle multiple fields (radio button filmedIn) 
									field.setValue(values[id]);
									if(movie_form.getForm().trackResetOnLoad){
										field.originalValue = field.getValue();
									}
								} catch (e) {}
							}
						} 
					}
				};
			}();
		');
		
			// Create a movie data store
		$this->addJsInlineCode('
			var moviesStore = new Ext.data.GroupingStore({
				proxy: new Ext.data.HttpProxy({
					url: "' . $this->uriBuilder
					                    ->reset()
					                    ->setTargetPageType(1249117053)
					                    ->setFormat('xml')
					                    ->uriFor('movies') . '"
				}),
				sortInfo: {
					field: "genre",
					direction: "ASC"
				},
				groupField: "genre",
				reader: ' . Tx_MvcExtjs_ExtJS_Utility::getJSONReader('Tx_MvcExtjsSamples_Domain_Model_Movie') . ',
				autoLoad: true
			});
		');
		
			// Create a genre data store
		$this->addJsInlineCode('
			var genresStore = new Ext.data.Store({
				proxy: new Ext.data.HttpProxy({
					url: "' . $this->uriBuilder
					                    ->reset()
					                    ->setTargetPageType(1249117332)
					                    ->setFormat('xml')
					                    ->uriFor('index', array(), 'Genre') . '"
				}),
				sortInfo: {
					field: "name",
					direction: "ASC"
				},
				reader: ' . Tx_MvcExtjs_ExtJS_Utility::getJSONReader('Tx_MvcExtjsSamples_Domain_Model_Genre') . ',
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
				id: "movie_view",
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
					xtype: "form",
					id: "movie_form",
					method: "post",
					split: true,
					collapsible: true,
					collapsMode: "mini",
					collapsed: true,
					title: ' . $this->getExtJSLabelKey('index.form.title') . ',
					bodyStyle: "padding:5px;",
					width: 250,
					minSize: 250,
		 			items: ' . Tx_MvcExtjs_ExtJS_Array::create()
						->addAll(Tx_MvcExtjs_ExtJS_Utility::getExtbaseFormElements($this->request, $this->request->getControllerActionName()))
						->add(
							Tx_MvcExtjs_ExtJS_FormElement::create($this->request)
								->setXType('hidden')
								->setObjectModelField('movie', '__identity')
						)
						->add(
							Tx_MvcExtjs_ExtJS_FormElement::create($this->request)
								->setXType('textfield')
								->setObjectModelField('movie', 'title')
								->setRaw('fieldLabel', $this->getExtJSLabelKey('index.title'))
								->set('anchor', '100%')
								->setRaw('allowBlank', 'false')
								->setRaw('listeners',
									'{
										specialKey: function(f,e) {
											if (e.getKey() == e.ENTER) {
												// Send form
											}
										}
									}')
						)
						->add(
							Tx_MvcExtjs_ExtJS_FormElement::create($this->request)
								->setXType('textfield')
								->setObjectModelField('movie', 'director')
								->setRaw('fieldLabel', $this->getExtJSLabelKey('index.director'))
								->set('anchor', '100%')
								->set('vtype', 'name')
						)
						/*
						->add(
							'{
								xtype: "datefield",
								fieldLabel: ' . $this->getExtJSLabelKey('index.released') . ',
								name: "tx_mvcextjssamples_movie[movie][releaseDate]",
								disabledDays: [6]
							}'
						)
						->add(
							'{
								xtype: "radio",
								fieldLabel: ' . $this->getExtJSLabelKey('index.filmedIn') . ',
								name: "tx_mvcextjssamples_movie[movie][filmedIn]",
								boxLabel: ' . $this->getExtJSLabelKey('index.filmedIn.color') . '
							}'
						)
						->add(
							'{
								xtype: "radio",
								hideLabel: false,
								labelSeparator: "",
								name: "tx_mvcextjssamples_movie[movie][filmedIn]",
								boxLabel: ' . $this->getExtJSLabelKey('index.filmedIn.bw') . '
							}'
						)
						->add(
							'{
								xtype: "combo",
								fieldLabel: ' . $this->getExtJSLabelKey('index.genre') . ',
								name: "updatedMovie[genre]",
								mode: "local",
								store: genresStore,
								displayField: "name",
								width: 130
							}'
						)
						*/
						->add(
							Tx_MvcExtjs_ExtJS_FormElement::create($this->request)
								->setXType('textarea')
								->setObjectModelField('movie', 'tagline')
								->setRaw('fieldLabel', $this->getExtJSLabelKey('index.tagline'))
								->set('height', 80)
								->set('anchor', '100%')
						)
						->build()
					. ',
					buttons: [{
						text: ' . $this->getExtJSLabelKey('index.form.save') . ',
						handler: function() {
							Ext.getCmp("movie_view").findById("movie_form").getForm().submit({
								success: function(f,a) {
									// Refresh the grid as save worked
									moviesStore.reload();
								},
								failure: function(f,a) {
									console.log(a);
									Ext.Msg.alert("Warning", a.result.errormsg);
								}
							});
						}
					},{
						text: ' . $this->getExtJSLabelKey('index.form.reset') . ',
						handler: function() {
							Ext.getCmp("movie_view").findById("movie_form").getForm().reset();
						}
					}]
				},
		');
		
			// Create the list of movies as a grid
		$this->addJsInlineCode('
				{
					region: "center",
					xtype: "grid",
					store: moviesStore,
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
					listeners: {
						rowdblclick: {
							fn: Movies.editDetails
						}
					},
					view: new Ext.grid.GroupingView(),
					sm: new Ext.grid.RowSelectionModel({
						singleSelect: true
					})
				}
		');
				
			// [END] Complex layout: close it and... render it!
		$this->addJsInlineCode('
				]
			});
			
			complexLayout.render("MvcExtjsSamples-Movie");
		');
		
		$this->outputJsCode();
	}
	
	/**
	 * Updates a movie.
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_Movie $movie A clone of the original movie with the updated values already applied
	 * @return void
	 * @ajax
	 */
	public function updateAction(Tx_MvcExtjsSamples_Domain_Model_Movie $movie) {
		try {
			$movieRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_MovieRepository');
			$movieRepository->update($movie);
			
			$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
			/* @var $persistenceManager Tx_Extbase_Persistence_Manager */
			
			$persistenceManager->persistAll();
						
			echo '{success:true}';
		} catch (Exception $e) {
			echo '{success:false}';
		}
		
			// Do not do further processing
		exit;
	}
	
	/**
	 * Returns a list of movies as JSON.
	 * 
	 * @return string The rendered view
	 */
	public function moviesAction() {
		$movieRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_MovieRepository');
		/* @var $movieRepository Tx_MvcExtjsSamples_Domain_Repository_MovieRepository */
		
			// Retrieve all movies from repository
		$movies = $movieRepository->findAll();
		
		$this->view->assign('movies', $movies);
	}
	
}
?>