<?php
/**
 * Displays the footer sidebar of the theme.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
<?php
	if( is_active_sidebar( 'magcast_footer_sidebar' ) || is_active_sidebar( 'magcast_footer_column2' ) || is_active_sidebar( 'magcast_footer_column3' ) ) {
		?>
		<div class="widget-wrap">
			<div class="container">
				<div class="widget-area column-third clearfix">
					<div class="column-wrap">
						<?php
							// Calling the footer column 1 sidebar
							if ( is_active_sidebar( 'magcast_footer_sidebar' ) ) :
								dynamic_sidebar( 'magcast_footer_sidebar' );
							endif;
						?>
					</div><!-- .column-wrap -->
					<div class="column-wrap">
						<?php
							// Calling the footer column 2 sidebar
							if ( is_active_sidebar( 'magcast_footer_column2' ) ) :
								dynamic_sidebar( 'magcast_footer_column2' );
							endif;
						?>
					</div><!-- .column-wrap -->
					<div class="column-wrap">
						<?php
							// Calling the footer column 3 sidebar
							if ( is_active_sidebar( 'magcast_footer_column3' ) ) :
								dynamic_sidebar( 'magcast_footer_column3' );
							endif;
						?>
					</div><!-- .column-wrap -->
				</div><!-- .widget-area --> 
			</div><!-- .container --> 
		</div><!-- .widget-wrap -->
<?php
	}
?>