<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Steffen Kamper (info@sk-typo3.de)
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
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * TYPO3 pageIncludes class (new in TYPO3 4.3.0)
 * This class render all header- and footerdata, usable for BE and FE
 *
 * @author	Steffen Kamper <info@sk-typo3.de>
 * @package TYPO3
 * @subpackage t3lib
 */
class t3lib_pageIncludes implements t3lib_Singleton {


	public $compressJavascript = FALSE;
	public $compressCss = FALSE;

	public $concatenateFiles = FALSE;

	public $moveJsFromHeaderToFooter = FALSE;

	protected $csConvObj; 
	protected $lang;

		// static array containing associative array for the included files
	protected static $jsFiles = array();
	protected static $jsFooterFiles = array();
	protected static $jsLibs = array();
	protected static $jsFooterLibs = array();
	protected static $cssFiles = array();

		// static header blocks    
	protected static $xmlPrologAndDocType = '';
	protected static $metaTags = '';
	protected static $inlineComment = '';
	protected static $headerData = '';
	protected static $footerData = '';
	protected $metaCharsetTag = '';
	protected $titleTag = '';
	protected $htmlTag = '';
	protected $headTag = '';
	protected $baseUrlTag = '';
	protected $shortcutTag = '';

		// static inline code blocks    
	protected static $jsInline = array();
	protected static $jsFooterInline = array();
	protected static $jsHandlerCode = array();
	protected static $cssInline = array();

	protected $templateFile;

	protected $jsLibraryNames = array('prototype', 'scriptaculous', 'extjs');

	const PART_HEADER = 0;
	const PART_FOOTER = 1;
    
		// internal flags for JS-libraries
	protected $addPrototype = FALSE;
	protected $addScriptaculous = FALSE;
	protected $addScriptaculousModules = array(
		'builder'  => FALSE,
		'effects'  => FALSE,
		'dragdrop' => FALSE,
		'controls' => FALSE,
		'slider'   => FALSE
	);
	protected $addExtJS = FALSE;
	protected $addExtCore = FALSE;
	protected $extJSadapter = 'ext/ext-base.js';
	protected $appLoader = FALSE;
	protected $appLoaderLabels = '';
	protected $appLoaderIcon = '';
	
	protected $enableExtJsDebug = FALSE;
	protected $enableExtCoreDebug = FALSE;

		// available adapters for extJs
	const EXTJS_ADAPTER_JQUERY = 'jquery'; 
	const EXTJS_ADAPTER_PROTOTYPE = 'prototype'; 
	const EXTJS_ADAPTER_YUI = 'yui';
	
		// available inline-JsHandler
	const JSHANDLER_EXTONREADY = 1;
	
	public $enableExtJSQuickTips = false;
	
	protected $inlineLanguageLabels = array();
	protected $inlineSettings = array();
	
		// used by BE modules
	public $backPath;
	
	
	
	/**
	* Constructor
	* 
	* @param string $templateFile	declare the used template file. Omit this parameter will use default template
	* @param string $backPath	relative path to typo3-folder. It varies for BE modules, in FE it will be typo3/
	* @return void
	*/
	public function __construct($templateFile = '', $backPath = '') {
		$this->templateFile = $templateFile;
		if ($this->templateFile === '') {
			$this->templateFile = TYPO3_mainDir . 'templates/pageincludes.html';
		}
		$this->backPath = $backPath;
		$this->csConvObj = TYPO3_MODE == 'BE' ? $GLOBAL['LANG']->csConvObj : $GLOBALS['TSFE']->csConvObj;
		$this->lang = TYPO3_MODE == 'BE' ? $GLOBALS['BE_USER']->uc['lang'] : $GLOBALS['TSFE']->lang;

			//init vars
		$this->jsFiles = $this->jsFooterFiles = $this->jsInline = $this->jsFooterInline = $this->jsLibs = array();
		$this->cssFiles = $this->cssInline = array();

		$this->jsHandlerCode[self::JSHANDLER_EXTONREADY] = '';
	} 
	
	
	/*****************************************************/
	/*                                                   */
	/*  Public Function to add Data                      */
	/*                                                   */
	/*                                                   */
	/*****************************************************/
	
	/**
	* set xml prolog and docType
	* 	
	* @param string $xmlPrologAndDocType	complete tags for xml prolog and docType
	*/
	public function setXmlPrologAndDocType($xmlPrologAndDocType) {
		$this->xmlPrologAndDocType = $xmlPrologAndDocType;
	}
	
	/**
	* set page title
	* 
	* @param string $title	title of webpage
	*/
	public function setTitle($title) {
		$this->titleTag	= '<title>' . htmlspecialchars($title) . '</title>';
	}
	
	/**
	* set meta charset definition
	* 
	* @param string $charSet	used charset
	* @param string $tag		the tag to wrap charset, by default the meta charset tag
	*/
	public function setMetaCharsetTag($charSet, $tag = '<meta http-equiv="Content-Type" content="text/html; charset=|" />') {
		$this->metaCharsetTag = str_replace('|', htmlspecialchars($charSet), $tag);
	}
	
	/**
	* set html tag
	* 
	* @param string $tag	html tag
	*/
	public function setHtmlTag($tag = '<html>') {
		$this->htmlTag	= $tag;
	}
	
	/**
	* set head tag
	* 
	* @param string $tag	head tag
	*/
	public function setHeadTag($tag = '<head>') {
		$this->headTag	= $tag;
	}
	
	/**
	* set shortcut tags
	* 
	* @param string $favIcon
	* @param string $iconMimeType
	*/
	public function setShortcutTag($favIcon, $iconMimeType) {
		$this->shortcutTag = '
		<link rel="shortcut icon" href="' . htmlspecialchars($favIcon) . '"' . $iconMimeType . ' />
		<link rel="icon" href="' . htmlspecialchars($favIcon) . '"' . $iconMimeType . ' />';
	}
	
	/**
	* set base url
	* 
	* @param string $url
	* @param string $tag	tag that wraps the base url
	*/
	public function setBaseUrlTag($url, $tag = '<base href="|" />') {
		$this->baseUrlTag = str_replace('|', htmlspecialchars($url), $tag);
	}
	
	/**
	* add meta data
	* 
	* @param string $meta	meta data (complete metatag)
	*/
	public function addMetaData($meta) {	
		$this->metaTags .= $meta . chr(10);
	}
	
	/**
	* add inline HTML comment
	* 
	* @param string $comment
	*/
	public function addInlineComment($comment) {
		$this->inlineComment .= htmlspecialchars($comment) . chr(10);
	}
	
	/**
	* add header data
	* 
	* @param string $data 	free header data for HTML header
	*/
	public function addHeaderData($data) {
		$this->headerData .= $data . chr(10);
	}
	
	
	/* Javascript Files */
	
	/**
	* add JS Libraray. JS Library block is rendered on top of the JS files.
	* 
	* @param string $name
	* @param string $file
	* @param string $type
	* @param int $section 	t3lib_pageIncludes::PART_HEADER (0) or t3lib_pageIncludes::PART_FOOTER (1)
	* @param boolean $compressed	flag if library is compressed
	* @param boolean $forceOnTop	flag if added library should be inserted at begin of this block	
	*/
	public function addJsLibrary($name, $file, $type = 'text/javascript', $section = t3lib_pageIncludes::PART_HEADER, $compressed = TRUE, $forceOnTop = FALSE) {
		if (!in_array(strtolower($name), $this->jsLibraryNames)) {
			$this->jsLibs[$name] = array(
				'file' => $file,
				'type' =>  'text/javascript',
				'section' => $section,
				'compressed' => $compressed,
				'forceOnTop' => $forceOnTop
			);	
		}
		
	}
	
	/**
	* add JS file
	* 
	* @param string $file
	* @param string $type
	* @param boolean $compressed
	* @param boolean $forceOnTop
	*/
	public function addJsFile($file, $type = 'text/javascript', $compressed = FALSE, $forceOnTop = FALSE) {
		if (!isset($this->jsFiles[$file]) && !isset($this->jsFooterFiles[$file])) {
			$this->jsFiles[$file] = array(
				'type' =>  $type,
				'section' => self::PART_HEADER,
				'compressed' => $compressed,
				'forceOnTop' => $forceOnTop
			);
		}
	}
	
	/**
	* add JS file to footer
	* 
	* @param string $file
	* @param string $type
	* @param boolean $compressed
	* @param boolean $forceOnTop
	*/
	public function addJsFooterFile($file, $type = 'text/javascript', $compressed = FALSE, $forceOnTop = FALSE) {
		if (!isset($this->jsFiles[$file]) && !isset($this->jsFooterFiles[$file])) {
			$this->jsFooterFiles[$file] = array(
				'type' =>  $type,
				'section' => self::PART_FOOTER,
				'compressed' => $compressed,
				'forceOnTop' => $forceOnTop
			);
		}
	}
	
	/*Javascript Inline Blocks */	

	/**
	* add JS inline code
	* 
	* @param string $name
	* @param string $block
	* @param boolean $compressed
	* @param boolean $forceOnTop
	*/
	public function addJsInlineCode($name, $block, $compressed = FALSE, $forceOnTop = FALSE) {
		if (!isset($this->jsInline[$name])) {
			$this->jsInline[$name] = array(
				'code' => $block . chr(10),
				'forceOnTop' => $forceOnTop
			);
		}
	}
	
	/**
	* add JS inline code to footer
	* 
	* @param string $name
	* @param string $block
	* @param boolean $compressed
	* @param boolean $forceOnTop
	*/
	public function addJsFooterInlineCode($name, $block, $compressed = FALSE, $forceOnTop = FALSE) {
		if (!isset($this->jsFooterInline[$name])) {
			$this->jsFooterInline[$name] = array(
				'code' => $block . chr(10),
				'compressed' => $compressed,
				'forceOnTop' => $forceOnTop
			);
		}
	}
	
	/**
	* Add JS Handler code, which will be wrapped by the given GS Habdler. 
	* Types of handler are:
	* t3lib_pageIncludes::JSHANDLER_EXTONREADY which wrap code with Ext.onReady(function() {}
	* t3lib_pageIncludes::JSHANDLER_DOCUMENTONREADY which wrap code with Event.observe(document, "load", function() {}
	* 
	* @param string $block
	* @param int $handler	name of the handler, t3lib_pageIncludes::JSHANDLER_EXTONREADY or t3lib_pageIncludes::JSHANDLER_DOCUMENTONREADY 
	*/
	public function addJsHandlerCode($block, $handler = self::JSHANDLER_EXTONREADY) {
		if (in_array($handler, array(self::JSHANDLER_EXTONREADY))) {
			$this->jsHandlerCode[$handler] .= $this->jsHandlerCode[$handler] ? chr(10) . $block : $block;
		}
	}
	
	
	/* CSS Files */
	
	/**
	* add CSS file
	* 
	* @param string $file
	* @param string $rel
	* @param string $media
	* @param string $title
	* @param boolean $compressed
	* @param boolean $forceOnTop 
	*/
	public function addCssFile($file, $rel = 'stylesheet', $media = 'screen', $title = '', $compressed = FALSE, $forceOnTop = FALSE) {
		if (!isset($this->cssFiles[$file])) {
			$this->cssFiles[$file] = array(
				'rel' =>  $rel,
				'media' => $media,
				'title' => $title,
				'compressed' => $compressed,
				'forceOnTop' => $forceOnTop, 
			);
		}
	}
	
	/*CSS Inline Blocks */	

	/**
	* add CSS inline code
	* 
	* @param string $name
	* @param string $block
	* @param boolean $compressed
	* @param boolean $forceOnTop
	*/
	public function addCssInlineBlock($name, $block, $compressed = FALSE, $forceOnTop = FALSE) {
		if (!isset($this->cssInline[$name])) {
			$this->cssInline[$name]  = array(
				'code' => $block . chr(10),
				'compressed' => $compressed,
				'forceOnTop' => $forceOnTop,
			);
		}
	}
	
	
	/* JS Libraries */
	
	/**
	 *  call function if you need the prototype library
	 * 
	 */
   	public function loadPrototype() {	
		$this->addPrototype = TRUE;
	}
	

	/**
	 * call function if you need the Scriptaculous library
	 * 
	 * @param string $modules   add modules you need. use "all" if you need complete modules
	 */
	public function loadScriptaculous($modules = '') {
			// Scriptaculous require prototype, so load prototype too.
		$this->addPrototype = TRUE;
		$this->addScriptaculous = TRUE;
		if ($modules) {
			if ($modules == 'all') {
				foreach ($this->addScriptaculousModules as $key => $value) {
					$this->addScriptaculousModules[$key] = TRUE;
				}
			} else {
				$mods = t3lib_div::trimExplode(',', $modules);
				foreach ($mods as $mod) {
					if (isset($this->addScriptaculousModules[strtolower($mod)])) {
						$this->addScriptaculousModules[strtolower($mod)] = TRUE;
					}
				}
			}
		}
	}
	
	/**
	 * call this function if you need the extJS library
	 * 
	 * @param boolean $css flag, if set the ext-css will be loaded
	 * @param boolean $theme flag, if set the ext-theme "grey" will be loaded
	 * @param string $adapter choose alternative adapter, possible values: yui, prototype, jquery
	 */
	public function loadExtJS($css = TRUE, $theme = TRUE, $adapter = '') {
		if ($adapter) {
				// empty $adapter will always load the ext adapter
			switch (t3lib_div::strtolower(trim($adapter))) {
				case self::EXTJS_ADAPTER_YUI:
					$this->extJSadapter = 'yui/ext-yui-adapter.js';
				break;
				case self::EXTJS_ADAPTER_PROTOTYPE:
				    $this->extJSadapter = 'prototype/ext-prototype-adapter.js';
				break;
				case self::EXTJS_ADAPTER_JQUERY:
					$this->extJSadapter = 'jquery/ext-jquery-adapter.js';
				break;
			}
		}
		if (!$this->addExtJS) {
			$this->addExtJS = TRUE;
			if ($theme) {
				if (isset($GLOBALS['TBE_STYLES']['extJS']['theme'])) {
					$this->addCssFile($this->backPath . $GLOBALS['TBE_STYLES']['extJS']['theme'], 'stylesheet', 'screen', '', FALSE, TRUE);
				} else {
					$this->addCssFile($this->backPath . 'contrib/extjs/resources/css/xtheme-blue.css', 'stylesheet', 'screen', '', FALSE, TRUE);
				}
			}
			if ($css) {
				if (isset($GLOBALS['TBE_STYLES']['extJS']['all'])) {
					$this->addCssFile($this->backPath . $GLOBALS['TBE_STYLES']['extJS']['all'], 'stylesheet', 'screen', '', FALSE, TRUE);
				} else {
					$this->addCssFile($this->backPath . 'contrib/extjs/resources/css/ext-all-notheme.css', 'stylesheet', 'screen', '', FALSE, TRUE);
				}
			}
			
		}
	}

	/**
	* Enable Application loader. Make sure you place returned HTML after <body> and the CSS in your stylesheet or inline code
	* 
	* @param array $labels
	* @param string $loadIcon
	* @return array HTML and CSS for including in page
	*/
	public function enableApplicationLoader($labels = array('TYPO3 Application', 'Loading Core API...', 'Loading UI Components...', 'Initializing Application...'), $loadIcon = 'gfx/typo3ani32.gif') {
		$this->appLoader = TRUE;
		$this->appLoaderLabels = $labels;
		$this->moveJsFromHeaderToFooter = TRUE;
		return array(
			'HTML' => '<div id="loading-mask" style=""></div><div id="loading"><div class="loading-indicator"><img src="' . $this->backPath . $loadIcon . '" style="margin-right:8px;float:left;vertical-align:top;"/>' . $labels[0] . '<br /><span id="loading-msg">' . $labels[1] . '</span></div></div>',
			'CSS' => '#loading-mask{position:absolute;left:0;top:0;width:100%;height:100%;z-index:20000;background-color:white;}#loading{position:absolute;left:45%;top:40%;padding:2px;z-index:20001;height:auto;}#loading a {color:#225588;}#loading .loading-indicator{background:white;color:#444;font:bold 13px tahoma,arial,helvetica;padding:10px;margin:0;height:auto;}#loading-msg {font: normal 10px arial,tahoma,sans-serif;}',
			'JAVASCRIPT' => 'var hideMask = function () {Ext.get("loading").remove();Ext.fly("loading-mask").fadeOut({remove:true});};hideMask.defer(250);'
		);		
	}
	
	
	/**
	 * call function if you need the ExtCore library
	 * 
	 */
   	public function loadExtCore() {	
		$this->addExtCore = TRUE;
	}
	
 	/**	
	 * call this function to load debug version of ExtJS. Use this for development only
	 * 
	 */
	public function enableExtJsDebug() {
		$this->enableExtJsDebug = TRUE;
	}
	
	/**
	 * call this function to load debug version of ExtCore. Use this for development only
	 * 
	 */
	public function enableExtCoreDebug() {
		$this->enableExtCoreDebug = TRUE;
	}
	
	/**
	 * set alternativ template file
	 * 
	 * @param string $file
	 */
	public function setAlternativeTemplateFile($file) {
		$this->templateFile = $file;
	}
	
	
	
	/**
	* Add Javascript Inline Label. This will occur in TYPO3.lang - object
	* The label can be used in scripts with TYPO3.lang.<key>
	* 
	* @param string $key
	* @param string $value
	*/
	public function addInlineLanguageLabel($key, $value) {
		$this->inlineLanguageLabels[$key] = $value;
	}
	
	/**
	* Add Javascript Inline Label Array. This will occur in TYPO3.lang - object 
	* The label can be used in scripts with TYPO3.lang.<key>   
	* Array will be merged with existing array.
	* 
	* @param array $array
	*/
	public function addInlineLanguageLabelArray(array $array) {
		$this->inlineLanguageLabels = array_merge($this->inlineLanguageLabels, $array);
	}
	
	/**
	* Add Javascript Inline Setting. This will occur in TYPO3.settings - object
	* The label can be used in scripts with TYPO3.setting.<key>
	* 
	* @param string $namespace
	* @param string $key
	* @param string $value
	*/
	public function addInlineSetting($namespace, $key, $value) {
		if ($namespace) {
			if(strpos($namespace, '.')) {
				$parts = explode('.', $namespace);
				$a =& $this->inlineSettings;
				foreach ($parts as $part) {
					$a =& $a[$part];					
				}
				$a[$key] = $value;
			} else {
				$this->inlineSettings[$namespace][$key] = $value;
			}
		} else {
			$this->inlineSettings[$key] = $value;
		}
	}
	
	/**
	* Add Javascript Inline Setting. This will occur in TYPO3.settings - object
	* The label can be used in scripts with TYPO3.setting.<key>
	* Array will be merged with existing array.
	* 
	* @param string $namespace
	* @param array $array
	*/
	public function addInlineSettingArray($namespace, array $array) {
		if ($namespace) {
			if(strpos($namespace, '.')) {
				$parts = explode('.', $namespace);
				$a =& $this->inlineSettings;
				foreach ($parts as $part) {
					$a =& $a[$part];					
				}
				$a[$key] = array_merge((array) $a[$key], $value);
			} else {
				$this->inlineSettings[$namespace] = array_merge((array) $this->inlineSettings[$namespace], $array); 
			}
		} else {
			$this->inlineSettings = array_merge($this->inlineSettings, $array);
		}
	}
	
	
	
	
	/*****************************************************/
	/*                                                   */
	/*  Render Functions                                 */
	/*                                                   */
	/*                                                   */
	/*****************************************************/
	
	
	/**
	* render the section (Header or Footer)
	* 
	* @param int $part	section which should be rendered: t3lib_pageIncludes::PART_HEADER or t3lib_pageIncludes::PART_FOOTER
	* @return string	content of rendered section
	*/
	public function render($part = self::PART_HEADER) {
        
        $jsFiles = '<!-- JSFILES -->';
        $noJS = FALSE; 
		if ( ($part === self::PART_HEADER && !$this->moveJsFromHeaderToFooter) || ($part === self::PART_FOOTER && $this->moveJsFromHeaderToFooter)) {
			// render js libraries for header section
			$jsLibs = $this->renderJsLibraries();
		} else {
			$jsLibs = '';
		}
		
		if ($part == self::PART_FOOTER && $this->jsHandlerCode[self::JSHANDLER_EXTONREADY]) {
				$this->jsFooterInline['ExtOnReady'] = array(
					'code' => 'Ext.onReady(function() {' . chr(10) . $this->jsHandlerCode[self::JSHANDLER_EXTONREADY] . chr(10) . '});',
					'compressed' => FALSE,
				);	
		}
		
		
		
		if ($this->moveJsFromHeaderToFooter && $part === self::PART_HEADER) {
			$noJS = TRUE;
			$this->jsFooterFiles = array_merge($this->jsFiles, $this->jsFooterFiles);
			$this->jsFooterInline = array_merge($this->jsInline, $this->jsFooterInline);
			unset($this->jsFiles, $this->jsInline);
		}
		
		
		if ($this->compressCss || $this->compressJavascript) {
			// do the file compression
			$this->doCompress();
		}
		if ($this->concatenateFiles) {
			// do the file concatenation
			$this->doConcatenate();
		}
		
		
		$cssFiles = ''; 
		if (count($this->cssFiles)) {
			foreach ($this->cssFiles as $file=> $properties) {
				if ($properties['forceOnTop']) {
					$cssFiles = '<link rel="' . $properties['rel'] . '" type="text/css" href="' . $file . '" media="' . $properties['media'] .'"' . ($properties['title'] ? ' title="' . $properties['title'] . '"' : '') . ' />' . chr(10) . $cssFiles;
				} else {
					$cssFiles .= '<link rel="' . $properties['rel'] . '" type="text/css" href="' . $file . '" media="' . $properties['media'] .'"' . ($properties['title'] ? ' title="' . $properties['title'] . '"' : '') . ' />' . chr(10);
				}
			} 
		}
		
		$cssInline = '';
		if (count($this->cssInline)) {
			$cssInline .= '<style type="text/css">' . chr(10) . '/*<![CDATA[*/' . chr(10) . '<!-- ' . chr(10);
			foreach ($this->cssInline as $name=> $properties) {
				if ($properties['forceOnTop']) {
					$cssInline = '/*' . htmlspecialchars($name) . '*/' . chr(10) . $properties['code'] . chr(10) . $cssInline;
				} else {
					$cssInline .= '/*' . htmlspecialchars($name) . '*/' . chr(10) . $properties['code'] . chr(10);
				}
			}
			$cssInline .= '-->' . chr(10) . '/*]]>*/' . chr(10) . '</style>' . chr(10);
		}
		
		if ($part === self::PART_HEADER) {
			$refJsLibs = $this->jsLibs;
			$refJsFiles = $this->jsFiles;
			$refJsInline = $this->jsInline;
		} else {
			$refJsLibs = $this->jsLibs;
			$refJsFiles = $this->jsFooterFiles;
			$refJsInline = $this->jsFooterInline;		
		}
		
		
		if (count($refJsLibs)) { 
			foreach ($refJsLibs as $name => $properties) {
				if (($properties['section'] === $part && !$this->moveJsFromHeaderToFooter) || ($this->moveJsFromHeaderToFooter && $part === self::PART_FOOTER)) {
					if ($properties['forceOnTop']) {
						$jsLibs = '<script src="' . $properties['file'] . '" type="' . $properties['type'] . '"></script>' . chr(10) . $jsLibs;
					} else {
						$jsLibs .= '<script src="' . $properties['file'] . '" type="' . $properties['type'] . '"></script>' . chr(10);
					}
				}
			}
		}
		 
		if (count($refJsFiles)) { 
			foreach ($refJsFiles as $file => $properties) {
				if (($properties['section'] === $part && !$this->moveJsFromHeaderToFooter) || ($this->moveJsFromHeaderToFooter && $part === self::PART_FOOTER)) {
					if ($properties['forceOnTop']) {
						$jsFiles = '<script src="' . $file . '" type="' . $properties['type'] . '"></script>' . chr(10) . $jsFiles;
					} else {
						$jsFiles .= '<script src="' . $file . '" type="' . $properties['type'] . '"></script>' . chr(10);
					}
				}
			}
		}
		
		if ($this->appLoader && $this->addExtJS && $part === self::PART_FOOTER) {
			$jsFiles = chr(10) .
				'<script type="text/javascript">document.getElementById(\'loading-msg\').innerHTML = "' . $this->appLoaderLabels[1] . '";</script>' .
			    chr(10) . $jsLibs .
			    '<script type="text/javascript">document.getElementById(\'loading-msg\').innerHTML = "' . $this->appLoaderLabels[2] . '";</script>' .
			    chr(10) . $jsFiles .
			    '<script type="text/javascript">document.getElementById(\'loading-msg\').innerHTML = "' . $this->appLoaderLabels[3] . '";</script>';	
		} else {
			$jsFiles = chr(10) . $jsLibs . chr(10) . $jsFiles;
		}
		
		
			
		$jsInline = '';
		if (count($refJsInline)) {
			$jsInline = '<script type="text/javascript">' . chr(10) . '/*<![CDATA[*/' . chr(10) . '<!-- ' . chr(10);
			foreach ($refJsInline as $name => $properties) {
				if ($properties['forceOnTop']) {
					$jsInline = '/*' . htmlspecialchars($name) . '*/' . chr(10) . $properties['code'] . chr(10) . $jsInline;
				} else {
					$jsInline .= '/*' . htmlspecialchars($name) . '*/' . chr(10) . $properties['code'] . chr(10);
				}
			}
			$jsInline .= '// -->' . chr(10) . '/*]]>*/' . chr(10) . '</script>' . chr(10);
		}
		
		
			// get template
		$templateFile = t3lib_div::getFileAbsFileName($this->templateFile, TRUE);
		$template = t3lib_div::getURL($templateFile);
		
		$subpart =  trim(t3lib_parsehtml::getSubpart($template, '###PART_' . ($part === self::PART_HEADER ? 'HEADER' : 'FOOTER') . '###'));
		
		$markerArray = array(
			'XMLPROLOG_DOCTYPE' => $this->xmlPrologAndDocType,
			'HTMLTAG' => $this->htmlTag,
			'HEADTAG' => $this->headTag,
			'METACHARSET' => $this->metaCharsetTag,
			'INLINECOMMENT' => $this->inlineComment ? chr(10) . chr(10) . '<!-- ' . chr(10) . $this->inlineComment . chr(10) . '-->' . chr(10) . chr(10) : '',
			'BASEURL' => $this->baseUrlTag,
			'SHORTCUT' => $this->shortcutTag,
			'CSS_INCLUDE' => $cssFiles,
			'CSS_INLINE' => $cssInline,
			'JS_INCLUDE' => $jsFiles,
			'JS_INLINE' => $jsInline,
			'TITLE' => $this->titleTag,
			'META' => $this->metaTags,
			'HEADERDATA' => $this->headerData,
			'JS_INCLUDE_FOOTER' => $jsFiles,
			'JS_INLINE_FOOTER' => $jsInline,
		);

		return t3lib_parsehtml::substituteMarkerArray($subpart, $markerArray, '###|###');
	}
	
	/**
	* helper function for render the javascript libraries
	* 
	* @return string	content with javascript libraries
	*/
	protected function renderJsLibraries() {
		$out = '';
		
		if ($this->addPrototype) {
			$out .= '<script src="' . $this->backPath . 'contrib/prototype/prototype.js" type="text/javascript"></script>' . chr(10);
			unset ($this->jsFiles[$this->backPath . 'contrib/prototype/prototype.js']);	
		}
		
		if ($this->addScriptaculous) {
			$mods = array();
			foreach ($this->addScriptaculousModules as $key => $value) {
				if ($this->addScriptaculousModules[$key]) {
					$mods[] = $key;
				}
			}
				// resolve dependencies
			if (in_array('dragdrop', $mods) || in_array('controls', $mods)) {
				$mods = array_merge(array('effects'), $mods);
			}

			if (count($mods)) {
				$moduleLoadString = '?load=' . implode(',', $mods);
			}
			
			$out .= '<script src="' . $this->backPath . 'contrib/scriptaculous/scriptaculous.js' . $moduleLoadString . '" type="text/javascript"></script>' . chr(10);
			unset ($this->jsFiles[$this->backPath . 'contrib/scriptaculous/scriptaculous.js' . $moduleLoadString]);
		}
		
			// include extCore 
		if ($this->addExtCore) {
			$out .= '<script src="' . $this->backPath . 'contrib/extjs/ext-core' . ($this->enableExtCoreDebug ? '-debug' : '') . '.js" type="text/javascript"></script>' . chr(10);
			unset ($this->jsFiles[$this->backPath . 'contrib/extjs/ext-core' . ($this->enableExtCoreDebug ? '-debug' : '') . '.js']);
		}
		
			// include extJS 
		if ($this->addExtJS) {
				// use the base adapter all the time
			$out .= '<script src="' . $this->backPath . 'contrib/extjs/adapter/' . $this->extJSadapter . '" type="text/javascript"></script>' . chr(10);
			$out .= '<script src="' . $this->backPath . 'contrib/extjs/ext-all' . ($this->enableExtJsDebug ? '-debug' : '') . '.js" type="text/javascript"></script>' . chr(10);
			
				// add extJS localization
			$localeMap = $this->csConvObj->isoArray;	// load standard ISO mapping and modify for use with ExtJS
			$localeMap[''] = 'en';
			$localeMap['default'] = 'en';
			$localeMap['gr'] = 'el_GR';	// Greek
			$localeMap['no'] = 'no_BO';	// Norwegian Bokmaal
			$localeMap['se'] = 'se_SV';	// Swedish
			
			$extJsLang = isset($localeMap[$this->lang]) ? $localeMap[$this->lang] : $this->lang;
			// TODO autoconvert file from UTF8 to current BE charset if necessary!!!!
			$extJsLocaleFile = 'contrib/extjs/locale/ext-lang-' . $extJsLang . '-min.js';
			if (file_exists(PATH_typo3 . $extJsLocaleFile)) {
				$out .= '<script src="' . $this->backPath . $extJsLocaleFile . '" type="text/javascript"></script>' . chr(10);
			}
				// set clear.gif, move it on top
			$this->jsHandlerCode[self::JSHANDLER_EXTONREADY] = 
				'Ext.ns("TYPO3");
				Ext.BLANK_IMAGE_URL = "' . htmlspecialchars(t3lib_div::locationHeaderUrl($this->backPath . 'gfx/clear.gif')) . '";' . chr(10) .
				'TYPO3.lang = ' . json_encode($this->inlineLanguageLabels) . ';' . 
				'TYPO3.settings = ' . json_encode($this->inlineSettings) . ';' . 
				($this->enableExtJSQuickTips ? 'Ext.QuickTips.init();' . chr(10) : '') .
				$this->jsHandlerCode[self::JSHANDLER_EXTONREADY];
				// remove extjs from JScodeLibArray
			unset ($this->jsFiles[$this->backPath . 'contrib/extjs/ext-all.js']);
			unset ($this->jsFiles[$this->backPath . 'contrib/extjs/ext-all-debug.js']);
		}
		
		return $out;
	}
	
	/*****************************************************/
	/*                                                   */
	/*  Tools                                            */
	/*                                                   */
	/*                                                   */
	/*****************************************************/
	
	/**
	* concatenate files into one file
	* registered handler
	* TODO: implement own method
	* 
	* @return void
	*/
	protected function doConcatenate() {
		// traverse the arrays, concatenate in one file
		// then remove concatenated files from array and add the concatenated file
		
			// extern concatination
		if ($this->concatenateFiles && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['concatenateHandler']) {
			// use extern concatenate routine
			$params = array(
				'jsFiles' => $this->jsFiles,
				'jsFooterFiles' => $this->jsFooterFiles,
				'cssFiles' => $this->cssFiles,
			);
			t3lib_div::callUserFunction($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['concatenateHandler'], $params, $this); 
		} else {
			// own method
			
		}
		
	}
	
	/**
	* compress inline code
	* 
	*/
	protected function doCompress() {
		
		if ($this->compressJavascript && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['jsCompressHandler']) {
			// use extern compress routine
			$params = array(
				'jsInline' => $this->jsInline,
				'jsFooterInline' => $this->jsFooterInline,
			);
			t3lib_div::callUserFunction($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['jsCompressHandler'], $params, $this);
		} else {
			// traverse the arrays, compress files
			$this->compressError = '';

			if ($this->compressJavascript) {
				if (count($this->jsInline)) {
					foreach ($this->jsInline as $name => $properties) {
						if (!$properties['compressed']) {
							$error = '';
							$this->jsInline[$name]['code'] = t3lib_div::minifyJavaScript($properties['code'], $error);	
							if ($error) {
								$this->compressError .= 'Error with minify JS Inline Block "' . $name . '": ' . $error . chr(10);
							}
						}
					}
				}
				if (count($this->jsFooterInline)) {
					foreach ($this->jsFooterInline as $name => $properties) {
						if (!$properties['compressed']) {
							$error = '';
							$this->jsFooterInline[$name]['code'] = t3lib_div::minifyJavaScript($properties['code'], $error);
							if ($error) {
								$this->compressError .= 'Error with minify JS Inline Block "' . $name . '": ' . $error . chr(10);
							}	
						}
					}
				}
			}
		}
		
		
		if ($this->compressJavascript && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['cssCompressHandler']) {
			// use extern compress routine
			$params = array(
				'cssInline' => $this->cssInline,
			);
			t3lib_div::callUserFunction($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['cssCompressHandler'], $params, $this);
		} else {
			if ($this->compressCss) {
				// need real compressor script first
			}
		}
		
	}
	

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['t3lib/class.t3lib_pageincludes.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['t3lib/class.t3lib_pageincludes.php']);
}
?>
