<?php

class FrmQuizzesField extends FrmFieldType {

	/**
	 * @var string
	 * @since 1.0
	 */
	protected $type = 'quiz_score';

	/**
	 * @var bool
	 * @since 1.0
	 */
	protected $has_input = false;

	/**
	 * @var bool
	 * @since 1.0
	 */
	protected $has_html = false;

	protected function field_settings_for_type() {
		$settings = parent::field_settings_for_type();

		$settings['css'] = false;
		$settings['visibility'] = false;
		$settings['logic'] = false;

		if ( is_callable( 'FrmProFieldsHelper::fill_default_field_display' ) ) {
			FrmProFieldsHelper::fill_default_field_display( $settings );
		}

		return $settings;
	}

	public function prepare_field_html( $args ) {
		$html = '';
		$args = $this->fill_display_field_values( $args );

		$this->maybe_get_admin_field( $args, $html );

		$this->field['html_id'] = $args['html_id'];

		ob_start();
		FrmProFieldsHelper::insert_hidden_fields( $this->field, $args['field_name'], $this->field['value'] );
		$html .= ob_get_contents();
		ob_end_clean();

		return $html;
	}

	private function maybe_get_admin_field( $args, &$html ) {
		if ( ! FrmAppHelper::is_admin() || ! FrmProFieldsHelper::field_on_current_page( $this->field['id'] ) ) {
			return;
		}

		$form_id = $this->get_field_column( 'form_id' );
		$scoring = new FrmQuizzes( compact( 'form_id' ) );
		$entry_key = $scoring->get_key_id();

		$is_new  = ( isset( $args['form_action'] ) && 'create' === $args['form_action'] );
		$is_edit = ( ! isset( $args['action'] ) || 'create' !== $args['action'] ) && ! $is_new;

		$label = wp_kses_post( $this->field['name'] );

		if ( empty( $entry_key ) ) {
			$value = $this->set_key_checkbox();
		} elseif ( $is_edit ) {
			$value = wp_kses_post( $this->field['value'] );

			$this_entry = FrmAppHelper::simple_get( 'id', 'absint' );
			if ( $entry_key === $this_entry ) {
				$label = '<span class="frm_confirming">' .
					__( 'This is the quiz answer key', 'formidable-quizzes' ) .
					'</span>';
				$value = '';
			}
		} else {
			// don't output anything for a new submission
			return;
		}

		$html = $this->get_admin_field_html( $label, $value );
	}

	private function get_admin_field_html( $label, $value ) {
		$content = '<label class="frm_primary_label">' . $label . '</label> ';
		return '<div id="frm_field_' . esc_attr( $this->field['id'] ) . '_container" class="frm_form_field form-field frm_top_container">' .
			$content . $value .
			'</div>';
	}

	private function set_key_checkbox() {
		$form_id = $this->get_field_column( 'form_id' );
		return '<label>' .
			'<input type="checkbox" name="frm_set_quiz_key" value="1" />' .
			__( 'Set this entry as the quiz answer key', 'formidable-quizzes' ) .
			'</label>' .
			wp_nonce_field( 'frm_set_quiz_nonce', 'frm_set_quiz_' . $form_id );
	}

	protected function include_form_builder_file() {
		return FrmQuizzesAppController::path() . '/views/field/backend-builder.php';
	}

	protected function include_on_form_builder( $name, $field ) {
		$field_name = $this->html_name( $name );
		$html_id    = $this->html_id();
		$form_id    = $field['form_id'];

		$quiz_key = FrmQuizzesFormSettings::get_key_for_form( $form_id );
		$entries  = FrmQuizzesFormSettings::get_entries( $form_id );

		include( $this->include_form_builder_file() );
	}

	protected function html5_input_type() {
		return 'hidden';
	}

	protected function prepare_display_value( $value, $atts ) {
		$form_id = $this->get_field_column( 'form_id' );
		$scoring  = new FrmQuizzes( compact( 'form_id' ) );
		$field_count = $scoring->get_question_count();
		if ( empty( $field_count ) ) {
			return $value;
		}

		$percentage = ( $value / $field_count ) * 100;

		if ( ! isset( $atts['show'] ) ) {
			$atts['show'] = '';
		}

		switch ( $atts['show'] ) {
			case 'percent':
				$value = $percentage . '%';
				break;

			case 'grade':
				$value = $scoring->get_grade( $percentage );
				break;

			case 'count':
				// do nothing
				break;

			default:
				$value = $value . '/' . $field_count;
		}

		return $value;
	}
}
