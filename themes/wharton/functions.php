<?php

/* #######################################################################

	Wharton by MeanThemes

	Load MeanThemes Framework and Functionality files

####################################################################### */

	$basedir = get_template_directory() . '/framework/';
	
	// Load main theme options
	require_once($basedir .'theme-options.php');
	
	// load twitter api hook
	require_once($basedir .'styles-and-scripts.php');
	
	// load widgets
	require_once($basedir .'widgets.php');
	
	// load custom meta
	require_once($basedir .'custom-meta.php');
	
	// load standard functions
	require_once($basedir .'default.php');
	
	// load shortcodes
	require_once($basedir .'shortcodes.php');

?>