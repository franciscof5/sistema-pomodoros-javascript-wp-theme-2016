<input type="hidden" id="<?php echo esc_attr( $html_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" value="<?php echo esc_attr( $field['default_value'] ); ?>" />

<?php if ( empty( $entries ) || empty( $quiz_key ) ) { ?>
	<ol class="howto frm_clear">
		<?php if ( empty( $entries ) ) { ?>
			<li><?php FrmQuizzesFormSettings::add_entry_message( $form_id ); ?></li>
		<?php } ?>
		<?php if ( empty( $entries ) || empty( $quiz_key ) ) { ?>
			<li><?php esc_html_e( 'Select an entry for the quiz key in the form settings.', 'formidable-quizzes' ); ?></li>
		<?php } ?>
		<li><?php esc_html_e( 'Publish the quiz and submissions will be scored automatically.', 'formidable-quizzes' ); ?></li>
	</ol>
<?php } ?>

<p class="howto frm_clear">
	<?php esc_html_e( 'Note: This field will not show in the form. Quiz scores will be automatically saved here.', 'formidable-quizzes' ); ?>
</p>
