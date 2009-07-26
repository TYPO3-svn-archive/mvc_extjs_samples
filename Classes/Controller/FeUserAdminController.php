<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Steffen Kamper <info@sk-typo3.de>
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
 * @version     SVN: $Id: SimpleFormController.php 22442 2009-07-18 11:11:19Z xperseguers $
 */
class Tx_MvcExtjsSamples_Controller_FeUserAdminController extends Tx_MvcExtjsSamples_ExtJS_Controller_ActionController {
	
	/**
	 * @var Tx_Extbase_Domain_Model_FrontendUserRepository
	 */
	protected $frontendUserRepository;
	
	/**
	 * @var Tx_Extbase_Domain_Model_FrontendUserGroup
	 */
	protected $frontendUserGroupsModel;
	
	/**
	 * @var Tx_Extbase_Domain_Model_FrontendUserGroup
	 */
	protected $frontendUserGroupsRepository;
	
	
	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->initializeExtJSAction();
		$this->addJsLibrary('ux.TYPO3.FeUserAdmin', 'ux.TYPO3.FeUserAdmin.js');
		$this->addJsLibrary('ux.grid.RowEditor', 'ux.grid.RowEditor.js');
		

		$this->frontendUserRepository = t3lib_div::makeInstance('Tx_Extbase_Domain_Model_FrontendUserRepository'); 
		$this->frontendUserModel = t3lib_div::makeInstance('Tx_Extbase_Domain_Model_FrontendUser', 'newname', 'newpass'); 


		debug($this->frontendUserRepository->findAll());
				
		$this->addCssInlineBlock('body {background-color:#eee;}');
		//$this->addCssFile('FeUserAdmin.css');
		
		//$this->pageIncludes->addInlineSetting($this->extJSNamespace, 'storeFields', array(array('name' => 'username')));
		
		
		$this->settingsExtJS->assign('storeFields', Tx_MvcExtjsSamples_ExtJS_Utility::getJSONReader('Tx_Extbase_Domain_Model_FrontendUser', $this->frontendUserModel));
		$this->settingsExtJS->assign('chartsUrl', 'typo3/contrib/extjs/resources/charts.swf');
		$this->settingsExtJS->assign('div', '"MvcExtjsSamples-FeUserAdmin');
		
		//$cssFile  = $this->setting['cssFile'] ? $this->setting['cssFile'] : 'typo3conf/ext/mvc_extjs_samples/Resources/Public/CSS/carousel.css';
		//$GLOBALS['TSFE']->pageIncludes->addCssFile($cssFile);

		
		
			// Create twitter plugin
		$this->addJsInlineCode($this->extJSNamespace . '.components.init();');
		
		$this->outputJsCode();
	}
	
}
?>