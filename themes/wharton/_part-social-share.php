<?php 

	$twitter_username = "";
	$twitter_username = get_theme_mod( 'twitter_username');
	
	$twitterVia = "";
	
	if ( $twitter_username ) {

		$twitterVia = '&amp;via=' . $twitter_username; 
	
	}

    $image_single = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default' ); 

?>

<?php if( is_single() ) { 

if( false === get_theme_mod( 'hide_social_share' ) ) {

?>

<div class="share">
		<a target="blank" title="<?php echo urlencode( get_the_title() ); ?>" href="https://twitter.com/share?text=<?php echo urlencode( get_the_title() ); ?>%20-%20&amp;url=<?php the_permalink(); ?><?php echo $twitterVia; ?>" onclick="window.open('https://twitter.com/share?text=<?php echo urlencode( get_the_title() ); ?>%20-%20&amp;url=<?php the_permalink(); ?><?php echo $twitterVia; ?>','twitter','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" class="social twitter <?php if( get_theme_mod( 'use_black_social_share', '0' ) == '0' ) echo " white"; ?>">
		 <?php _e('Twitter' , 'meanthemes'); ?>
		 </a> 
		 <a target="blank" title="<?php echo urlencode( get_the_title() ); ?>" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" onclick="window.open('http://www.facebook.com/share.php?u=<?php the_permalink(); ?>','facebook','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" class="social facebook <?php if( get_theme_mod( 'use_black_social_share', '0' ) == '0' ) echo " white"; ?>">
		 <?php _e('Facebook' , 'meanthemes'); ?>
		 </a> 
		 <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo $image_single[0]; ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>" target="_blank" class="social pinterest <?php if( get_theme_mod( 'use_black_social_share', '0' ) == '0' ) echo " white"; ?>">
		  <?php _e('Pinterest' , 'meanthemes'); ?>
		  </a> 
		  <a onclick="window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>','gplusshare','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="social googleplus <?php if( get_theme_mod( 'use_black_social_share', '0' ) == '0' ) echo " white"; ?>">
		   <?php _e('Google+' , 'meanthemes'); ?>
		   </a> 
</div>

<?php 

	} // social share if

} // hide social if

 ?>