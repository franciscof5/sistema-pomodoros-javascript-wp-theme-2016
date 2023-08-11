
<div class="sidebar-hold">
<?php
	// If Single / Archive etc.
?>

<?php

if ( !is_page() ) {
	
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Widget Area')) { ?>
	
<?php 
	} 
}

?>

<?php

if ( is_page() ) {
	
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Widget Area (Page)')) { ?>
	
<?php 
	} 
}

?>
</div>
