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
 * @author      Steffen Kamper <info@sk-typo3.de> 
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id: SimpleFormController.php 22464 2009-07-18 17:53:32Z xperseguers $
 */
class Tx_MvcExtjsSamples_Controller_FeedsController extends Tx_MvcExtjsSamples_ExtJS_Controller_ActionController {
	
	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->initializeExtJSAction();
		$this->addJsLibrary('Ext.ux.TYPO3.feeds', 'ux.TYPO3.Feeds.js');

		$feedUrl = $this->settings['feedsUrl'];
		$ajaxUrl = $this->URIBuilder->URIFor($GLOBALS['TSFE']->id, 'feeds', array('feed' => $feedUrl));
		
			// Create a data store with movie genres
		$this->addJsInlineCode('
			new Ext.ux.TYPO3.Feeds("MvcExtjsSamples-Feed", {
				interval: 0,
				width: 450,
				height: 300,
				url: "' . $ajaxUrl . '",
				title: "' . $this->settings['feedsTitle'] . '",
				cropMsg: 100
			});   
		');
		
		$this->outputJsCode();
	}
	
	/**
	 * Reads a list of feed articles from an external website and
	 * returns them as XML for the Feeds plugin.
	 * 
	 * @return void
	 * @ajax
	 */
	public function feedsAction() {
		$feed = t3lib_div::_GP('tx_mvcextjssamples_pi4');
				
			// Prepare the XML response
		if ($feed['feed'] != '' && strpos($feed['feed'], 'http') === 0) {
			header('Content-Type: text/xml');
			
			$xml = file_get_contents($feed['feed']);
			$xml = str_replace('<content:encoded>', '<content>', $xml);
			$xml = str_replace('</content:encoded>', '</content>', $xml);
			$xml = str_replace('</dc:creator>', '</author>', $xml);
			echo str_replace('<dc:creator', '<author', $xml);
		} else {
			header(t3lib_div::HTTP_STATUS_404);
		}
		
			// Do not do further processing
		exit;
	}
	
}
?>