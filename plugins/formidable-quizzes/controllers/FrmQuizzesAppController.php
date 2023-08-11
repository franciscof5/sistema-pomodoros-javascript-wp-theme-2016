<?php

class FrmQuizzesAppController {

	public static $min_version = '3.0';

	public static function min_version_notice() {
		$frm_version = is_callable( 'FrmAppHelper::plugin_version' ) ? FrmAppHelper::plugin_version() : 0;

		// check if Formidable meets minimum requirements
		if ( version_compare( $frm_version, self::$min_version, '>=' ) ) {
			return;
		}

		$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );
		echo '<tr class="plugin-update-tr active"><th colspan="' . (int) $wp_list_table->get_column_count() . '" class="check-column plugin-update colspanchange"><div class="update-message">' .
			esc_html_e( 'You are running an outdated version of Formidable. This plugin needs Formidable v2.0 + to work correctly.', 'frmquizzes' ) .
			'</div></td></tr>';
	}

	public static function include_updater() {
		if ( class_exists( 'FrmAddon' ) ) {
			include self::path() . '/models/FrmQuizzesUpdate.php';
			FrmQuizzesUpdate::load_hooks();
		}
	}

	public static function path() {
		return dirname( dirname( __FILE__ ) );
	}

	public static function plugin_url() {
		return plugins_url() . '/' . basename( self::path() );
	}

	public static function add_scripts() {
		if ( self::is_form_global_settings_page() ) {
			$url = self::plugin_url();
			wp_enqueue_style( 'frmquizzes-settings', $url . '/css/frmquizzes-settings.css', array(), 1 );
			wp_enqueue_script( 'frmquizzes-settings', $url . '/js/frmquizzes-settings.js', array( 'jquery' ), 1 );
		}
	}

	/**
	 * Check if the current page is the Global settings page
	 *
	 * @since 2.01
	 *
	 * @return bool
	 */
	private static function is_form_global_settings_page() {
		return ( is_callable( 'FrmAppHelper', 'is_admin_page' ) && FrmAppHelper::is_admin_page( 'formidable-settings' ) );
	}

	/**
	 * Add new field 'Quiz Score'
	 *
	 * @param array $fields
	 * @return $fields
	 */
	public static function add_field( $fields ) {
		$fields['quiz_score'] = array(
			'name' => __( 'Quiz Score', 'formidable-quizzes' ),
			'icon' => 'frm_icon_font frm_calculator_icon',
		);
		return $fields;
	}

	public static function add_field_class( $class, $field_type ) {
		if ( 'quiz_score' === $field_type ) {
			$class = 'FrmQuizzesField';
		}
		return $class;
	}

	/**
	 * Calculate Quiz Score on Form Submit & save it in hidden quiz score field
	 *
	 * @param int $entry_id
	 * @param int $form_id
	 * @return void
	 */
	public static function calculate_quiz_score( $entry_id, $form_id ) {
		$set = self::maybe_set_quiz_key( $entry_id, $form_id );
		if ( $set ) {
			return;
		}

		$scoring = new FrmQuizzes( compact( 'form_id', 'entry_id' ) );
		$quiz_id = $scoring->get_key_id();
		if ( ! empty( $quiz_id ) && $entry_id !== $quiz_id ) {
			$scoring->calculate_score();
		}
	}

	/**
	 * Save the checkbox within the form to set the quiz key
	 *
	 * @return boolean true if changed, false if not set
	 */
	private static function maybe_set_quiz_key( $entry_id, $form_id ) {
		$process_form = FrmAppHelper::get_post_param( 'frm_set_quiz_' . $form_id, '', 'sanitize_text_field' );
		if ( is_admin() && ! empty( $process_form ) ) {
			if ( wp_verify_nonce( $process_form, 'frm_set_quiz_nonce' ) && isset( $_POST['frm_set_quiz_key'] ) && sanitize_title( wp_unslash( $_POST['frm_set_quiz_key'] ) ) ) {
				$values = array(
					'id'       => $form_id,
					'quiz_key' => $entry_id,
				);
				FrmQuizzesFormSettings::save_setting( array(), $values );
				return true;
			}
		}

		return false;
	}
}
