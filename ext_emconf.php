<?php

########################################################################
# Extension Manager/Repository config file for ext: "mvc_extjs_samples"
#
# Auto generated 17-10-2009 14:50
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'MVC + ExtJS Samples',
	'description' => 'Samples on how to use Extbase and Fluid (MVC) combined with ExtJS',
	'category' => 'example',
	'author' => 'Xavier Perseguers',
	'author_email' => 'typo3@perseguers.ch',
	'shy' => '',
	'dependencies' => 'extbase,fluid,mvc_extjs',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.1.1',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.3.0-0.0.0',
			'extbase' => '0.0.0-0.0.0',
			'fluid' => '0.0.0-0.0.0',
			'mvc_extjs' => '0.1.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:81:{s:9:"ChangeLog";s:4:"16e6";s:23:"README.FeUserAdmins.txt";s:4:"8489";s:16:"README.Feeds.txt";s:4:"5d86";s:21:"README.HelloWorld.txt";s:4:"9d1c";s:16:"README.Movie.txt";s:4:"2eb3";s:27:"README.PictureSlideShow.txt";s:4:"bfa6";s:21:"README.SimpleForm.txt";s:4:"a498";s:18:"README.Twitter.txt";s:4:"87ee";s:10:"README.txt";s:4:"c53a";s:16:"ext_autoload.php";s:4:"3832";s:12:"ext_icon.gif";s:4:"0c18";s:17:"ext_localconf.php";s:4:"c32f";s:14:"ext_tables.php";s:4:"6b17";s:14:"ext_tables.sql";s:4:"8912";s:25:"ext_tables_static+adt.sql";s:4:"ef74";s:24:"ext_typoscript_setup.txt";s:4:"1f82";s:14:"doc/manual.sxw";s:4:"6218";s:44:"Classes/Controller/BlankModuleController.php";s:4:"2552";s:44:"Classes/Controller/FeUserAdminController.php";s:4:"ebba";s:38:"Classes/Controller/FeedsController.php";s:4:"17ab";s:38:"Classes/Controller/GenreController.php";s:4:"b4a7";s:43:"Classes/Controller/HelloWorldController.php";s:4:"f4e5";s:38:"Classes/Controller/MovieController.php";s:4:"d237";s:47:"Classes/Controller/OldStyleModuleController.php";s:4:"5900";s:49:"Classes/Controller/PictureSlideShowController.php";s:4:"4054";s:43:"Classes/Controller/SimpleFormController.php";s:4:"1f86";s:40:"Classes/Controller/TwitterController.php";s:4:"f50b";s:30:"Classes/Domain/Model/Genre.php";s:4:"da52";s:30:"Classes/Domain/Model/Movie.php";s:4:"1a7d";s:45:"Classes/Domain/Repository/GenreRepository.php";s:4:"941e";s:45:"Classes/Domain/Repository/MovieRepository.php";s:4:"d7dc";s:33:"Configuration/TypoScript/ajax.txt";s:4:"b346";s:34:"Configuration/TypoScript/setup.txt";s:4:"11fa";s:33:"Configuration/FlexForms/Feeds.xml";s:4:"6985";s:44:"Configuration/FlexForms/PictureSlideShow.xml";s:4:"0848";s:35:"Configuration/FlexForms/Twitter.xml";s:4:"e3ef";s:25:"Configuration/TCA/tca.php";s:4:"25e1";s:46:"modfunc1/class.tx_mvcextjssamples_modfunc1.php";s:4:"5c5e";s:22:"modfunc1/locallang.xml";s:4:"d134";s:33:"Resources/Public/CSS/carousel.css";s:4:"1b8e";s:36:"Resources/Public/Icons/extanim32.gif";s:4:"3606";s:69:"Resources/Public/Icons/icon_tx_mvcextjssamples_domain_model_genre.gif";s:4:"dcb3";s:69:"Resources/Public/Icons/icon_tx_mvcextjssamples_domain_model_movie.gif";s:4:"a791";s:36:"Resources/Public/Icons/movie_add.png";s:4:"93d1";s:39:"Resources/Public/Icons/movie_delete.png";s:4:"e0d4";s:38:"Resources/Public/Icons/typo3anim32.gif";s:4:"4930";s:40:"Resources/Public/Icons/typo3anim32_2.gif";s:4:"fbaa";s:40:"Resources/Public/Icons/typo3anim32_3.gif";s:4:"86c6";s:40:"Resources/Public/Icons/carousel/next.png";s:4:"e689";s:46:"Resources/Public/Icons/carousel/play_pause.png";s:4:"5c75";s:40:"Resources/Public/Icons/carousel/prev.png";s:4:"e883";s:39:"Resources/Public/JavaScript/carousel.js";s:4:"b0a1";s:51:"Resources/Public/JavaScript/ux.TYPO3.FeUserAdmin.js";s:4:"0612";s:45:"Resources/Public/JavaScript/ux.TYPO3.Feeds.js";s:4:"75a3";s:47:"Resources/Public/JavaScript/ux.TYPO3.Twitter.js";s:4:"55dd";s:48:"Resources/Public/JavaScript/ux.grid.RowEditor.js";s:4:"fada";s:35:"Resources/Public/Images/movie-1.jpg";s:4:"059d";s:35:"Resources/Public/Images/movie-2.jpg";s:4:"7adb";s:35:"Resources/Public/Images/movie-3.jpg";s:4:"c52d";s:35:"Resources/Public/Images/movie-4.jpg";s:4:"2e08";s:35:"Resources/Public/Images/movie-5.jpg";s:4:"8f6d";s:35:"Resources/Public/Images/movie-6.jpg";s:4:"4ecd";s:35:"Resources/Public/Images/movie-7.jpg";s:4:"2f45";s:35:"Resources/Public/Images/movie-8.jpg";s:4:"c506";s:45:"Resources/Private/Language/OldStyleModule.xml";s:4:"7f6b";s:42:"Resources/Private/Language/extjs.Movie.xml";s:4:"e4c1";s:47:"Resources/Private/Language/extjs.SimpleForm.xml";s:4:"7617";s:45:"Resources/Private/Language/flexform.Feeds.xml";s:4:"4d73";s:56:"Resources/Private/Language/flexform.PictureSlideShow.xml";s:4:"a8fe";s:47:"Resources/Private/Language/flexform.Twitter.xml";s:4:"2de4";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"4dc6";s:50:"Resources/Private/Language/locallang_mod_blank.xml";s:4:"a16e";s:50:"Resources/Private/Templates/FeUserAdmin/index.html";s:4:"bdaa";s:55:"Resources/Private/Templates/PictureSlideShow/index.html";s:4:"b38b";s:44:"Resources/Private/Templates/Feeds/index.html";s:4:"0b88";s:49:"Resources/Private/Templates/SimpleForm/index.html";s:4:"06e0";s:46:"Resources/Private/Templates/Twitter/index.html";s:4:"c4b8";s:43:"Resources/Private/Templates/Genre/index.xml";s:4:"e7ca";s:53:"Resources/Private/Templates/OldStyleModule/index.html";s:4:"124c";s:44:"Resources/Private/Templates/Movie/index.html";s:4:"de35";s:44:"Resources/Private/Templates/Movie/movies.xml";s:4:"ef37";}',
	'suggests' => array(
	),
);

?>