<?php
class FrmQuizzesFormSettings {

	protected static $setting_name = 'frm_quiz_keys';

	/**
	 * Add Form Setting to set Quiz Key
	 *
	 * @param array $values
	 * @return void
	 */
	public static function add_setting( $values ) {
		$form_id = $values['id'];
		$entries = self::get_entries( $form_id );
		$quiz_key = self::get_key_for_form( $form_id );
		include_once FrmQuizzesAppController::path() . '/views/form-settings/settings.php';
	}

	public static function get_entries( $form_id ) {
		$where = array(
			'form_id' => $form_id,
		);
		return FrmEntry::getAll( $where, '', 20 );
	}

	public static function add_entry_message( $form_id ) {
		/* translators: %1$s: Start link HTML, %2$s: end link HTML */
		printf( esc_html__( '%1$sAdd an entry%2$s to this form to be used as the quiz key for scoring.', 'formidable-quizzes' ), '<a href="' . esc_url( admin_url( 'admin.php?page=formidable-entries&frm_action=new&form=' . $form_id ) ) . '">', '</a>' );
	}

	/**
	 * Save Quiz Key( Entry id )
	 *
	 * @param array $options
	 * @param array $values
	 * @return array $options
	 */
	public static function save_setting( $options, $values ) {
		$quiz_keys = self::get_setting();
		$form_id = isset( $values['id'] ) ? $values['id'] : 0;
		if ( ! empty( $values['quiz_key'] ) ) {
			$quiz_keys[ $form_id ] = $values['quiz_key'];
			self::update( $quiz_keys );
		} elseif ( isset( $quiz_keys[ $form_id ] ) ) {
			unset( $quiz_keys[ $form_id ] );
			self::update( $quiz_keys );
		}
		return $options;
	}

	private static function update( $keys ) {
		update_option( self::$setting_name, $keys );
	}

	public static function get_key_for_form( $form_id ) {
		$quiz_keys = self::get_setting();
		$has_key = isset( $quiz_keys[ $form_id ] ) && ! empty( $quiz_keys[ $form_id ] );
		return $has_key ? $quiz_keys[ $form_id ] : '';
	}

	public static function get_setting() {
		$quiz_keys = get_option( self::$setting_name );
		if ( empty( $quiz_keys ) ) {
			$quiz_keys = array();
		}
		return $quiz_keys;
	}
}
