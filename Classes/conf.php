<?php

// TYPO3_MOD_PATH is the path to the directory containing this file
// relative to within typo3/ directory
$pathExt = substr(dirname(__FILE__), strlen(PATH_site));
if (substr($pathExt, 0, strlen(TYPO3_mainDir) === TYPO3_mainDir)) {
		// Extension is within directory typo3/ (either global or system)
	$pathExt = substr($pathExt, strlen(TYPO3_mainDir) + 1) . '/';
} else {
	$pathExt = '../' . $pathExt;
}
define('TYPO3_MOD_PATH', $pathExt);

// remark: $name comes from class.t3lib_loadmodules.php
$MCONF['name'] = $name;

$config = $GLOBALS['TBE_EXTBASE_MODULES'][$name]['config'];

$MCONF['access'] = $config['access'];
$MCONF['extbase'] = TRUE;
$MCONF['script'] = '_DISPATCH';

if (substr($config['icon'], 0, 4) === 'EXT:') {
	list($extKey, $local) = explode('/', substr($config['icon'], 4), 2);
	// TODO: be a bit more clever here
	$config['icon'] = $BACK_PATH . t3lib_extMgm::extRelPath($extKey) . $local;
}

$MLANG['default']['tabs_images']['tab'] = $config['icon'];
$MLANG['default']['ll_ref'] = $config['labels'];
?>