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
class Tx_MvcExtjsSamples_Controller_TwitterController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$GLOBALS['TSFE']->pageIncludes->addInlineComment('These examples show the possibility to work with ExtJS based on extbase plugin');
		
			// Load ExtJS libraries and stylesheets
		$GLOBALS['TSFE']->pageIncludes->loadExtJS();
		$GLOBALS['TSFE']->pageIncludes->addJsLibrary('Ext.ux.TYPO3.twitter', 'typo3conf/ext/mvc_extjs_samples/Resources/Public/Javascript/ux.typo3.twitter.js');
		
		
		
		$twitter = '
		  interval: ' . $this->settings['twitterInterval'] . ',
		  width: ' . $this->settings['twitterWidth'] . ',
		  height: ' . $this->settings['twitterHeight'] . ',
		  imageWidth: ' . $this->settings['twitterImageWidth'] . ',
		  columnHeader: ["User", "Message"]';
		if ($this->settings['twitterType'] == 1 && $this->settings['twitterKeyword']) {
			$twitter .= ',
			keyword: "' . $this->settings['twitterKeyword'] . '"';	
		}
		#debug($this->settings); 
		
		// read the settings from flexform
		
			// Create twitter plugin
		$GLOBALS['TSFE']->pageIncludes->addJsHandlerCode(
			'
			new Ext.ux.TYPO3.Twitter("MvcExtjsSamples-Twitter", {' . $twitter . '});',
			t3lib_pageIncludes::JSHANDLER_EXTONREADY
		);
	}
	
	
}
?>