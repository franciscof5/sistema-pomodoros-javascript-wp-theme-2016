<?php






##MORE LOAD FUNCTIONS
$wpmu_plugin_dir2 = opendir(WPMU_PLUGIN_DIR."/../mu-plugins-all-domains");


// Lists all the entries in this directory
while (false !== ($entry = readdir($wpmu_plugin_dir2))) {
	//echo $entry;
	$path = WPMU_PLUGIN_DIR."/../mu-plugins-all-domains" . '/' . $entry;

	// Is the current entry a subdirectory?
	if ($entry != '.' && $entry != '..' && is_dir($path)) {
		// Includes the corresponding plugin
				$file = $path . '/functions.php';
		
		if(!is_file($file))
			$file = $path . '/' . $entry . '.php';
		
		if(!is_file($file)) {
			
			$file = $path . '/' . str_replace("-", "_", $entry) . '.php';
		}
		if(!is_file($file))
			$file = $path . '/init.php';
		
		if(!is_file($file)) {
			#foreach (glob("*.php") as $arquivo) {
		    	#echo "tamanho de $arquivo " . filesize($arquivo) . "\n";
		    	
		    	#$file = $path . '/'.$arquivo.'php';
				#/var/www/composer/vendor/wp/wp-content/mu-plugins-www.itapemapas.com.br/../mu-plugins-all-domains/buddypress/bp-loader.php
				$file = glob($path ."/*.php")[0];
			#}
		}
		#SINGLE PHP FILE IN FOLDER

		#$file = $path . '/functions.php';
		#else die;
		#$foi = require();
		#if(!$foi)
		#if(gethostname()=="note-samsung" && $entry!="google-analytics-dashboard-for-wp") {
			if($file && (gethostname()!="note-samsung" || $entry!="w3-total-cache") )
			require($file);	
		#}
	}
}
// Closes the directory
closedir($wpmu_plugin_dir2);

// Opens the must-use plugins directory
//define('WPMU_PLUGIN_DIR', WPMU_PLUGIN_DIR."-".DOMAIN);
$wpmu_plugin_dir = opendir(WPMU_PLUGIN_DIR);

//echo WPMU_PLUGIN_DIR;die;

// Lists all the entries in this directory
while (false !== ($entry = readdir($wpmu_plugin_dir))) {
	//echo $entry;
	$path = WPMU_PLUGIN_DIR . '/' . $entry;

	// Is the current entry a subdirectory?
	if ($entry != '.' && $entry != '..' && is_dir($path)) {
		// Includes the corresponding plugin
				$file = $path . '/functions.php';
		
		if(!is_file($file))
			$file = $path . '/' . $entry . '.php';
		
		if(!is_file($file)) {
			
			$file = $path . '/' . str_replace("-", "_", $entry) . '.php';
		}
		if(!is_file($file))
			$file = $path . '/init.php';
		
		if(!is_file($file)) {
			#foreach (glob("*.php") as $arquivo) {
		    	#echo "tamanho de $arquivo " . filesize($arquivo) . "\n";
		    	
		    	#$file = $path . '/'.$arquivo.'php';
				#/var/www/composer/vendor/wp/wp-content/mu-plugins-www.itapemapas.com.br/../mu-plugins-all-domains/buddypress/bp-loader.php
				if(isset(glob($path ."/*.php")[0]))
				$file = glob($path ."/*.php")[0];

			#}
		}
		#SINGLE PHP FILE IN FOLDER

		#$file = $path . '/functions.php';
		#else die;
		#$foi = require();
		#if(!$foi)
		#var_dump($entry);
		if($file && (gethostname()!="note-samsung" || $entry!="w3-total-cache") )
		require($file);
	}
}
// Closes the directory
closedir($wpmu_plugin_dir);
?>