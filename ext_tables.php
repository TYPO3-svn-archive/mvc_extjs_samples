<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// ========== Plugin HelloWorld

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'HelloWorld',
	'MVC ExtJS Samples - Hello World'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_helloworld'] = 'layout,select_key,pages';


// ========== Plugin SimpleForm

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'SimpleForm',
	'MVC ExtJS Samples - Simple Form'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_simpleform'] = 'layout,select_key,pages';


// ========== Plugin Twitter

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'Twitter',
	'MVC ExtJS Samples - Twitter'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_twitter'] = 'layout,select_key,pages';

	// Register FlexForm
$TCA['tt_content']['types']['list']['subtypes_addlist']['mvcextjssamples_twitter'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('mvcextjssamples_twitter', 'FILE:EXT:mvc_extjs_samples/Configuration/FlexForms/Twitter.xml');


// ========== Plugin Feeds

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'Feeds',
	'MVC ExtJS Samples - Feeds'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_feeds'] = 'layout,select_key,pages';

	// Register FlexForm
$TCA['tt_content']['types']['list']['subtypes_addlist']['mvcextjssamples_feeds'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('mvcextjssamples_feeds', 'FILE:EXT:mvc_extjs_samples/Configuration/FlexForms/Feeds.xml');


// ========== Common

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'MVC ExtJS Samples');   
?>
