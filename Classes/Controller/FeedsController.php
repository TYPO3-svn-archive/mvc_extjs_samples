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
class Tx_MvcExtjsSamples_Controller_FeedsController extends Tx_MvcExtjs_ExtJS_Controller_ActionController {
	
	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->initializeExtJSAction();
		$this->addJsLibrary('Ext.ux.TYPO3.feeds', 'ux.TYPO3.Feeds.js');

		$id = $this->settings['contentObjectData']['uid'];
		$this->view->assign('ID', $id);
		
		$feedUrl = $this->settings['feedsUrl'];
		$ajaxUrl = $this->URIBuilder->URIFor($GLOBALS['TSFE']->id, 'feeds', array('feed' => $feedUrl, 'fid' => $id));
		
			// Create the feed display
		$this->addJsInlineCode('
			new Ext.ux.TYPO3.Feeds("MvcExtjsSamples-Feed-' . $id . '", {
				interval: ' . $this->settings['feedsInterval'] . ',
				width: ' . $this->settings['feedsWidth'] . ',
				height: ' . $this->settings['feedsHeight'] . ',
				url: "' . $ajaxUrl . '",
				title: "' . $this->settings['feedsTitle'] . '",
				cropMsg: 100' . ($this->settings['feedsCount'] ? ',resultsPerPage: ' . $this->settings['feedsCount'] : '') . '
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
		if (!$this->request->hasArgument('feed')) {
			exit;	
		}
		$feed = $this->request->getArgument('feed');

			// Prepare the XML response
		if (strpos($feed, 'http') === 0) {
			header('Content-Type: text/xml');
			
			$xml = file_get_contents($feed);
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