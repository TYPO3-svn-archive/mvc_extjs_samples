<?php

	// DO NOT REMOVE OR CHANGE THESE 3 LINES:
define('TYPO3_MOD_PATH', '../../typo3conf/ext/mvc_extjs_samples/Classes/');
$BACK_PATH = '../../../../typo3/';

// remark: $name comes from class.t3lib_loadmodules.php
$MCONF['name'] = $name;

$config = $GLOBALS['TBE_EXTBASE_MODULES'][$name]['config'];

$MCONF['access'] = $config['access'];
$MCONF['script'] = 'BackendDispatcher.php';

if (substr($config['icon'], 0, 4) === 'EXT:') {
	list($extKey, $local) = explode('/', substr($config['icon'], 4), 2);
	// TODO: be a bit more clever here
	$config['icon'] = $BACK_PATH . t3lib_extMgm::extRelPath($extKey) . $local;
}

$MLANG['default']['tabs_images']['tab'] = $config['icon'];
$MLANG['default']['ll_ref'] = $config['labels'];
?>