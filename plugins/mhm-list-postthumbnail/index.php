<?php
/*
Plugin Name: Post thumbnail in Post admin list
Plugin URI: https://wordpress.org/plugins/mhm-list-postthumbnail/
Description: Adds a new column to the WordPress admin post list view, containing a thumbnail-sized preview of the post thumbnail (where available).
Version: 1.3.0
Requires at least: 4.0
Requires PHP: 5.6
Author: Say Hello GmbH
Author URI: https://sayhello.ch/
Licence: GPL3
Text Domain: mhm-list-postthumbnail
Domain Path: /languages
*/

class MHMListPostThumbnail
{

	public $version   = '1.3.0';
	public $wpversion = '4.0';
	private $excluded_posttypes = [];

	public function __construct()
	{
		register_activation_hook(__FILE__, array($this, 'checkVersion'));
		add_action('admin_init', array($this, 'checkVersion'));
		add_action('plugins_loaded', array($this, 'loadTextdomain'));
		add_filter('manage_posts_columns', array($this, 'adminColumnHeader'), 20);
		add_action('manage_posts_custom_column', array($this, 'adminColumnContent'), 5, 2);
	}

	public function checkVersion()
	{
		// Check that this plugin is compatible with the current version of WordPress
		if (!$this->compatibleVersion()) {
			if (is_plugin_active(plugin_basename(__FILE__))) {
				deactivate_plugins(plugin_basename(__FILE__));
				add_action('admin_notices', array($this, 'disabledNotice'));
				if (isset($_GET['activate'])) {
					unset($_GET['activate']);
				}
			}
		}
	}

	public function disabledNotice()
	{
		echo '<div class="notice notice-error is-dismissible">
            <p>' . sprintf(
			_x('The plugin “%1$s” requires WordPress %2$s or higher!', 'Compatibility warning message on activation', 'mhm-list-postthumbnail'),
			_x('Post thumbnail in Post admin list', 'Plugin name in compatibility warning message', 'mhm-list-postthumbnail'),
			$this->wpversion
		) . '</p>
        </div>';
	}

	private function compatibleVersion()
	{
		if (version_compare($GLOBALS['wp_version'], $this->wpversion, '<')) {
			return false;
		}

		return true;
	}

	public function loadTextdomain()
	{
		load_plugin_textdomain('mhm-list-postthumbnail', false, plugin_basename(dirname(__FILE__)) . '/languages');
	}

	public function adminColumnHeader($cols)
	{
		if (!in_array($this->getCurrentAdminPostType(), $this->getExcludedPostTypes())) {
			// Add column and header
			$cols['mhm-list-postthumbnail'] = _x('Thumbnail', 'The column header', 'mhm-list-postthumbnail');
		}

		return $cols;
	}

	public function adminColumnContent($column_name, $post_id)
	{
		//  show content for each row
		switch ($column_name) {
			case 'mhm-list-postthumbnail':
				if (!in_array($this->getCurrentAdminPostType(), $this->getExcludedPostTypes())) {
					if (has_post_thumbnail($post_id)) {
						echo get_the_post_thumbnail($post_id, 'thumbnail');
					} else {
						echo _x('None', 'Text or HTML which is displayed in the list view if there is no thumbnail available', 'mhm-list-postthumbnail');
					}
				}
				break;
		}
	}

	private function getCurrentAdminPostType()
	{

		global $post, $typenow, $current_screen;

		if ($post && $post->post_type) {
			return $post->post_type;
		} elseif ($typenow) {
			return $typenow;
		} elseif ($current_screen && $current_screen->post_type) {
			return $current_screen->post_type;
		} elseif (isset($_REQUEST['post_type'])) {
			return sanitize_key($_REQUEST['post_type']);
		}

		return null;
	}

	private function getExcludedPostTypes()
	{
		if (empty($this->excluded_posttypes)) {
			$this->excluded_posttypes = (array) apply_filters('mhm-list-postthumbnail/exclude_posttype', $this->excluded_posttypes);
		}
		return $this->excluded_posttypes;
	}
}

new MHMListPostThumbnail();
