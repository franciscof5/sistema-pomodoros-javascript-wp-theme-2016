<?php
class FrmQuizzes {

	protected $form_id = 0;

	protected $entry_id = 0;

	public function __construct( $atts = array() ) {
		if ( isset( $atts['form_id'] ) ) {
			$this->form_id  = $atts['form_id'];
		}

		if ( isset( $atts['entry_id'] ) ) {
			$this->entry_id = $atts['entry_id'];
		}
	}

	public function get_key() {
		$quiz_key = $this->get_key_id();
		if ( empty( $quiz_key ) ) {
			return false;
		}

		$saved_answers = FrmEntry::getOne( $quiz_key, true );
		if ( empty( $saved_answers ) ) {
			return false;
		} else {
			return $saved_answers;
		}
	}

	/**
	 * Get quiz key( entry id ) which stores correct values
	 *
	 * @return int
	 */
	public function get_key_id() {
		$quiz_keys = FrmQuizzesFormSettings::get_setting();

		// check if form has quiz key saved
		if ( ! isset( $quiz_keys[ $this->form_id ] ) ) {
			return 0;
		}

		return (int) $quiz_keys[ $this->form_id ];
	}

	public function get_question_count() {
		$quiz_key = $this->get_key();
		if ( ! empty( $quiz_key ) ) {
			$quiz_field = $this->get_quiz_field();
			if ( $quiz_field && isset( $quiz_key->metas[ $quiz_field->id ] ) ) {
				// don't count the quiz field toward the score
				unset( $quiz_key->metas[ $quiz_field->id ] );
			}
			return count( $quiz_key->metas );
		} else {
			return 0;
		}
	}

	private function get_quiz_field() {
		return FrmField::get_all_types_in_form( $this->form_id, 'quiz_score', 1 );
	}

	public function calculate_score() {
		$saved_answers = $this->get_key();
		if ( empty( $saved_answers ) || empty( $this->entry_id ) ) {
			$this->save_score( 'no key' );
			return;
		}

		$entry = FrmEntry::getOne( $this->entry_id, true );
		$quiz_field = $this->get_quiz_field();

		// loop through each field in entry
		$score = 0;
		foreach ( $entry->metas as $field_id => $value ) {
			if ( $field_id === $quiz_field->id ) {
				// don't grade the score field if it exists
				continue;
			}

			// check if field value matches value in saved answers entry
			if ( isset( $saved_answers->metas[ $field_id ] ) && $this->is_correct( $value, $saved_answers->metas[ $field_id ] ) ) {
				$score++;
			}
		}
		$this->save_score( $score );
	}

	private function is_correct( $answer, $key ) {
		$this->flatten_response( $answer );
		$this->flatten_response( $key );

		return ( $answer == $key );
	}

	/**
	 * Get the grade set in grading scale in global settings for percentage
	 *
	 * @param int $percentage
	 * @return string
	 */
	public function get_grade( $percentage ) {
		if ( '' === $percentage ) {
			return '';
		}

		$quiz_settings = new FrmQuizzesSettings();
		$percentage = round( $percentage, 1 );

		// loop through each set grading scale
		foreach ( $quiz_settings->settings->grading_scale as $grade_scale ) {
			// check if calculated percentage lies inbetween garding scale start & end percentage
			if ( $percentage >= $grade_scale['start'] && $percentage <= $grade_scale['end'] ) {
				return $grade_scale['grade'];
			}
		}
		return '';
	}

	/**
	 * Don't require case sentivitity
	 */
	private function flatten_response( &$response ) {
		if ( is_array( $response ) ) {
			$response = implode( ', ', $response );
		}
		$response = trim( strtolower( $response ) );
	}

	/**
	 * Save Quiz score
	 *
	 * @param int $score
	 * @return void
	 */
	private function save_score( $score ) {
		$quiz_field = $this->get_quiz_field();
		if ( empty( $quiz_field ) ) {
			return;
		}

		// save the total score value in the quiz_score field
		$u = FrmEntryMeta::update_entry_meta( $this->entry_id, $quiz_field->id, null, $score );
		if ( ! $u ) {
			// add the row if it wasn't there to update
			FrmEntryMeta::add_entry_meta( $this->entry_id, $quiz_field->id, null, $score );
		}
	}
}
