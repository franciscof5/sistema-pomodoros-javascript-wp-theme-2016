<?php
/**
 * Displays the searchform of the theme.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="search-form clearfix">
		<label class="assistive-text"> <?php esc_html_e( 'Search', 'magcast' ); ?> </label>
		<input type="search" placeholder="<?php esc_attr_e( 'Search', 'magcast' ); ?>" class="s field" name="s">
		<input type="submit" value="<?php esc_attr_e('Search','magcast'); ?>" class="search-submit">
	</form><!-- .search-form -->
