<?php
/**
 * Magcast Meta Boxes
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
// Add only to page and posts
add_action( 'add_meta_boxes_page', 'magcast_metabox' );
add_action( 'add_meta_boxes_post', 'magcast_metabox' );

/**
 * Add Meta Boxes.
 *
 */
function magcast_metabox() {
	add_meta_box(
		'siderbar-layout',
		__( 'Below setting will not reflect on Main Blog Layout', 'magcast' ),
		'magcast_sidebar_layout'
	);
}

/**
 * Displays metabox to for sidebar layout
 */
function magcast_sidebar_layout( $post ) {
	// Crea
	$sidebar_options = array(
	'default-sidebar' => array(
		'id'        => 'magcast_sidebarlayout',
		'value'     => 'default',
		'label'     => __( 'Default Layout Set in Customizer', 'magcast' ),
		),
	'no-sidebar' 				=> array(
		'id'    => 'magcast_sidebarlayout',
		'value' => 'no-sidebar',
		'label' => __( 'No sidebar', 'magcast' ),
		),
	'no-sidebar-full-width' => array(
		'id'    => 'magcast_sidebarlayout',
		'value' => 'no-sidebar-full-width',
		'label' => __( 'No sidebar, Full Width', 'magcast' ),
		),
	'left-sidebar' => array(
		'id'    => 'magcast_sidebarlayout',
		'value' => 'left-sidebar',
		'label' => __( 'Left sidebar', 'magcast' ),
		),
	'right-sidebar' => array(
		'id'    => 'magcast_sidebarlayout',
		'value' => 'right-sidebar',
		'label' => __( 'Right sidebar', 'magcast' ),
		),
	);

	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'magcast_metabox_check' );

	// Begin the field table and loop  ?>
<table id="sidebar-metabox" class="form-table" width="100%">
	<tbody>
		<tr>
			<?php
			foreach ( $sidebar_options as $field ) {
				$meta = get_post_meta( $post->ID, 'magcast_sidebarlayout', true );
				if ( empty( $meta ) ) {
					$meta = 'default';
				} ?>
		<td>
			<label class="description">
				<input type="radio" name="<?php echo esc_attr( $field['id'] ); ?>" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( esc_attr( $field['value'] ), $meta ); ?>/>
				<?php echo esc_attr( $field['label'] ); ?>
			</label>
		</td>
			<?php
			} // End foreach(). ?>
		</tr>
	</tbody>
</table>
<?php
}

add_action( 'save_post', 'magcast_save_custom_meta', 10, 2 );
/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function magcast_save_custom_meta( $post_id, $post ) {

	// Verify the nonce before proceeding.
	if ( ! isset( $_POST['magcast_metabox_check'] ) || ! wp_verify_nonce( $_POST['magcast_metabox_check'], basename( __FILE__ ) ) ) {
		return;
	}

	// Stop WP from clearing custom fields on autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// If user cannot edit posts/page we return.
	if ( ! current_user_can( 'edit_pages' )  || ! current_user_can( 'edit_posts' ) ) {
		return $post_id;
	}

	// Create a whitelist of accepted values.
	$options = array( 'default', 'no-sidebar', 'right-sidebar', 'left-sidebar', 'no-sidebar-full-width' );

	// We make sure there is something to save.
	if ( isset( $_POST['magcast_sidebarlayout'] )
		&& ! empty( $_POST['magcast_sidebarlayout'] )
		&& in_array( $_POST['magcast_sidebarlayout'], $options, true ) ) {
		update_post_meta( $post_id, 'magcast_sidebarlayout', $_POST['magcast_sidebarlayout'] );
	}
}