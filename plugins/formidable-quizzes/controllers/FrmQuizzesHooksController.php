<?php

class FrmQuizzesHooksController {

	public static function load_hooks() {
		add_action( 'frm_after_create_entry', 'FrmQuizzesAppController::calculate_quiz_score', 20, 2 );
		add_action( 'frm_after_update_entry', 'FrmQuizzesAppController::calculate_quiz_score', 20, 2 );
		add_filter( 'frm_get_field_type_class', 'FrmQuizzesAppController::add_field_class', 10, 2 );
		self::load_admin_hooks();
	}

	public static function load_admin_hooks() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_init', 'FrmQuizzesAppController::include_updater' );
		add_action( 'admin_enqueue_scripts', 'FrmQuizzesAppController::add_scripts' );
		add_filter( 'frm_pro_available_fields', 'FrmQuizzesAppController::add_field' );
		add_action( 'after_plugin_row_formidable-quizzes/formidable-quizzes.php', 'FrmQuizzesAppController::min_version_notice' );
		add_action( 'frm_add_settings_section', 'FrmQuizzesSettingsController::add_settings_section' );

		add_action( 'frm_add_form_perm_options', 'FrmQuizzesFormSettings::add_setting', 30 );
		add_filter( 'frm_form_options_before_update', 'FrmQuizzesFormSettings::save_setting', 20, 2 );

	}
}
