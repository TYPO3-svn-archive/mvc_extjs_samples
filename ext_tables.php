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

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'Pi3',
	'MVC ExtJS Samples - Twitter'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_pi1'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_pi2'] = 'layout,select_key,pages';

$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_pi3'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist']['mvcextjssamples_pi3'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('mvcextjssamples_pi3', 'FILE:EXT:mvc_extjs_samples/Resources/Private/FlexForms/Twitter.xml');
?>