<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

	// Plugin registration (listing in backend)
Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'HelloWorld',
	'MVC ExtJS Samples - Hello World'
);

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'SimpleForm',
	'MVC ExtJS Samples - Simple Form'
);

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'Twitter',
	'MVC ExtJS Samples - Twitter'
);

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'Feeds',
	'MVC ExtJS Samples - Feeds'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_helloworld'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_simpleform'] = 'layout,select_key,pages';

$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_twitter'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist']['mvcextjssamples_twitter'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('mvcextjssamples_twitter', 'FILE:EXT:mvc_extjs_samples/Configuration/FlexForms/Twitter.xml');

$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_feeds'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist']['mvcextjssamples_feeds'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('mvcextjssamples_feeds', 'FILE:EXT:mvc_extjs_samples/Configuration/FlexForms/Feeds.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Mvc ExtJS Samples');   

?>