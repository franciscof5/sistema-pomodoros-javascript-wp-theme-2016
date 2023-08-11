<h3><?php esc_html_e( 'Quizzes', 'formidable-quizzes' ); ?></h3>

<table class="form-table">
	<tr>
		<td class="frm_left_label">
			<label for="quiz_key">
				<?php esc_html_e( 'Quiz Key', 'formidable-quizzes' ); ?>
				<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'Select the entry to use as the key. All quizzes will be scored using the selected entry.', 'formidable-quizzes' ); ?>" ></span>
			</label>
		</td>
		<td>
			<?php if ( empty( $entries ) ) { ?>
				<p class="howto">
					<?php FrmQuizzesFormSettings::add_entry_message( $form_id ); ?>
				</p>
			<?php } else { ?>
				<select name="quiz_key">
					<option><?php esc_html_e( 'Select Entry for Scoring', 'formidable-quizzes' ); ?></option>
					<?php foreach ( $entries as $entry ) { ?>
						<option <?php selected( $quiz_key, $entry->id, true ); ?> value="<?php echo esc_attr( $entry->id ); ?>">
							<?php echo esc_html( '#' . $entry->id . ' (' . $entry->item_key . ')' ); ?>
						</option>
					<?php } ?>
				</select>
			<?php } ?>
		</td>
	</tr>
</table>
