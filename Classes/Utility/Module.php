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
 * Utilities to manage the modules of an extension.
 *
 * @category    Extbase
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Xavier Perseguers <typo3@perseguers.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id$
 */
class Tx_MvcExtjsSamples_Utility_Module {

	/**
	 * Registers an Extbase module (main or sub) to the backend interface.
	 * FOR USE IN ext_tables.php FILES
	 *
	 * @param string $extensionName The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	 * @param array $controllerActions is an array of allowed combinations of controller and action stored in an array (controller name as key and a comma separated list of action names as value, the first controller and its first action is chosen as default)
	 * @param array $config The configuration options of the module (icon, locallang.xml file)
	 * @param string $main The main module key, $sub is the submodule key. So $main would be an index in the $TBE_MODULES array and $sub could be an element in the lists there. If $main is not set a blank $extensionName module is created
	 * @param string $sub The submodule key. If $sub is not set a blank $main module is created
	 * @param string $position This can be used to set the position of the $sub module within the list of existing submodules for the main module. $position has this syntax: [cmd]:[submodule-key]. cmd can be "after", "before" or "top" (or blank which is default). If "after"/"before" then submodule will be inserted after/before the existing submodule with [submodule-key] if found. If not found, the bottom of list. If "top" the module is inserted in the top of the submodule list.
	 * @return void
	 */
	public static function registerModule($extensionName, array $controllerActions, $config = array(), $main = '', $sub = '', $position = '') {
		if (empty($extensionName)) {
			throw new InvalidArgumentException('The extension name was invalid (must not be empty and must match /[A-Za-z][_A-Za-z0-9]/)', 1239891989);
		}
		$extensionKey = $extensionName;
		$extensionName = str_replace(' ', '', ucwords(str_replace('_', ' ', $extensionName)));
		
		$path = t3lib_extMgm::extPath($extensionKey, 'Classes/');
		$relPath = t3lib_extMgm::extRelPath($extensionKey) . 'Classes/';
		
		if (!isset($GLOBALS['TBE_EXTBASE_MODULES'])) {
			$GLOBALS['TBE_EXTBASE_MODULES'] = array();
		}
		
		if ($main && !isset($GLOBALS['TBE_MODULES'][$main])) {
			$main = $extensionName . ucfirst($main);
		} else {
			$main = $main ? $main : $extensionName;
		}
		
		if (!is_array($config) || count($config) == 0) {
			$config['access'] = 'admin';
			$config['icon'] = '';
			$config['labels'] = '';
			$onfig['extRelPath'] = $relPath;
		}
		
		$key = $main . ($sub ? '_' . $sub : '');
		
		$moduleConfig = array(
			'name' => $key,
			'extensionKey' => $extensionKey,	
			'extension' => $extensionName,
			'controllerActions' => $controllerActions,
			'config' => $config,
		);
		$GLOBALS['TBE_EXTBASE_MODULES'][$key] = $moduleConfig;
		$GLOBALS['TBE_EXTBASE_MODULES'][$key]['configureModuleFunction'] = array('Tx_MvcExtjsSamples_Utility_Module', 'setModuleConfiguration');
		
			// Add the module to the backend
		
		t3lib_extMgm::addModule($main, $sub, $position, $path);
	}
	
	/**
	* this is called from t3lib_loadModules::checkMod and it replaces old conf.php
	* 
	* @param string $key
	* @param array $MCONF
	* @param array $MLANG
	*/
	public function setModuleConfiguration($key, &$MCONF, &$MLANG) {
		
		$config = $GLOBALS['TBE_EXTBASE_MODULES'][$key]['config'];
		define('TYPO3_MOD_PATH', $config['extRelPath']);

		$GLOBALS['BACK_PATH'] = '';  
		
		// fill $MCONF
		$MCONF['name'] = $key;
		$MCONF['access'] = $config['access'];
		$MCONF['script'] = '_DISPATCH';

		if (substr($config['icon'], 0, 4) === 'EXT:') {
			list($extKey, $local) = explode('/', substr($config['icon'], 4), 2);
				// TODO: be a bit more clever here
			$config['icon'] = t3lib_extMgm::extRelPath($extKey) . $local;
		}
         
			// Initializing search for alternative icon:
		$altIconKey = 'MOD:' . $key . '/' . $config['icon'];		// Alternative icon key (might have an alternative set in $TBE_STYLES['skinImg']
		$altIconAbsPath = is_array($GLOBALS['TBE_STYLES']['skinImg'][$altIconKey]) ? t3lib_div::resolveBackPath(PATH_typo3.$GLOBALS['TBE_STYLES']['skinImg'][$altIconKey][0]) : '';

			// Setting icon, either default or alternative:
		if ($altIconAbsPath && @is_file($altIconAbsPath))	{
			$tabImage = $altIconAbsPath;
		} else {
				// Setting default icon:
			$tabImage = $config['icon'];
		}

			// // fill $MLANG
		$MLANG['default']['ll_ref'] = $config['labels'];   
		
			// Finally, setting the icon with correct path:
		if (substr($tabImage, 0 ,3) == '../') {
			$MLANG['default']['tabs_images']['tab'] = PATH_site . substr($tabImage, 3);
		} else {
			$MLANG['default']['tabs_images']['tab'] = PATH_typo3 . $tabImage;
		}
		
			// If LOCAL_LANG references are used for labels of the module:
		if ($MLANG['default']['ll_ref'])	{
				// Now the 'default' key is loaded with the CURRENT language - not the english translation...
			$MLANG['default']['labels']['tablabel'] = $GLOBALS['LANG']->sL($MLANG['default']['ll_ref'].':mlang_labels_tablabel');
			$MLANG['default']['labels']['tabdescr'] = $GLOBALS['LANG']->sL($MLANG['default']['ll_ref'].':mlang_labels_tabdescr');
			$MLANG['default']['tabs']['tab'] = $GLOBALS['LANG']->sL($MLANG['default']['ll_ref'].':mlang_tabs_tab');
			$GLOBALS['LANG']->addModuleLabels($MLANG['default'],$key.'_');
		} else {	// ... otherwise use the old way:
			$GLOBALS['LANG']->addModuleLabels($MLANG['default'],$key.'_');
			$GLOBALS['LANG']->addModuleLabels($MLANG[$GLOBALS['LANG']->lang],$key.'_');
		}
		
			// // fill $modconf
		$modconf['script'] = 'mod.php?M=TX_' . rawurlencode($key);
		$modconf['name'] = $key;
					
				// Default tab setting
		if ($MCONF['defaultMod'])	{
			$modconf['defaultMod'] = $MCONF['defaultMod'];
		}
			// Navigation Frame Script (GET params could be added)
		if ($MCONF['navFrameScript']) {
			$navFrameScript = explode('?', $MCONF['navFrameScript']);
			$navFrameScript = $navFrameScript[0];
			if (file_exists($path.'/'.$navFrameScript))	{
				$modconf['navFrameScript'] = $this->getRelativePath(PATH_typo3,$fullpath.'/'.$MCONF['navFrameScript']);
			}
		}
			// additional params for Navigation Frame Script: "&anyParam=value&moreParam=1"
		if ($MCONF['navFrameScriptParam']) {
			$modconf['navFrameScriptParam'] = $MCONF['navFrameScriptParam'];
		}
				
		return $modconf;
	}
	
	
	
}
?>