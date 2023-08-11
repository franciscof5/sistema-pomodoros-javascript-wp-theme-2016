<?php
/**
 * Displays the footer section of the theme.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
		</div><!-- .container -->
	</div><!-- #content -->
			<?php
			/**
			 * magcast_before_footer hook
			 */
			do_action('magcast_before_footer');
			?>
			<footer id="colophon" class="site-footer clearfix" role="contentinfo">
				<?php
				/**
				 * magcast_footer hook
				 *
				 * HOOKED_FUNCTION_NAME PRIORITY
				 * magcast_open_siteinfo_div 20
				 * magcast_socialnetworks 25
				 * magcast_footer_info 30
				 * magcast_close_siteinfo_div 40
				 * magcast_backtotop_html 45
				 */
				do_action('magcast_footer');
				?>
			</footer><!-- #colophon -->
		</div><!-- #page -->
		<?php
		/**
		 * magcast_after hook
		 */
		do_action('magcast_after');
		wp_footer(); ?>
	</body>
</html>