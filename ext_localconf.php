<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

	// Plugin registration (frontend rendering)
Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'Pi1',
	array('HelloWorld' => 'index'),
	array()
);

Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'Pi2',
	array('SimpleForm' => 'index,genres'),
	array('SimpleForm' => 'genres')			// Action 'genres' is used for AJAX and thus should not be cached
);

Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'Pi3',
	array('Twitter' => 'index'),
	array()
);

Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'Pi4',
	array('Feeds' => 'index,feeds'),
	array('Feeds' => 'feeds')
);
?>