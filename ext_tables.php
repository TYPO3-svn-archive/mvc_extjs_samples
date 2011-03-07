<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// ========== Register BE Modules
if (TYPO3_MODE == 'BE') {
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'user',
		'Module',
		'',
		array(
			'Module' => 'index',
			'Movie' => 'index,update,destroy,create',
			'Genre' => 'index,update,destroy,create'
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:mvc_extjs_samples/Resources/Public/Icons/movie_add.png',
			'labels' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_mod_module.xml',
		)
	);
}

// ========== Database configuration
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