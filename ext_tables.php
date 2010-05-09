<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// ========== Plugin HelloWorld

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'HelloWorld',
	'MVC ExtJS Samples - Hello World'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'ViewBasedModule',
	'MVC ExtJS Samples - View Based Module'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_helloworld'] = 'layout,select_key,pages';


// ========== Plugin SimpleForm

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'SimpleForm',
	'MVC ExtJS Samples - Simple Form'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_simpleform'] = 'layout,select_key,pages';


// ========== Plugin Twitter

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Twitter',
	'MVC ExtJS Samples - Twitter'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_twitter'] = 'layout,select_key,pages';

	// Register FlexForm
$TCA['tt_content']['types']['list']['subtypes_addlist']['mvcextjssamples_twitter'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('mvcextjssamples_twitter', 'FILE:EXT:mvc_extjs_samples/Configuration/FlexForms/Twitter.xml');


// ========== Plugin Feeds

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Feeds',
	'MVC ExtJS Samples - Feeds'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_feeds'] = 'layout,select_key,pages';

	// Register FlexForm
$TCA['tt_content']['types']['list']['subtypes_addlist']['mvcextjssamples_feeds'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('mvcextjssamples_feeds', 'FILE:EXT:mvc_extjs_samples/Configuration/FlexForms/Feeds.xml');


// ========== Plugin PictureSlideShow

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'PictureSlideShow',
	'MVC ExtJS Samples - Picture Slide Show'
);

	// Disable the display of layout, select_key and page fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_pictureslideshow'] = 'layout,select_key,pages';

	// Register FlexForm
$TCA['tt_content']['types']['list']['subtypes_addlist']['mvcextjssamples_pictureslideshow'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('mvcextjssamples_pictureslideshow', 'FILE:EXT:mvc_extjs_samples/Configuration/FlexForms/PictureSlideShow.xml');

// ========== Plugin Movie

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
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

// ========== Plugin FeUserAdmin

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'FeUserAdmin',
	'MVC ExtJS Samples - FeUser Admin'
);

	// Disable the display of layout and select_key fields
$TCA['tt_content']['types']['list']['subtypes_excludelist']['mvcextjssamples_feuseradmin'] = 'layout,select_key';

if (TYPO3_MODE == 'BE') {
	// ========== Module Blank

	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'user',		// Make Blank module a submodule of 'user'
		'blank',	// Submodule key
		'',			// Position
		array(
			'BlankModule' => 'first,second,third',
			'SimpleForm' => 'index',
			'Genre' => 'index',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:mvc_extjs_samples/Resources/Public/Icons/movie_add.png',
			'labels' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_mod_blank.xml',
		)
	);

	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'user',       // Make Blank module a submodule of 'user'
		'viewbased',  // Submodule key
		'',           // Position
		array(
			'ViewBasedModule' => 'index',
			'Genre' => 'index,update,create,delete',
			'Movie' => 'movies,update,create,delete'
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:mvc_extjs_samples/Resources/Public/Icons/movie_add.png',
			'labels' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_mod_viewbased.xml',
		)
	);

	// ========== Extension Simple Module Function
	
	//Tx_Extbase_Utility_Extension::registerModuleFunction(
	//	$_EXTKEY,
	//	'user_MvcExtjsSamplesBlank',	// Insert module function into function menu of Module Blank
	//	array(
	//		'SimpleModuleFunction' => 'index,other',
	//	),
	//	array(
	//		'title'      => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:moduleFunction.simple',
	//		'menuKey'    => 'function',
	//		'workspaces' => '',
	//	)
	//);
	
	//Tx_Extbase_Utility_Extension::registerModuleFunction(
	//	$_EXTKEY,
	//	'web_info',	// Insert module function into function menu of Web > Info
	//	array(
	//		'SimpleModuleFunction' => 'index,other',
	//	),
	//	array(
	//		'title'      => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:moduleFunction.simple',
	//		'menuKey'    => 'function',
	//		'workspaces' => '',
	//	)
	//);
	
	// ========== Legacy (SCbase) function
	
	t3lib_extMgm::insertModuleFunction(
		'user_MvcExtjsSamplesBlank',	// Insert legacy function into function menu of Module Blank
		'tx_mvcextjssamples_modfunc1',
		t3lib_extMgm::extPath($_EXTKEY) . 'modfunc1/class.tx_mvcextjssamples_modfunc1.php',
		'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:moduleFunction.tx_mvcextjssamples_modfunc1'
	);

	// ========== Module OldStyle

	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',		// Make OldStyle module a submodule of 'web'
		'oldstyle',	// Submodule key
		'',			// Position
		array(
			'OldStyleModule' => 'index'
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:mvc_extjs_samples/Resources/Public/Icons/movie_add.png',
			'labels' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/OldStyleModule.xml',
		)
	);
}

// ========== Common

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'MVC ExtJS Samples');   
?>