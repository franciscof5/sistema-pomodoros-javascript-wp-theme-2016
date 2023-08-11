<?php
/**
 * Implements a custom header for magcast.
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
add_action( 'after_setup_theme', 'magcast_custom_header_setup' );
/**
 * Sets up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 *
 * @since Magcast 1.0
 */
function magcast_custom_header_setup() {
	$args = array(
		// Text color and image (empty to use none).
		'default-text-color'     => '333333',
		'default-image'          => '',
		// Set height and width, with a maximum value for the width.
		'height'                 => apply_filters( 'magcast_header_image_height', 300 ),
		'width'                  => apply_filters( 'magcast_header_image_width', 1170 ),
		'max-width'              => 2000,		// for backend custom header
		// Support flexible height and width.
		'flex-height'            => true,
		'flex-width'             => true,
		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'magcast_header_style',
	);
	add_theme_support( 'custom-header', $args );
}
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Magcast 1.0
 */
function magcast_admin_header_style() { ?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg img {
			max-width: <?php echo get_theme_support( 'custom-header', 'max-width' );
		?>px;
		}
	</style>
	<?php
}

if ( ! function_exists( 'magcast_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own magcast_header_style() function to override in a child theme.
 *
 * @see magcast_custom_header_and_background().
 */
function magcast_header_style() {
	$text_color = get_header_textcolor();
	// If no custom options for text are set, let's bail
	if ( $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;
	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="magcast-header-css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		#site-title, #site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text, use that.
		else :
	?>
		#site-title a {
			color: #<?php echo $text_color; ?>;
		}
	<?php endif; ?>
	</style>
<?php }
endif; // magcast_header_style
/**
 * Outputs markup to be displayed on the Appearance > Header admin panel.
 * This callback overrides the default markup displayed there.
 *
 * @since Magcast 1.0
 */
function magcast_admin_header_image() { ?>
	<div id="headimg">
		<?php $magcast_header_image = get_header_image();
			if ( ! empty( $magcast_header_image ) ) : ?>
				<img src="<?php echo esc_url( $magcast_header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
	<?php endif; ?>
	</div>
<?php 
} ?>
