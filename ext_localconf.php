<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// ========== Plugin HelloWorld

Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'HelloWorld',
	array('HelloWorld' => 'index'),
	array()
);


// ========== Plugin SimpleForm

Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'SimpleForm',
	array('SimpleForm' => 'index,genres'),
	array('SimpleForm' => 'genres')			// Action 'genres' is used for AJAX and thus should not be cached
);


// ========== Plugin Twitter

Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'Twitter',
	array('Twitter' => 'index'),
	array()
);


// ========== Plugin Feeds

Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'Feeds',
	array('Feeds' => 'index,feeds'),
	array('Feeds' => 'feeds')
);


// ========== Plugin PictureSlideShow

Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'PictureSlideShow',
	array('PictureSlideShow' => 'index'),
	array()
);


// ========== Plugin Movie

Tx_Extbase_Utility_Plugin::configureDispatcher(
	'MvcExtjsSamples',
	'Movie',
	array('Movie' => 'index'),
	array()
);
?>