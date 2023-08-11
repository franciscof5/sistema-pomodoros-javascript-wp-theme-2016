<?php
/**
 * Displays the 404 error page of the theme.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
<?php get_header(); ?>
	<div id="main">
		<header class="entry-header">
			<h1 class="entry-title">
				<?php esc_html_e('Error 404-Page NOT Found', 'magcast'); ?>
			</h1>
		</header>
		<div class="entry-content clearfix" >
			<p>
				<?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'magcast'); ?>
			</p>
			<h3>
				<?php esc_html_e('This might be because:', 'magcast'); ?>
			</h3>
			<p>
				<?php esc_html_e('You have typed the web address incorrectly, or the page you were looking for may have been moved, updated or deleted.', 'magcast'); ?>
			</p>
			<h3>
				<?php esc_html_e('Please try the following instead:', 'magcast'); ?>
			</h3>
			<p>
				<?php esc_html_e('Check for a mis-typed URL error, then press the refresh button on your browser.', 'magcast'); ?>
			</p>
		</div> <!-- .entry-content --> 
	</div><!-- #main -->
<?php get_footer(); ?>