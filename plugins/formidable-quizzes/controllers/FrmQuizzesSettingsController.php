<?php

class FrmQuizzesSettingsController {

	public static function add_settings_section( $sections ) {
		$sections['quizzes'] = array(
			'class' => 'FrmQuizzesSettingsController',
			'function' => 'route',
		);
		return $sections;
	}

	public static function display_form() {
		$settings = new FrmQuizzesSettings();
		$quiz_settings = $settings->settings;

		require_once FrmQuizzesAppController::path() . '/views/settings/form.php';
	}

	public static function process_form() {
		$settings = new FrmQuizzesSettings();
		$process_form = FrmAppHelper::get_post_param( 'process_form', '', 'sanitize_text_field' );

		if ( wp_verify_nonce( $process_form, 'process_form_nonce' ) ) {
			$settings->update( $_POST );
			$settings->store();
			$message = __( 'Settings Saved', 'formidable' );
		}

		$quiz_settings = $settings->settings;

		require_once FrmQuizzesAppController::path() . '/views/settings/form.php';
	}

	public static function route() {
		$action = FrmAppHelper::get_param( 'action' );
		if ( 'process-form' == $action ) {
			return self::process_form();
		} else {
			return self::display_form();
		}
	}

}
