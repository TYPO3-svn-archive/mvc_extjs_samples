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
 * The Genre controller.
 *
 * @category    Controller
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_Controller_GenreController extends Tx_MvcExtjs_ExtJS_Controller_ActionController {
	
	/**
	 * @var Tx_MvcExtjsSamples_Domain_Repository_GenreRepository
	 */
	protected $genreRepository;
	
	/**
	 * Initializes the controller.
	 * 
	 * @return unknown_type
	 */
	public function initializeAction() {
		$this->genreRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_GenreRepository');
	}
	
	/**
	 * Returns a list of genres as JSON.
	 * 
	 * @return string
	 */
	public function indexAction() {
		$genres = $this->genreRepository->findAll();
		$this->view->assign('genres', $genres);
	}
	
	/**
	 * Updates a genre record
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Genre $genre
	 * @dontverifyrequesthash
	 * @return string
	 */
	public function updateAction(Tx_MvcExtjsSamples_Domain_Model_Genre $genre = NULL) {
		try {
			$this->genreRepository->update($genre);
			$this->view->assign('data',$genre->_getProperties());
			$this->view->assign('success',TRUE);
			$this->view->assign('message','Genre updated');
		} catch(Exception $e) {
			$this->view->assign('data',array());
			$this->view->assign('success',FALSE);
			$this->view->assign('message','Genre update failed');
			t3lib_div::sysLog($e->getTraceAsString(),'MvcExtjsSamples',1);
		}
	}
	
	/**
	 * Creates a new genre record.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Genre $genre
	 * @dontverifyrequesthash
	 * @return string
	 */
	public function createAction(Tx_MvcExtjsSamples_Domain_Model_Genre $genre = NULL) {
		try {
			$this->genreRepository->add($genre);
			$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager')->persistAll();
			$this->view->assign('data',array($genre));
			$this->view->assign('success',TRUE);
			$this->view->assign('message','Genre updated');
		} catch(Exception $e) {
			$this->view->assign('data',array());
			$this->view->assign('success',FALSE);
			$this->view->assign('message','Genre update failed');
			t3lib_div::sysLog($e->getTraceAsString(),'MvcExtjsSamples',1);
		}
	}
	
	/**
	 * Deletes a genre record.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Genre $genre
	 * @dontverifyrequesthash
	 * @return string
	 */
	public function deleteAction(Tx_MvcExtjsSamples_Domain_Model_Genre $genre = NULL) {
		try {
			$this->genreRepository->remove($genre);
			$this->view->assign('success',TRUE);
			$this->view->assign('message','Genre updated');
		} catch(Exception $e) {
			$this->view->assign('data',array());
			$this->view->assign('success',FALSE);
			$this->view->assign('message','Genre update failed');
			t3lib_div::sysLog($e->getTraceAsString(),'MvcExtjsSamples',1);
		}
	}
	
}
?>