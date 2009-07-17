<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'Pi1',
	'MVC ExtJS Samples - Hello World'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_pi1'] = 'layout,select_key,pages';

?>