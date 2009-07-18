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
 * A multi action controller to use when using ExtJS.
 *
 * @category    Controller
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_ExtJS_Controller_ActionController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * ExtJS namespace for the controller
	 *
	 * @var string
	 */
	protected $extJSNamespace;
	
	/**
	 * @var array
	 */
	protected $jsInline = array();
	
	/**
	 * @var Tx_MvcExtjsSamples_ExtJS_SettingsService
	 */
	protected $settingsExtJS;
	
	/**
	 * Should be called in an action method, before doing anything else.
	 */
	protected function initializeExtJSAction() {
			// Load ExtJS libraries and stylesheets
		$GLOBALS['TSFE']->pageIncludes->loadExtJS();
		
			// Namespace will be registered in ExtJS when calling method outputJsCode
		$this->extJSNamespace = $this->extensionName . '.' . $this->request->getControllerName();
		
			// Initialize the ExtJS settings service 
		$this->settingsExtJS = t3lib_div::makeInstance('Tx_MvcExtjsSamples_ExtJS_SettingsService', $this->extJSNamespace);
	}
	
	/**
	 * Adds JS inline code.
	 * 
	 * @var string $block
	 */
	protected function addJsInlineCode($block) {
		$this->jsInline[] = $block;
	}
	
	/**
	* Adds a JavaScript library.
	* 
	* @param string $name
	* @param string $file file to be included, relative to this extension's Javascript directory
	* @param string $type
	* @param int $section 	t3lib_pageIncludes::PART_HEADER (0) or t3lib_pageIncludes::PART_FOOTER (1)
	* @param boolean $compressed	flag if library is compressed
	* @param boolean $forceOnTop	flag if added library should be inserted at begin of this block	
	*/
	protected function addJsLibrary($name, $file, $type = 'text/javascript', $section = t3lib_pageIncludes::PART_HEADER, $compressed = TRUE, $forceOnTop = FALSE) {
		$extPath = t3lib_extMgm::extPath($this->request->getControllerExtensionKey());
		$relPath = substr($extPath, strlen(PATH_site));
		$jsFile = 'Resources/Public/JavaScript/' . $file;
		
		if (!@is_file($extPath . $jsFile)) {
			die('File "' . $extPath . $jsFile . '" not found!');
		}
		
		$GLOBALS['TSFE']->pageIncludes->addJsLibrary($name, $relPath . $jsFile);
	}
	
	/**
	 * Outputs JS code to the page
	 * 
	 * @param boolean $compressed
	 * @param boolean $forceOnTop
	 */
	protected function outputJsCode($compressed = FALSE, $forceOnTop = FALSE) {
		$labels = $this->getExtJSLabels();
		
			// Register the namespace
		$block = 'Ext.ns("' . $this->extJSNamespace . '");' . chr(10);
		
			// Register localized labels
		if (count($labels) > 0) {
			$block .= $this->extJSNamespace . '.lang = ' . json_encode($labels) . ';' . chr(10);
		}
		
		if ($this->settingsExtJS->count() > 0) {
			$block .= $this->settingsExtJS->serialize() . chr(10);
		}
		
			// Put JS code into the namespace
		$block .=
			$this->extJSNamespace . '.plugin = function() {
				return {
					init: function() {
						' . join(chr(10), $this->jsInline) . '
					}
				}
			}();
		';
		
			// Start code when ExtJS is ready 
		$block .= 'Ext.onReady(' . $this->extJSNamespace . '.plugin.init, ' . $this->extJSNamespace . '.plugin);';
		
		$GLOBALS['TSFE']->pageIncludes->addJsInlineCode($this->extJSNamespace, $block, $compressed, $forceOnTop);
	}
	
	/**
	 * Returns an ExtJS variable to get a localized label.
	 *
	 * @param string $langKey language key as defined in a locallang.xml-formatted file
	 * @return string
	 */
	protected function getExtJSLabelKey($langKey) {
		$action = $this->request->getControllerActionName();
		
		return $this->extJSNamespace . '.lang.' . substr($langKey, strlen($action) + 1); 
	}
	
	/**
	 * Returns ExtJS labels for current action.
	 *
	 * @return array
	 */
	private function getExtJSLabels() {
		$fileRef = 'EXT:' . $this->request->getControllerExtensionKey() . '/Resources/Private/Language/extjs.' . $this->request->getControllerName() . '.xml';
			// TODO: switch over TYPO3_MODE once backend code is available
		$lang = $GLOBALS['TSFE']->lang;
		$action = $this->request->getControllerActionName();
		
			// Test whether localization exists for current controller
		$file = t3lib_div::getFileAbsFileName($fileRef);
		if (!($file && @is_file($file))) {
			return array();
		}
		
		$allLabels = $GLOBALS['TSFE']->readLLfile($fileRef);
		
			// Extract label keys available for current action
		$keys = array();
		foreach ($allLabels['default'] as $key => $value) {
			if (substr($key, 0, strlen($action) + 1) === $action . '.') {
				$keys[] = substr($key, strlen($action) + 1);
			}
		}
		
		$langLabels = is_array($allLabels[$lang]) ? $allLabels[$lang] : $allLabels['default'];
		
		$labels = array();
		foreach ($keys as $key) {
			if (key_exists($action . '.' . $key, $langLabels)) {
				$labelText = $langLabels[$action . '.' . $key];
			} else {
				$labelText = $allLabels['default'][$action . '.' . $key];
			}
			
			$labels[$key] = $labelText;
		}
		
		return $labels;
	}
	
}
?>