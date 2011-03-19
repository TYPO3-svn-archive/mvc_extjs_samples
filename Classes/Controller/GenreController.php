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
class Tx_MvcExtjsSamples_Controller_GenreController extends Tx_MvcExtjs_MVC_Controller_ExtDirectActionController {

	/**
	 * @var Tx_MvcExtjsSamples_Domain_Repository_MovieRepository
	 */
	protected $genreRepository;
	
	/**
	 * @var Tx_Extbase_Persistence_ManagerInterface
	 * @inject
	 */
	protected $persistenceManager;
	
	/**
	 * Injects the PersistenceManager.
	 * 
	 * @param Tx_Extbase_Persistence_ManagerInterface $persistenceManager
	 */
	public function injectPersistenceManager(Tx_Extbase_Persistence_ManagerInterface $persistenceManager) {
		$this->persistenceManager = $persistenceManager;
	}
	
	/**
	 * Initializes the current action.
	 *
	 * @return void
	 */
	public function initializeAction() {
		parent::initializeAction();
		$this->genreRepository = $this->objectManager->get('Tx_MvcExtjsSamples_Domain_Repository_GenreRepository');
	}

	/**
	 * Index action for this controller. Displays a list of movies.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->view->setVariablesToRender(array('total', 'data', 'success','flashMessages'));
		$this->view->setConfiguration(array(
			'data' => array(
				'_descendAll' => self::resolveJsonViewConfiguration()
			)
		));
		
		$genres = $this->genreRepository->findAll();
		$this->flashMessages->add('Loaded all Genres from Server side.','Genres loaded successfully', t3lib_FlashMessage::NOTICE);
		
		$this->view->assign('total', $genres->count());
		$this->view->assign('data',$genres);
		$this->view->assign('success',TRUE);
		$this->view->assign('flashMessages', $this->flashMessages->getAllMessagesAndFlush());
	}
	
	/**
	 * Creates a movie.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Genre $genre
	 * @return string JSON output
	 * @dontverifyrequesthash
	 */
	public function createAction(Tx_MvcExtjsSamples_Domain_Model_Genre $genre) {
		$this->view->setVariablesToRender(array('data', 'success','flashMessages'));
		$this->view->setConfiguration(array(
			'data' =>  self::resolveJsonViewConfiguration()
		));
		$this->genreRepository->add($genre);
		$this->persistenceManager->persistAll();
		$this->flashMessages->add('Genre "' . $genre->getName() . '" has been created','Genre added', t3lib_FlashMessage::OK);
		
		$this->view->assign('success',TRUE);
		$this->view->assign('data',$genre);
		$this->view->assign('flashMessages', $this->flashMessages->getAllMessagesAndFlush());
	}
	
	/**
	 * Deletes a movie.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Genre $genre
	 * @return string JSON output
	 * @dontverifyrequesthash
	 */
	public function destroyAction(Tx_MvcExtjsSamples_Domain_Model_Genre $genre) {
		$this->view->setVariablesToRender(array('data', 'success','flashMessages'));
		$this->view->setConfiguration(array(
			'data' =>  self::resolveJsonViewConfiguration()
		));
		$this->genreRepository->remove($genre);
		
		$this->flashMessages->add('Genre "' . $genre->getName() . '" has been deleted','Genre deleted', t3lib_FlashMessage::OK);
		
		$this->view->assign('success',TRUE);
		$this->view->assign('data',$genre);
		$this->view->assign('flashMessages', $this->flashMessages->getAllMessagesAndFlush());
	}
	
	/**
	 * Updates a movie.
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_Genre $genre A clone of the original movie with the updated values already applied
	 * @return void
	 * @dontverifyrequesthash
	 */
	public function updateAction(Tx_MvcExtjsSamples_Domain_Model_Genre $genre) {
		$this->view->setVariablesToRender(array('total', 'data', 'success','flashMessages'));
		$this->view->setConfiguration(array(
			'data' => self::resolveJsonViewConfiguration()
		));
		
		$this->genreRepository->update($genre);
		
		$this->flashMessages->add('Genre "' . $genre->getName() . '" has been updated','Genre updated', t3lib_FlashMessage::OK);
		
		$this->view->assign('data',$genre);
		$this->view->assign('success',TRUE);
		$this->view->assign('flashMessages', $this->flashMessages->getAllMessagesAndFlush());
	}
	
	/**
	 * Returns a configuration for the JsonView, that describes which fields should be rendered for
	 * a forschungsprojekt record.
	 * 
	 * @return array
	 */
	static public function resolveJsonViewConfiguration() {
		return array(
					'_exposeObjectIdentifier' => TRUE,
					'_only' => array('name')
				);
	}
	
}
?>