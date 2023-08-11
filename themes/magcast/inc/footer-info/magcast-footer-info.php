<?php
/**
 * Contains all the current date, year of the theme.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
<?php
	/**
	 * To display the current year.
	 *
	 * @uses date() Gets the current year.
	 * @return string
	 */
	function magcast_the_year() {
	   return date_i18n( 'Y' );
	}
	/**
	 * To display a link back to the site.
	 *
	 * @uses get_bloginfo() Gets the site link
	 * @return string
	 */
	function magcast_site_link() {
	   return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
	}
	/**
	 * To display a link to WordPress.org.
	 *
	 * @return string
	 */
	function magcast_wp_link() {
	   return sprintf( __('Proudly Powered by: %s', 'magcast'), '<a href="' . esc_url( 'http://wordpress.org/', 'magcast' ). '" target="_blank" title="' . esc_attr__( 'WordPress', 'magcast' ). '"><span>' . __( 'WordPress', 'magcast' ) . '</span></a>');
	}
	/**
	 * To display a link to magcast.com.
	 *
	 * @return string
	 */
	function magcast_themehorse_link() {
	   return sprintf( __('Theme by: %s', 'magcast'), '<a href="'.esc_url( 'http://themehorse.com','magcast' ).'" target="_blank" title="' . esc_attr__( 'Theme Horse', 'magcast' ).'" ><span>'. __( 'Theme Horse', 'magcast' ) .'</span></a>');
	}
?>
