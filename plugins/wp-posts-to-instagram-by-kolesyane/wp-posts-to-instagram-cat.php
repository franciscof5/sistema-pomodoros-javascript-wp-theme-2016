<?php
/*
Plugin Name: WP Posts to Instagram by Kolesyane
Description: Publish defined WP posts to your Instargam account.
Plugin URI: https://wordpress.org/plugins/wp-posts-to-instagram-by-kolesyane
Version: 1.0.0
Author: kolesyane
Author URI: http://koshkina.pp.ua
Text Domain: wpic
Domain Path: /languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

require_once ('src/wpic-instagram.php');

add_action('admin_menu', 'wpic_menu');

function wpic_menu() {
	add_menu_page('WP Posts to Instagram by cat Plugin Settings', 'WP Posts to Instagram Settings', 'administrator', 'wpic-plugin-settings', 'wpic_settings_page', 'dashicons-admin-generic');
}

add_action( 'admin_init', 'wpic_settings' );

function wpic_settings() {
	register_setting( 'wpic-plugin-settings-group', 'wpic_type_settings' );
	load_plugin_textdomain( 'wpic', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function wpic_on_post_publish($new_status, $old_status, $post) {
	global $wpdb;

    if ($new_status == $old_status || $new_status != 'publish') {
        return false;
    }

	$type_settings = get_option( 'wpic_type_settings' );

	if (!isset($_POST['wpic_exclude_instagram_publish']) && $type_settings['wpic_type_settings'][$post->post_type]) {

		$text = $post->post_content;
		$feat_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

		wpic_send_to_instagram($text, $feat_image_url);

		if (get_option('wpic_success')) {

			$table_name = $wpdb->prefix . "wpic_posts";
			$query =  $wpdb->prepare("SELECT * FROM $table_name WHERE `post_id` = %d", array($post->ID));
			$result = $wpdb->query($query);

			if (!$result) {
				$prepared = $wpdb->prepare(
					"INSERT INTO $table_name (`post_id`) VALUES ( %d )",
					array(
                        $post->ID,
					)
				);
				$result = $wpdb->query($prepared);
			}
		}
	}
}

function wpic_send_to_instagram($text, $feat_image_url){
	$type_settings = get_option( 'wpic_type_settings' );

	$login = $type_settings['wpic_type_settings']['account_login'];
	$pass = $type_settings['wpic_type_settings']['account_password'];
	$instagram = new Wpic($login, $pass, $text, $feat_image_url);

	if (!$instagram->prepareSquareImage()) {
		add_option('wpic_error', __('Error while processing the image to Instagram','wpic'));
		return false;
	}

	$instagram->processPost();
}

add_action('admin_head', 'wpic_fonts');

function wpic_fonts() {
	echo '<style>
		td.kolesyane-donate{
			vertical-align: top;
		}
		.kolesyane-donate .wrap{
			font-size: 16px;
			background: #ffffff;
			margin-bottom: 10px;
			padding: 5px;
			border-left: 4px solid #7ad03a;
		}
		.kolesyane-donate .wrap div{
			margin-bottom: 5px;
		}
    .notice, div.error.custom, div.updated.custom{
			margin: 0px;
    }
    .insta_icon{
    	background-image: url(' . plugins_url('', __FILE__ ) . '/insta.png);
		  background-position: 10px 0px;
		  padding-left: 37px;
		  background-size: 7%;
		  background-repeat: no-repeat;
		  height: 25px;
		  display: block;
    }
  </style>';
}

add_action(  'transition_post_status',  'wpic_on_post_publish', 10, 3 );

function wpic_error_notice() {
	//On post creation show instagram messages

	if (isset($_GET['message']) && $_GET['message'] == 6) {
		$messageError = get_option('wpic_error');
		$messageSuccess = get_option('wpic_success');
		$class = 'updated';
		$message = '';
		if ($messageError) {
			$class = 'error';
			$message = $messageError;
			delete_option('wpic_error');
		}
		elseif($messageSuccess) {
			$message = $messageSuccess;
			delete_option('wpic_success');
		}

		if ($message) {
			?>
				<div class="<?php echo $class; ?> notice custom">
					<p><?php echo $message; ?></p>
				</div>
			<?php
		}
	}
}
add_action( 'admin_notices', 'wpic_error_notice' );

function wpic_settings_page() {

	$types = get_post_types();
	$types_names = array();

	foreach( $types as $type => $slug )
	{
		$typeobj = get_post_type_object( $type );
		$types_names[$type] = $typeobj->label;
	}

	$settings = array();
	if (isset($_POST['wpic_type_settings']) && wp_verify_nonce( $_POST['wpic_type_settings'], plugin_basename( __FILE__ ) ) ) {

		foreach( $types as $type => $slug ) {
			$settings['wpic_type_settings'][$type] = false;

			if ( isset( $_REQUEST[ 'wpic_type_settings_' . $type ])) {
				$settings[ 'wpic_type_settings' ][ $type ] = true;
			}
		}


		if( isset( $_REQUEST[ 'wpic_type_settings_account_login'] ) )          $settings[ 'wpic_type_settings' ][ 'account_login' ] =  sanitize_text_field($_REQUEST[ 'wpic_type_settings_account_login' ]);
		if( isset( $_REQUEST[ 'wpic_type_settings_account_password'] ) )          $settings[ 'wpic_type_settings' ][ 'account_password' ] =  sanitize_text_field($_REQUEST[ 'wpic_type_settings_account_password' ]);

		update_option( 'wpic_type_settings', $settings );

		echo '<div class="updated"><p><strong>'.__("Settings Updated",'wpic').'</strong></div>';
	}
?>
	<div class="wrap">
		<h2><?php _e('Instagram poster settings','wpic') ?> </h2>
<table>
	<tr>
		<td><form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
				<?php settings_fields( 'wpic-plugin-settings-group' ); ?>
				<?php do_settings_sections( 'wpic-plugin-settings-group' ); ?>

				<?php
				$type_settings = get_option( 'wpic_type_settings' );
				?>
				<table class="form-table">

					<tr>
						<td colspan="2">
							<h3><?php _e( 'Instagram account settings','wpic' ); ?></h3>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Instagram Account Login','wpic') ?> </th>
						<td><input type="text" name="wpic_type_settings_account_login" value="<?php echo esc_attr( $type_settings['wpic_type_settings']['account_login'] ); ?>" /></td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Instagram Account Password','wpic') ?> </th>
						<td><input type="password" name="wpic_type_settings_account_password" value="<?php echo esc_attr( $type_settings['wpic_type_settings']['account_password'] ); ?>" /></td>
					</tr>

					<tr>
						<td colspan="2">
							<h3><?php _e( 'Select the type of content, the publication of which will be sent to instagram', 'wpic'); ?></h3>
						</td>
					</tr>

					<?php foreach( $types as $type => $type_slug ): ?>
						<tr valign="top">
							<th><?php echo $types_names[$type]; ?></th>
							<td>
								<input type="checkbox" name="wpic_type_settings_<?php echo $type; ?>" <?php if( isset( $type_settings['wpic_type_settings'][ $type ] ) && $type_settings['wpic_type_settings'][ $type ] ) echo 'CHECKED'; ?> />
							</td>
						</tr>
					<?php endforeach; ?>

				</table>
				<?php wp_nonce_field( plugin_basename( __FILE__ ), 'wpic_type_settings' ); ?>
				<?php submit_button(); ?>

			</form></td>
		<td class="kolesyane-donate"><!--		1$  -->
				<div class="wrap">
					<div>
						Please, buy me a coffee :)<br/>  Just <strong>1$</strong> donation.<br/>
					</div>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="8BDGGP2KDCGWE">
						<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>

				<!--		3$  -->
				<div class="wrap">
					<div>
						Please, If you add a muffin for my coffee, it will be great :)<br/> Just <strong>3$</strong> donation.<br/>
					</div>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="PR3ZP5PL6QDLQ">
						<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>

				<!--		5$  -->
				<div class="wrap">
					<div>
						I believe, you can do more for this world, buy me a lunch please :)<br/>  Just <strong>5$</strong> donation.<br/>
					</div>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="HJXT83UR6GSUN">
						<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>

				<!--		Any $  -->
				<div class="wrap">
					<div>
						Or listen to your heart and donate as much as you want ;)
					</div>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="DNPD5U5BESWUG">
						<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>

			</td>
	</tr>
</table>




	</div>

<?php
}

global $jal_db_version;
$jal_db_version = "1.0";

function wpic_install () {
	global $wpdb, $wp_to_instgram_cat_install_db_version;

	$table_name = $wpdb->prefix . "wpic_posts";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

		$sql = "CREATE TABLE " . $table_name . " (
		  id int(11) NOT NULL AUTO_INCREMENT,
		  post_id int(11) NOT NULL,
		  UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		add_option("jal_db_version", $wp_to_instgram_cat_install_db_version);

	}
}

register_activation_hook(__FILE__,'wpic_install');

function wpic_uninstall () {
	global $wpdb;

	$table_name = $wpdb->prefix . "wpic_posts";
	if($wpdb->get_var("show tables like '$table_name'") == $table_name) {

		$sql = "DROP TABLE  " . $table_name . ";";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		delete_option("wpic_type_settings");

	}
}

register_uninstall_hook(__FILE__,'wpic_uninstall');

add_action( 'post_submitbox_misc_actions', 'wpic_exclude_instagram_publish' );
function wpic_exclude_instagram_publish()
{
	global  $wpdb, $post;

	$table_name = $wpdb->prefix . "wpic_posts";
	$query =  $wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d", array($post->ID));
	$result = $wpdb->get_row($query);

	if ($result) {
		echo '<strong class="insta_icon">' . __('Already posted to Instagram', 'wpic') . '</strong>';
	}
	else {
		echo '<div class="misc-pub-section misc-pub-section-last">
	         <span id="timestamp" class="' . $post->ID . '">'
			. '<label>'
			. ' <input type="checkbox" value="1" name="wpic_exclude_instagram_publish" />' . __('Not publish to Instagram', 'wpic') . '</label>'
			.'</span></div>';
	}
}

/* Do something with the data entered */
add_action( 'save_post', 'wpic_save_postdata' );

/* When the post is saved, saves our custom data */
function wpic_save_postdata( $post_id )
{
	// verify if this is an auto save routine.
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( isset($_POST['wpic_exclude_instagram_publish']) && $_POST['wpic_exclude_instagram_publish'] != "" ){
		update_post_meta( $post_id, 'wpic_exclude_instagram_publish', intval($_POST['wpic_exclude_instagram_publish']) );
	}
}