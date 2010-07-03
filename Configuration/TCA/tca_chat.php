<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_mvcextjssamples_domain_model_chat'] = array (
	'ctrl' => $TCA['tx_mvcextjssamples_domain_model_chat']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => ''
	),
	'feInterface' => $TCA['tx_mvcextjssamples_domain_model_chat']['feInterface'],
	'columns' => array(
		'backendUser' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_chat.backenduser',		
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'be_users',
				'foreign_class' => 'Tx_MvcExtjsSamples_Domain_Model_BackendUser',
				'minitems' => 1,
				'maxitems' => 1,
			)
		),
		'channels' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_chat.channels',		
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_mvcextjssamples_domain_model_channel',
				'foreign_class' => 'Tx_MvcExtjsSamples_Domain_Model_Channel',
				'MM' => 'tx_mvcextjssamples_chat_channel_mm',
				'minitems' => 1,
				'maxitems' => 1,
			)
		),
	),
	'types' => array(
		'0' => array()
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_mvcextjssamples_domain_model_channel'] = array (
	'ctrl' => $TCA['tx_mvcextjssamples_domain_model_channel']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name'
	),
	'feInterface' => $TCA['tx_mvcextjssamples_domain_model_channel']['feInterface'],
	'columns' => array(
		'messages' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_chat.messages',		
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_mvcextjssamples_domain_model_message',
				'foreign_class' => 'Tx_MvcExtjsSamples_Domain_Model_Message',
				'MM' => 'tx_mvcextjssamples_channel_message_mm',
				'minitems' => 1,
				'maxitems' => 1,
			)
		),
		'name' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_chat.messages',		
			'config' => array(
				'type' => 'input',
			)
		),
	),
	'types' => array(
		'0' => array()
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_mvcextjssamples_domain_model_message'] = array (
	'ctrl' => $TCA['tx_mvcextjssamples_domain_model_message']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => ''
	),
	'feInterface' => $TCA['tx_mvcextjssamples_domain_model_message']['feInterface'],
	'columns' => array(
		'backendUser' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_message.backenduser',		
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'be_users',
				'foreign_class' => 'Tx_MvcExtjsSamples_Domain_Model_BackendUser',
				'minitems' => 1,
				'maxitems' => 1,
			)
		),
		'text' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:tx_mvcextjssamples_domain_model_message.text',		
			'config' => array(
				'type' => 'input',
			)
		),
	),
	'types' => array(
		'0' => array()
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>