<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

	// Plugin registration (listing in backend)
Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'Pi1',
	'MVC ExtJS Samples - Hello World'
);

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'Pi2',
	'MVC ExtJS Samples - Simple Form'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_pi1'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_pi2'] = 'layout,select_key,pages';
?>