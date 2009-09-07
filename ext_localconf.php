<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// ========== Plugin HelloWorld

Tx_Extbase_Utility_Extension::configurePlugin(
	'MvcExtjsSamples',
	'HelloWorld',
	array('HelloWorld' => 'index'),
	array()
);


// ========== Plugin SimpleForm

Tx_Extbase_Utility_Extension::configurePlugin(
	'MvcExtjsSamples',
	'SimpleForm',
	array(
		'SimpleForm' => 'index',
		'Genre' => 'index',
	),
	array('Genre' => 'index')			// Action 'index' from controller 'Genre' is used for AJAX and thus should not be cached
);


// ========== Plugin Twitter

Tx_Extbase_Utility_Extension::configurePlugin(
	'MvcExtjsSamples',
	'Twitter',
	array('Twitter' => 'index'),
	array()
);


// ========== Plugin Feeds

Tx_Extbase_Utility_Extension::configurePlugin(
	'MvcExtjsSamples',
	'Feeds',
	array('Feeds' => 'index,feeds'),
	array('Feeds' => 'feeds')
);


// ========== Plugin PictureSlideShow

Tx_Extbase_Utility_Extension::configurePlugin(
	'MvcExtjsSamples',
	'PictureSlideShow',
	array('PictureSlideShow' => 'index'),
	array()
);


// ========== Plugin Movie

Tx_Extbase_Utility_Extension::configurePlugin(
	'MvcExtjsSamples',
	'Movie',
	array(
		'Movie' => 'index,update,movies',
		'Genre' => 'index',
	),
	array(
		'Movie' => 'update,movies',
		'Genre' => 'index',
	)
);

	// Add button save+new for movie records
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_mvcextjssamples_domain_model_movie=1
');

?>
