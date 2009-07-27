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
	 * Absolute path to this extension.
	 * Usage: Backend
	 *
	 * @var string
	 */
	protected $extPath;
	
	/**
	 * Path of the root of this extension relative to the website
	 * Usage: Frontend
	 *
	 * @var string
	 */
	protected $extRelPath;
	
	/**
	 * @var boolean
	 */
	protected $enableExtJSQuickTips = FALSE;
	
	/**
	 * @var array
	 */
	protected $jsInline = array();
	
	/**
	 * @var array
	 */
	protected $cssInline = array();
	
	/**
	 * @var Tx_MvcExtjsSamples_ExtJS_SettingsService
	 */
	protected $settingsExtJS;
	
	/**
	 * @var boolean
	 */
	protected $useExtCore = false;
	
	/**
	 * @var t3lib_pageIncludes
	 */
	protected $pageIncludes;
	
	// -- BE-only properties
	
	/**
	 * @var Tx_Fluid_View_TemplateView
	 */
	private $masterView;
	
	/**
	 * Initializes the action.
	 * 
	 * Beware: make sure to call parent::initializeAction if you need to do something in your child class 
	 */
	protected function initializeAction() {
		if (TYPO3_MODE === 'BE') {
			$this->injectSettings(Tx_Extbase_Dispatcher::getSettings());
			
				// Prepare the view
			$this->masterView = t3lib_div::makeInstance('Tx_Fluid_View_TemplateView');
			$controllerContext = $this->buildControllerContext();
			$this->masterView->setControllerContext($controllerContext);
			$this->masterView->setTemplatePathAndFilename(t3lib_extMgm::extPath('mvc_extjs_samples') . 'Resources/Private/Templates/module.html');
			$this->masterView->injectSettings($this->settings);
		}
	}
	
	/**
	 * Should be called in an action method, before doing anything else.
	 */
	protected function initializeExtJSAction($useExtCore = FALSE, $moveJsFromHeaderToFooter = FALSE) {
		$this->pageIncludes = $GLOBALS['TSFE']->pageIncludes;
		$this->pageIncludes->moveJsFromHeaderToFooter = $moveJsFromHeaderToFooter;
		
		if ($useExtCore) {
			$this->useExtCore = TRUE;
				// Load ExtCore library
			$this->pageIncludes->loadExtCore();		
		} else {
				// temporary fix for t3style		
			$GLOBALS['TBE_STYLES']['extJS']['theme'] =  t3lib_extMgm::extRelPath('t3skin') . 'extjs/xtheme-t3skin.css';
				// Load ExtJS libraries and stylesheets
			$this->pageIncludes->loadExtJS();
		}
		
			// Namespace will be registered in ExtJS when calling method outputJsCode
			// TODO: add id of controller for multiple usage
		$this->extJSNamespace = $this->extensionName . '.' . $this->request->getControllerName();
		
		$this->extPath = t3lib_extMgm::extPath($this->request->getControllerExtensionKey());
		$this->extRelPath = substr($this->extPath, strlen(PATH_site));
		
			// Initialize the ExtJS settings service 
		$this->settingsExtJS = t3lib_div::makeInstance('Tx_MvcExtjsSamples_ExtJS_SettingsService', $this->extJSNamespace);
	}
	
	/**
	 * Adds JS inline code.
	 * 
	 * @var string $block
	 */
	protected function addCssInlineBlock($block) {
		$this->cssInline[] = $block;
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
	protected function addCssFile($cssFile, $rel = 'stylesheet', $media = 'screen', $title = '', $compressed = FALSE, $forceOnTop = FALSE) {
		$cssFile = 'Resources/Public/CSS/' . $cssFile;
		
		if (!@is_file($this->extPath . $cssFile)) {
			die('File "' . $this->extPath . $cssFile . '" not found!');
		}
		
		$this->pageIncludes->addCssFile( $this->extRelPath . $cssFile, $rel, $media, $title, $compressed, $forceOnTop);
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
		$jsFile = 'Resources/Public/JavaScript/' . $file;
		
		if (!@is_file($this->extPath . $jsFile)) {
			die('File "' . $this->extPath . $jsFile . '" not found!');
		}
		
		$this->pageIncludes->addJsLibrary($name, $this->extRelPath . $jsFile, $type, $section, $compressed, $forceOnTop);
	}
	
	/**
	* Adds a JavaScript file.
	* 
	* @param string $name
	* @param string $file file to be included, relative to this extension's Javascript directory
	* @param string $type
	* @param int $section 	t3lib_pageIncludes::PART_HEADER (0) or t3lib_pageIncludes::PART_FOOTER (1)
	* @param boolean $compressed	flag if library is compressed
	* @param boolean $forceOnTop	flag if added library should be inserted at begin of this block	
	*/
	protected function addJsFile($file, $type = 'text/javascript', $compressed = TRUE, $forceOnTop = FALSE) {
		$jsFile = 'Resources/Public/JavaScript/' . $file;
		
		if (!@is_file($this->extPath . $jsFile)) {
			die('File "' . $this->extPath . $jsFile . '" not found!');
		}
		
		$this->pageIncludes->addJsFile($this->extRelPath . $jsFile, $type, $compressed, $forceOnTop);
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
		
		$block .= $this->extJSNamespace . '.plugin.init();';   
		
			// Start code when ExtJS is ready 
		$this->pageIncludes->enableExtJSQuickTips = $this->enableExtJSQuickTips; 
		$this->pageIncludes->addJsHandlerCode($block, t3lib_pageIncludes::JSHANDLER_EXTONREADY);
		
		if (count($this->cssInline)) {
			    $this->pageIncludes->addCssInlineBlock($this->extJSNamespace, implode('', $this->cssInline));
		}
		
	}
	
	/**
	 * Renders a module by incorporating the rendered controller's view
	 * into a master view encapsulating standard TYPO3's module elements. 
	 * 
	 * @return void
	 */
	protected function renderModule() {
		if (TYPO3_MODE !== 'BE') {
			die('renderModule may only be called for backend modules');
		}
		$this->masterView->assign('moduleContent', $this->view->render());
		$this->view = $this->masterView;
	}
	
	/**
	 * Returns an ExtJS variable to get a localized label.
	 *
	 * @param string $langKey language key as defined in a locallang.xml-formatted file
	 * @return string
	 */
	protected function getExtJSLabelKey($langKey) {
		$action = $this->request->getControllerActionName();
		
		return $this->extJSNamespace . '.lang.' . $this->getExtJSKey(substr($langKey, strlen($action) + 1)); 
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
			if (strpos($key, $action . '.') === 0) {
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
			
			$labels[$this->getExtJSKey($key)] = $labelText;
		}
		
		return $labels;
	}
	
	/**
	 * Returns a key to be used in ExtJS.
	 * 
	 * @param string $key The key as found in a TYPO3 XML file (locallang.xml, ...)
	 */
	private function getExtJSKey($xmlKey) {
		$parts = explode('.', $xmlKey);
		
		for ($i = 1; $i < count($parts); $i++) {
			$parts[$i] = ucfirst($parts[$i]);
		}
		return join ('', $parts);
	}
	
}
?>