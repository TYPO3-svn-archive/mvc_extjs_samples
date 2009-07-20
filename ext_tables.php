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


// ========== Plugin PictureSlideShow

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'PictureSlideShow',
	'MVC ExtJS Samples - Picture Slide Show'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_pictureslideshow'] = 'layout,select_key,pages';

	// Register FlexForm
$TCA['tt_content']['types']['list']['subtypes_addlist']['mvcextjssamples_pictureslideshow'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('mvcextjssamples_pictureslideshow', 'FILE:EXT:mvc_extjs_samples/Configuration/FlexForms/PictureSlideShow.xml');

// ========== Plugin Movie

Tx_Extbase_Utility_Plugin::registerPlugin(
	'MvcExtjsSamples',
	'Movie',
	'MVC ExtJS Samples - Movie'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_movie'] = 'layout,select_key,pages';

	// Database configuration
t3lib_extMgm::allowTableOnStandardPages('tx_mvcextjssamples_domain_model_movie');
$TCA['tx_mvcextjssamples_domain_model_movie'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie',		
		'label'	=> 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY title',
		'adminOnly' => 1,
		'rootLevel' => 1,
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_mvcextjssamples_domain_model_movie.gif',
	),
);

t3lib_extMgm::allowTableOnStandardPages('tx_mvcextjssamples_domain_model_genre');
$TCA['tx_mvcextjssamples_domain_model_genre'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_genre',		
		'label'	=> 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY name',
		'adminOnly' => 1,
		'rootLevel' => 1,	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_mvcextjssamples_domain_model_genre.gif',
	),
);


// ========== Common

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'MVC ExtJS Samples');   
?>