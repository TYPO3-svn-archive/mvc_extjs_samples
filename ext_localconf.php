<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Plugin::registerTypoScript(
	'MvcExtjsSamples',
	'Pi1',
	array( 
		'HelloWorld' => 'index', 
		),
	array(
		
		)
);
?>