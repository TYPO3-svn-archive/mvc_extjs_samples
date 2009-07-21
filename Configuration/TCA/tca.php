<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_mvcextjssamples_domain_model_movie'] = array(
	'ctrl' => $TCA['tx_mvcextjssamples_domain_model_movie']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,director,release_date,tagline,filmed_in,is_bad,genre'
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check'
			)
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie.title',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim,required',
				'max'  => 256
			)
		),
		'director' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie.director',		
			'config' => array(
				'type' => 'input',	
				'size' => '20',	
				'max' => '255',
			)
		),
		'release_date' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie.release_date',		
			'config' => array (
				'type'	 => 'input',
				'size'	 => '8',
				'max'	  => '20',
				'eval'	 => 'date',
				'checkbox' => '0',
				'default'  => '0'
			)
		),
		'tagline' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie.tagline',
			'config' => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'filmed_in' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie.filmed_in',		
			'config' => array (
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie.filmed_in.I.0', '0'),
					array('LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie.filmed_in.I.1', '1'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'is_bad' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie.is_bad',		
			'config' => array(
				'type' => 'check',
			)
		),
		'genre' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_movie.genre',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_MvcExtjsSamples_Domain_Model_Genre',
				'foreign_table' => 'tx_mvcextjssamples_domain_model_genre',
				'foreign_table_where' => 'ORDER BY tx_mvcextjssamples_domain_model_genre.name',
				'size' => 1,
				'minitems' => 1,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, director;;;;3-3-3, release_date, tagline;;;;4-4-4, filmed_in, is_bad, genre')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);

$TCA['tx_mvcextjssamples_domain_model_genre'] = array (
	'ctrl' => $TCA['tx_mvcextjssamples_domain_model_genre']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name'
	),
	'feInterface' => $TCA['tx_mvcextjssamples_domain_model_genre']['feInterface'],
	'columns' => array(
		'name' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_genre.name',		
			'config' => array(
				'type' => 'input',	
				'size' => '20',	
				'max' => '50',	
				'eval' => 'required',
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'name;;;;1-1-1')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>