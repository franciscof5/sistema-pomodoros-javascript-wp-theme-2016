<?php

// Get Navigation related information from theme options

$recent_posts_count = get_theme_mod( 'recent_posts_count' , '10' );
$text_navigation = get_theme_mod( 'text_navigation' , 'Navigation' );
$text_posts = get_theme_mod( 'text_posts' , '10 Most recent posts' );

?>

<div class="site-navigation">

<?php 

// Hide Navigation if turned on in theme options

if ( false === get_theme_mod( 'hide_navigation_overlay' ) ) { ?>
	
	<?php if ($text_navigation) { ?>
		<h4 class="navigation-title-text"><?php echo $text_navigation; ?></h4>
	<?php } ?>
	
	<nav class="sitenav-main" id="nav" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_id' => false, 'menu_class' => false ) ); ?>
	</nav>
	
<?php } ?>	
	
	<?php
	
	// Hide Recent Posts if turned on in theme options
	
	if ( false === get_theme_mod( 'hide_recent_posts_overlay' ) ) {
	
	?>
	
	<nav class="sitenav-posts">
		
		<?php if ($text_posts) { ?>
			<h4 class="navigation-posts-text"><?php echo $text_posts; ?></h4>
		<?php } ?>
		<ul>
		<?php
		
				
		$args = array( 'numberposts' => $recent_posts_count, 'post_status' => 'publish' );
		$recent_posts = wp_get_recent_posts( $args );
		foreach( $recent_posts as $recent ){
		echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="'.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
		}
		?>
		
		</ul>
	</nav>
	
	<?php } ?>
	
</div>
