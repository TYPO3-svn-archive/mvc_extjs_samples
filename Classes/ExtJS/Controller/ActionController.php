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
	
	// -- FE-only properties
	
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
	 * @var array
	 */
	private $menu = array();
	
	/**
	 * @var template
	 */
	private $doc;
	
	/**
	 * @var t3lib_SCbase
	 */
	private $scBase;
	
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
		$this->useExtCore = $useExtCore;
		
		if (TYPO3_MODE === 'FE') {
			$this->pageIncludes = $GLOBALS['TSFE']->pageIncludes;
			
			if (!$useExtCore) {
					// temporary fix for t3style		
				$GLOBALS['TBE_STYLES']['extJS']['theme'] = t3lib_extMgm::extRelPath('t3skin') . 'extjs/xtheme-t3skin.css';	
			}
		} else {
			$this->scBase = t3lib_div::makeInstance('t3lib_SCbase'); 
			$this->scBase->MCONF['name'] = $this->settings['pluginName'];
			$this->scBase->init();
			
				// Prepare template class
			$this->doc = t3lib_div::makeInstance('template'); 
			$this->doc->backPath = $GLOBALS['BACK_PATH'];
			
			$this->pageIncludes = $this->doc->pageIncludes;
		}
		
		$this->pageIncludes->moveJsFromHeaderToFooter = $moveJsFromHeaderToFooter;
		
		if ($useExtCore) {
				// Load ExtCore library
			$this->pageIncludes->loadExtCore();		
		} else {
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
	
	// ----------------------------------------------------------------
	// BACKEND-ONLY METHODS
	// ----------------------------------------------------------------
	
	/**
	 * Sets the menu of the backend module.
	 *
	 * @param array $menu
	 * @return void
	 */
	protected function setMenu(array $menu) {
		$this->menu = $menu;
	}
	
	/**
	 * Renders a ExtJS module by incorporating the controller's view
	 * into a master view encapsulating standard TYPO3's module elements. 
	 * 
	 * @param string $contentPanel The ExtJS panel holding the module itself
	 * @return void
	 */
	public function renderExtJSModule($contentPanel = NULL) {
		if (TYPO3_MODE !== 'BE') {
			die('renderExtJSModule() may only be called by backend modules');
		}
		
		if ($this->doc) {
			$title = $this->settings['pluginName'];
			
			$this->doc->form = '';
			$this->doc->JScode = '
				<script language="javascript" type="text/javascript">
					script_ended = 0;
					function jumpToUrl(URL)	{
						document.location = URL;
					}
				</script>
			';
			$this->doc->postCode = '
				<script language="javascript" type="text/javascript">
					script_ended = 1;
					if (top.fsMod) top.fsMod.recentIds["web"] = 0;
				</script>
			';
			
			if ($GLOBALS['BE_USER']->mayMakeShortcut()) {
				$shortcut = $this->doc->makeShortcutIcon('id', implode(',', array_keys($this->scBase->MOD_MENU)), $this->scBase->MCONF['name']);
			} else {
				$shortcut = '';
			}
						
			$this->addJsInlineCode('
				var viewport = new Ext.Viewport({
					layout: "border",
					renderTo: Ext.getBody(),
					items: [{
						region: "north",
						xtype: "toolbar",
						height: 28,
						items: [{
							xtype: "tbspacer"
						}
			');
			
			if (count($this->menu)) {
				$menuEntries = array();
				foreach ($this->menu as $id => $title) {
					$menuEntry = json_encode(array($id => $title));
					$menuEntry = preg_replace('/^{(.*)":"(.*)}/', '[\1","\2]', $menuEntry);
					$menuEntries[] = $menuEntry;
				}
				
				$this->addJsInlineCode('
						,{
							xtype: "combo",
							triggerAction: "all",
							mode: "local",
							store: [' . join(',', $menuEntries) . '],
							displayField: "title",
							readOnly: true,
							listeners:{
								select:function(combo, record, index) {
									Ext.Msg.alert("Selected index", index);
								}
							}
						}
				');
			}
			
			if ($shortcut) {
				preg_match('/(top.ShortcutManager.createShortcut.*;)return false;/', $shortcut, $matches);
				$this->addJsInlineCode('
						,{
							xtype: "tbfill"
						},{
							xtype: "tbbutton",
							cls: "x-btn-icon",
							icon: "' . $GLOBALS['BACK_PATH'] . '/sysext/t3skin/icons/gfx/shortcut.gif",
							handler: function() { ' . $matches[1] . ' }
						}
				');
			}
			
			$this->addJsInlineCode('
						]
					},{
						region: "center",
						xtype: "panel",
						' . ($contentPanel ? 'items: ' . $contentPanel : 'html: "MODULE GOES HERE"') . '
					}]
				});
			');
			
			$this->outputJsCode();
			
			$this->masterView->assign(
				'layout',
				$this->doc->startPage($title) . $this->doc->endPage()
			);
		}
		
		$this->view = $this->masterView;
	}
	
}
?>