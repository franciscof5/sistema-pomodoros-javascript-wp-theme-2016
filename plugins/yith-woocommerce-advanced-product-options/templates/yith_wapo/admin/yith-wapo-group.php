<?php
/**
 * Admin Products Options Group
 *
 * @author  Yithemes
 * @package YITH WooCommerce Advanced Product Options
 * @version 1.0.0
 */

defined( 'ABSPATH' ) or exit;

/*
 *	
 */

global $wpdb, $woocommerce;

$id = isset( $_GET['id'] ) && $_GET['id'] > 0 ? $_GET['id'] : ( isset( $_POST['id'] ) && $_POST['id'] > 0 ? $_POST['id'] : 0 );
$group = new YITH_WAPO_Group( $id );

?>

<div id="group" class="wrap wapo-plugin">

	<h1>
		<?php echo $group->id != '' ? __( 'Group', 'yith-woocommerce-advanced-product-options' ) . ': ' . $group->name : __( 'New group', 'yith-woocommerce-advanced-product-options' ); ?>
		<a href="edit.php?post_type=product&page=yith_wapo_group" class="page-title-action"><?php echo __( 'Add new', 'yith-woocommerce-advanced-product-options' ); ?></a>
	</h1>

	<form id="group-form" action="edit.php?post_type=product&page=yith_wapo_group" method="post">

		<input type="hidden" name="id" value="<?php echo $group->id; ?>">
		<input type="hidden" name="act" value="<?php echo $group->id > 0 ? 'update' : 'new'; ?>">
		<input type="hidden" name="class" value="YITH_WAPO_Group">
		<input type="hidden" name="types-order" value="">

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="name"><?php echo __( 'Group name', 'yith-woocommerce-advanced-product-options' ); ?></label></th>
					<td><input name="name" type="text" value="<?php echo $group->name; ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="products_id"><?php echo __( 'Products', 'yith-woocommerce-advanced-product-options' ); ?></label></th>
					<td>

						<input type="hidden" class="wc-product-search" style="width: 350px;" id="products_id" name="products_id"
							data-placeholder="<?php esc_attr_e( 'Applied to...', 'yith-woocommerce-advanced-product-options' ); ?>"
							data-action="woocommerce_json_search_products"
							data-multiple="true"
							data-exclude=""
							data-selected="<?php
						
								$product_ids = array_filter( array_map( 'absint', explode( ',', $group->products_id ) ) );
								$json_ids    = array();

								foreach ( $product_ids as $product_id ) {
									$product = wc_get_product( $product_id );
									if ( is_object( $product ) ) {
										$json_ids[ $product_id ] = wp_kses_post( html_entity_decode( $product->get_formatted_name(), ENT_QUOTES, get_bloginfo( 'charset' ) ) );
									}
								}

								echo esc_attr( json_encode( $json_ids ) );
								?>"
							value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>"
						/>

					</td>
				</tr>
				
				<tr>
					<th scope="row"><label for="categories_id"><?php echo __( 'Categories', 'yith-woocommerce-advanced-product-options' ); ?></label></th>
					<td>
						<select name="categories_id[]" class="categories_id-select2" multiple="multiple" placeholder="Applied to..."><?php

							$categories_array = explode( ',', $group->categories_id );
							echo_product_categories_childs_of( 0, 0, $categories_array );

							function echo_product_categories_childs_of( $id = 0, $tabs = 0, $categories_array = array() ) {
								$categories = get_categories( array( 'taxonomy'=>'product_cat', 'parent'=>$id, 'orderby'=>'name', 'order'=>'ASC' ) );
								foreach ( $categories as $key => $value ) {
									echo '<option value="' . $value->term_id . '" ' . ( in_array( $value->term_id, $categories_array ) ? 'selected="selected"' : '' ) . '>' . str_repeat( '&#8212;', $tabs ) . ' ' . $value->name . '</option>';
									$childs = get_categories( array( 'taxonomy'=>'product_cat', 'parent'=>$value->term_id, 'orderby'=>'name', 'order'=>'ASC' ) );
									if ( count( $childs ) > 0 ) { echo_product_categories_childs_of( $value->term_id, $tabs + 1, $categories_array ); }
								}
							}

						?></select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="priority"><?php echo __( 'Priority', 'yith-woocommerce-advanced-product-options' ); ?></label></th>
					<td><input name="priority" type="number" value="<?php echo $group->priority; ?>" class="small-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="visibility"><?php echo __( 'Visibility', 'yith-woocommerce-advanced-product-options' ); ?></label></th>
					<td>
						<select name="visibility">
							<option value="0" <?php selected( $group->visibility, 0 ); ?>><?php echo __( 'Hidden', 'yith-woocommerce-advanced-product-options' ); ?></option>
							<option value="1" <?php selected( $group->visibility, 1 ); ?>><?php echo __( 'Administrators only', 'yith-woocommerce-advanced-product-options' ); ?></option>
							<option value="9" <?php selected( $group->visibility, 9 ); ?>><?php echo __( 'Public', 'yith-woocommerce-advanced-product-options' ); ?></option>
						</select>
					</td>
				</tr>
				<?php if ( $group->id > 0 ) : ?>
					<tr>
						<th scope="row"><label for="types"><?php echo __( 'Add-ons', 'yith-woocommerce-advanced-product-options' ); ?></label></th>
						<td></td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>

	</form>

	<?php if ( $group->id > 0 ) : ?>

		<?php

		if( function_exists( 'wp_enqueue_media' ) ) { wp_enqueue_media(); } else {
		    wp_enqueue_style( 'thickbox' );
		    wp_enqueue_script( 'media-upload' );
		    wp_enqueue_script( 'thickbox' );
		}

		?>

		<!-- TYPES TABLE -->
		<div id="wapo-types" class="wrap">

			<div id="type-form-add" class="type-row">

				<a href="#" class="button button-primary wapo-type-new"><?php echo __( 'Add new', 'yith-woocommerce-advanced-product-options' );?></a>
			
				<form action="edit.php?post_type=product&page=yith_wapo_group" method="post">

					<input type="hidden" name="act" value="new">
					<input type="hidden" name="class" value="YITH_WAPO_Type">
					<input type="hidden" name="group_id" value="<?php echo $group->id; ?>">
					<input type="hidden" name="priority" value="0">

					<div class="form-left">
						<div class="form-row">
							<div class="type">
								<label for="label"><?php echo __( 'Add-on', 'yith-woocommerce-advanced-product-options' ); ?></label>
								<select name="type">
									<option value="checkbox"><?php _e( 'Checkbox' , 'yith-woocommerce-advanced-product-options' )  ?></option>
									<option value="color"><?php _e( 'Color' , 'yith-woocommerce-advanced-product-options' )  ?></option>
									<option value="date"><?php _e( 'Date' , 'yith-woocommerce-advanced-product-options' )  ?></option>
									<option value="labels"><?php _e( 'Labels' , 'yith-woocommerce-advanced-product-options' )  ?></option>
									<option value="number"><?php _e( 'Number' , 'yith-woocommerce-advanced-product-options' )  ?></option>
									<option value="select"><?php _e( 'Select' , 'yith-woocommerce-advanced-product-options' )  ?></option>
									<option value="radio"><?php _e( 'Radio Button' , 'yith-woocommerce-advanced-product-options' )  ?></option>
									<!---<option value="range">Range</option>-->
									<option value="text"><?php _e( 'Text' , 'yith-woocommerce-advanced-product-options' )  ?></option>
									<option value="textarea"><?php _e( 'Textarea' , 'yith-woocommerce-advanced-product-options' )  ?></option>
									<option value="file"><?php _e( 'Upload' , 'yith-woocommerce-advanced-product-options' )  ?></option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="image">
								<label for="image"><?php echo __( 'Image', 'yith-woocommerce-advanced-product-options' ); ?></label>
								<?php $image_url = YITH_WAPO_URL . '/assets/img/placeholder.png'; ?>

				                <input class="image" type="hidden" name="image" size="60" value="">
				                <img class="thumb image image-upload" src="<?php echo $image_url; ?>" height="100" />
				                <!--<a href="#" class="button image-upload"><?php echo __( 'Upload', 'cdz' ); ?></a>-->
				                <span class="dashicons dashicons-no remove"></span>

								<script>
								    jQuery(document).ready( function($) {
								        $('#type-form-add .image-upload').click( function(e) {
								            e.preventDefault();
								            var parent = $(this).parent();
								            var custom_uploader = wp.media({
								                title: 'Custom Image',
								                button: { text: 'Upload Image' },
								                multiple: false  // Set this to true to allow multiple files to be selected
								            })
								            .on('select', function() {
								                var attachment = custom_uploader.state().get('selection').first().toJSON();
								                $('.image', parent).attr('src', attachment.url );
								                $('.image', parent).val(attachment.url );

								            })
								            .open();
								        });
								        $('#type-form-add .remove').click( function(){
								        	var parent = $(this).parent();
								        	$('.image', parent).attr('src', '<?php echo YITH_WAPO_URL; ?>/assets/img/placeholder.png' );
								            $('.image', parent).val('');
								        });
								    });
								</script>
							</div>
						</div>
					</div>

					<div class="form-right">
						<div class="form-row">
							<div class="label">
								<label for="label"><?php echo __( 'Title', 'yith-woocommerce-advanced-product-options' ); ?></label>
								<input name="label" type="text" value="" class="regular-text">
							</div>
							<div class="depend">
								<label for="depend"><?php echo __( 'Requirements: <i>show this add-on to users only if they have first selected the following options</i>.', 'yith-woocommerce-advanced-product-options' ); ?></label>
								<!--<input name="depend" type="text" value="" class="regular-text">-->
								<select name="depend[]" class="depend-select2" multiple="multiple" placeholder="<?php echo __( 'Choose required add-ons', 'yith-woocommerce-advanced-product-options' ); ?>..."><?php
									$rows2 = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}yith_wapo_types WHERE group_id='$group->id' AND del='0' ORDER BY label ASC" );
									foreach ( $rows2 as $key2 => $value2 ) {
										echo '<option value="' . $value2->id . '">' . $value2->label . '</option>';
									}
								?></select>
							</div>
							<!--
							<div class="step">
								<label for="step"><?php echo __( 'Step', 'yith-woocommerce-advanced-product-options' ); ?></label>
								<input name="step" type="number" value="" disabled="disabled">
							</div>
							-->
							<div class="required">
								<label for="required"><?php echo __( 'Required', 'yith-woocommerce-advanced-product-options' ); ?>?</label>
								<input type="checkbox" name="required" value="1">
							</div>
						</div>
						<div class="form-row">
							<div class="description">
								<label for="description"><?php echo __( 'Description', 'yith-woocommerce-advanced-product-options' ); ?></label>
								<textarea name="description" id="description" rows="3" style="width: 100%;"></textarea>
							</div>
						</div>
						<div class="form-row">
							<div class="options">
								<i><?php echo __( 'Save the "Add-on" if you want to add new options.', 'yith-woocommerce-advanced-product-options' );?></i>
							</div>
						</div>
						<div class="form-row">
							<div class="submit">
								<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __( 'Save new add-on', 'yith-woocommerce-advanced-product-options' );?>">
								<a href="#" class="button cancel"><?php echo __( 'Cancel', 'yith-woocommerce-advanced-product-options' );?></a>
							</div>
						</div>

					</div>

					<div class="clear"></div>

				</form>

			</div>

			<ul id="sortable-list" class="sortable">
			
				<?php

				$rows = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}yith_wapo_types WHERE group_id='$group->id' AND del='0' ORDER BY priority ASC" );
				foreach ( $rows as $key => $value ) :

					$type_id = $value->id;
					$array_options = maybe_unserialize( $value->options );

					?>

					<li id="type-<?php echo $value->id; ?>" class="type-row">

						<a href="#type-form-<?php echo $value->id; ?>" class="wapo-type-edit">
							#<?php echo $value->id; ?> <?php echo $value->label; ?>
							<span>
								<strong><?php echo $value->type; ?></strong>
								<?php if ( isset($array_options['label']) && count( $array_options['label'] ) > 0 ) : ?>
									with <?php echo count( $array_options['label'] ) . ' ' . __( 'options', 'yith-woocommerce-advanced-product-options' ); ?>
								<?php endif; ?>
							</span>
							<?php if ( $value->required ) : ?><span style=" text-transform: capitalize;">[<?php echo __( 'Required', 'yith-woocommerce-advanced-product-options' ); ?>]</span><?php endif; ?>
							<span>
							<?php
							$rows_dep = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}yith_wapo_types WHERE id!='$value->id' AND group_id='$group->id' AND del='0' ORDER BY label ASC" );
							
							$depsinarray = array();
							foreach ( $rows_dep as $key_dep => $value_dep ) {
								$depend_array = explode( ',', $value->depend );
								if ( in_array( $value_dep->id, $depend_array ) ) { $depsinarray[] = '#' . $value_dep->id . ' ' . $value_dep->label; }
							}
							if ( count( $depsinarray ) > 0 ) {
								echo __( 'Dependencies: ', 'yith-woocommerce-advanced-product-options' );
								foreach ( $depsinarray as $key_dep => $value_dep ) {
									echo '<i>' . $value_dep . '</i>';
								}
							}
							?>
							</span>
						</a>
					
						<form action="edit.php?post_type=product&page=yith_wapo_group" method="post" class="<?php echo $value->type; ?>">

							<input type="hidden" name="id" value="<?php echo $value->id; ?>">
							<input type="hidden" name="act" value="update">
							<input type="hidden" name="class" value="YITH_WAPO_Type">
							<input type="hidden" name="group_id" value="<?php echo $value->group_id; ?>">
							<input type="hidden" name="priority" value="<?php echo $value->priority; ?>">

							<div class="form-left">
								<div class="form-row">
									<div class="type">
										<label for="label"><?php echo __( 'Add-on', 'yith-woocommerce-advanced-product-options' ); ?></label>
										<select name="type">
											<option value="checkbox" <?php selected( $value->type, 'checkbox' ); ?>><?php _e( 'Checkbox' , 'yith-woocommerce-advanced-product-options' )  ?></option>
											<option value="color" <?php selected( $value->type, 'color'); ?>><?php _e( 'Color' , 'yith-woocommerce-advanced-product-options' )  ?></option>
											<option value="date" <?php selected( $value->type, 'date'); ?>><?php _e( 'Date' , 'yith-woocommerce-advanced-product-options' )  ?></option>
											<option value="labels" <?php selected( $value->type, 'labels'); ?>><?php _e( 'Labels' , 'yith-woocommerce-advanced-product-options' )  ?></option>
											<option value="number" <?php selected( $value->type, 'number'); ?>><?php _e( 'Number' , 'yith-woocommerce-advanced-product-options' )  ?></option>
											<option value="select" <?php selected( $value->type, 'select'); ?>><?php _e( 'Select' , 'yith-woocommerce-advanced-product-options' )  ?></option>
											<option value="radio" <?php selected( $value->type, 'radio'); ?>><?php _e( 'Radio Button' , 'yith-woocommerce-advanced-product-options' )  ?></option>
											<option value="text" <?php selected( $value->type, 'text'); ?>><?php _e( 'Text' , 'yith-woocommerce-advanced-product-options' )  ?></option>
											<option value="textarea" <?php selected( $value->type, 'textarea'); ?>><?php _e( 'Textarea' , 'yith-woocommerce-advanced-product-options' )  ?></option>
											<option value="file" <?php selected( $value->type, 'file'); ?>><?php _e( 'Upload' , 'yith-woocommerce-advanced-product-options' )  ?></option>
										</select>
									</div>
								</div>
								<div class="form-row">
									<div class="image">
										<label for="image"><?php echo __( 'Image', 'yith-woocommerce-advanced-product-options' ); ?></label>
										<?php

										$image_url = YITH_WAPO_URL . '/assets/img/placeholder.png';
										if ( $value->image ) { $image_url = $value->image; }

										?>

						                <input class="image" type="hidden" name="image" size="60" value="<?php echo $value->image; ?>">
						                <img class="thumb image image-upload" src="<?php echo $image_url; ?>" height="100" />
						                <!--<a href="#" class="button image-upload"><?php echo __( 'Upload', 'cdz' ); ?></a>-->
						                <span class="dashicons dashicons-no remove"></span>

										<script>
										    jQuery(document).ready( function($) {
										        $('#type-<?php echo $type_id; ?> .image-upload').click( function(e) {
										            e.preventDefault();
										            var parent = $(this).parent();
										            var custom_uploader = wp.media({
										                title: 'Custom Image',
										                button: { text: 'Upload Image' },
										                multiple: false  // Set this to true to allow multiple files to be selected
										            })
										            .on('select', function() {
										                var attachment = custom_uploader.state().get('selection').first().toJSON();
										                $('.image', parent).attr('src', attachment.url );
										                $('.image', parent).val(attachment.url );

										            })
										            .open();
										        });
										        $('#type-<?php echo $type_id; ?> .remove').click( function(){
										        	var parent = $(this).parent();
										        	$('.image', parent).attr('src', '<?php echo YITH_WAPO_URL; ?>/assets/img/placeholder.png' );
										            $('.image', parent).val('');
										        });
										    });
										</script>
									</div>
								</div>
							</div>

							<div class="form-right">
								<div class="form-row">
									<div class="label">
										<label for="label"><?php echo __( 'Title', 'yith-woocommerce-advanced-product-options' ); ?></label>
										<input name="label" type="text" value="<?php echo $value->label; ?>" class="regular-text">
									</div>
									<div class="depend">
										<label for="depend"><?php echo __( 'Requirement: <i>show this add-on to users only if they have first selected the following options</i>.', 'yith-woocommerce-advanced-product-options' ); ?></label>
										<!--<input name="depend" type="text" value="<?php echo $value->depend; ?>" class="regular-text">-->
										<select name="depend[]" class="depend-select2" multiple="multiple" placeholder="<?php echo __( 'Choose required add-ons', 'yith-woocommerce-advanced-product-options' ); ?>..."><?php
											$rows2 = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}yith_wapo_types WHERE id!='$value->id' AND group_id='$group->id' AND del='0' ORDER BY label ASC" );
											foreach ( $rows2 as $key2 => $value2 ) {
												$depend_array = explode( ',', $value->depend );
												echo '<option value="' . $value2->id . '"' . ( in_array( $value2->id, $depend_array ) ? 'selected="selected"' : '' ) . '>' . $value2->label . '</option>';
											}
										?></select>
									</div>
									<!--
									<div class="step">
										<label for="step"><?php echo __( 'Step', 'yith-woocommerce-advanced-product-options' ); ?></label>
										<input name="step" type="number" value="<?php echo $value->step; ?>" disabled="disabled">
									</div>
									-->
									<div class="required">
										<label for="required"><?php echo __( 'Required', 'yith-woocommerce-advanced-product-options' ); ?>?</label>
										<input type="checkbox" name="required" value="1" <?php echo $value->required ? 'checked="checked"' : ''; ?>>
									</div>
								</div>
								<div class="form-row">
									<div class="description">
										<label for="description"><?php echo __( 'Description', 'yith-woocommerce-advanced-product-options' ); ?></label>
										<textarea name="description" id="description" rows="3" style="width: 100%;"><?php echo $value->description; ?></textarea>
									</div>
								</div>
								<div class="form-row">
									<div class="options">
										<table class="wp-list-table widefat fixed">
											<tr>
												<th class="option-image"><?php echo __( 'Image', 'yith-woocommerce-advanced-product-options' );?></th>
												<th class="option-label"><?php echo __( 'Option Label', 'yith-woocommerce-advanced-product-options' );?></th>
												<th class="option-type"><?php echo __( 'Type', 'yith-woocommerce-advanced-product-options' );?></th>
												<th class="option-price"><?php echo __( 'Price', 'yith-woocommerce-advanced-product-options' );?></th>
												<th class="option-min"><?php echo __( 'Min', 'yith-woocommerce-advanced-product-options' );?></th>
												<th class="option-max"><?php echo __( 'Max', 'yith-woocommerce-advanced-product-options' );?></th>
												<!--<th class="option-description"><?php echo __( 'Description', 'yith-woocommerce-advanced-product-options' );?></th>-->
												<th class="option-delete"></th>
											</tr>
											<?php
												$array_options = maybe_unserialize( $value->options );
												if ( ! isset($array_options['description'] ) ) { $array_options['description'] = ''; }
												if ( isset( $array_options['label'] ) && is_array( $array_options['label'] ) ) {
													$i = 0;
													$array_default = isset( $array_options['default'] ) ? $array_options['default'] : array();
													foreach ( $array_options['label'] as $key => $value ) : ?>
														<tr>
															<td>
																<div id="option-image-<?php echo $i; ?>" class="option-image">
																	<div class="image">
																		<?php

																		$image_url = YITH_WAPO_URL . '/assets/img/placeholder.png';

                                                                        if ( isset( $array_options['image'] ) && isset( $array_options['image'][$i] ) && $array_options['image'][$i] ) { $image_url = $array_options['image'][$i]; }

																		?>

														                <input class="opt-image" type="hidden" name="options[image][]" size="60" value="<?php echo isset( $array_options['image'] ) ? $array_options['image'][$i] : ''; ?>">
														                <img class="thumb opt-image opt-image-upload" src="<?php echo $image_url; ?>" height="100" />
														                <!--<a href="#" class="button opt-image-upload"><?php echo __( 'Upload', 'cdz' ); ?></a>-->
														                <span class="dashicons dashicons-no opt-remove"></span>

																		<script>
																		    jQuery(document).ready( function($) {
																		        $('#type-<?php echo $type_id; ?> #option-image-<?php echo $i; ?> .opt-image-upload').click( function(e) {
																		            e.preventDefault();
																		            var parent = $(this).parent();
																		            var custom_uploader = wp.media({
																		                title: 'Custom Image',
																		                button: { text: 'Upload Image' },
																		                multiple: false  // Set this to true to allow multiple files to be selected
																		            })
																		            .on('select', function() {
																		                var attachment = custom_uploader.state().get('selection').first().toJSON();
																		                $('.opt-image', parent).attr('src', attachment.url );
																		                $('.opt-image', parent).val(attachment.url );

																		            })
																		            .open();
																		        });
																		        $('#type-<?php echo $type_id; ?> #option-image-<?php echo $i; ?> .opt-remove').click( function(){
																		        	var parent = $(this).parent();
																		        	$('.opt-image', parent).attr('src', '<?php echo YITH_WAPO_URL; ?>/assets/img/placeholder.png' );
																		            $('.opt-image', parent).val('');
																		        });
																		    });
																		</script>
																	</div>
																</div>
															</td>
															<td colspan="6">
																<div class="option-image"></div>
																<div class="option-label"><input type="text" name="options[label][]" value="<?php echo stripslashes( $array_options['label'][$i] ); ?>" placeholder="Label" /></div>
																<div class="option-type">
																	<select name="options[type][]">
																		<option value="fixed" <?php echo isset( $array_options['type'][$i] ) && $array_options['type'][$i] == 'fixed' ? 'selected="selected"' : ''; ?>><?php echo __( 'Fixed amount', 'yith-woocommerce-advanced-product-options' ); ?></option>
																		<option value="percentage" <?php echo isset( $array_options['type'][$i] ) && $array_options['type'][$i] == 'percentage' ? 'selected="selected"' : ''; ?>><?php echo __( '% markup', 'yith-woocommerce-advanced-product-options' ); ?></option>
																	</select>
																	<!--<input type="text" name="options[type][]" value="<?php echo $array_options['type'][$i]; ?>" placeholder="0" />-->
																</div>
																<div class="option-price"><input type="text" name="options[price][]" value="<?php echo $array_options['price'][$i]; ?>" placeholder="0" /></div>
																<div class="option-min"><input type="text" name="options[min][]" value="<?php echo $array_options['min'][$i]; ?>" placeholder="0" /></div>
																<div class="option-max"><input type="text" name="options[max][]" value="<?php echo $array_options['max'][$i]; ?>" placeholder="0" /></div>
																<div class="option-delete"><a class="button remove-row"><?php echo __( 'Delete', 'yith-woocommerce-advanced-product-options' ); ?></a></div>
																<div class="option-description" colspan="6"><input type="text" name="options[description][]" value="<?php echo stripslashes( $array_options['description'][$i] ); ?>" placeholder="Description" /></div>
																<div class="option-default">
																	<input type="checkbox" name="options[default][]" value="<?php echo $i; ?>"
																		<?php foreach ( $array_default as $key_def => $value_def ) { echo $i == $value_def ? 'checked="checked"' : ''; } ?> />
																	<?php echo __( 'Checked', 'yith-woocommerce-advanced-product-options' );?>
																</div>
															</td>
														</tr>
														<?php $i++;
													endforeach;
												}
											?>
											<tr>
												<td>
													<div id="option-image-new" class="option-image">
														<p class="save-first"><?php echo __( 'Save to set image!', 'yith-woocommerce-advanced-product-options' ); ?></p>
													</div>
												</td>
												<td colspan="6">
													<div class="option-label"><input type="text" name="options[label][]" value="" placeholder="Label" /></div>
													<div class="option-type">
														<select name="options[type][]">
															<option value="fixed"><?php echo __( 'Fixed amount', 'yith-woocommerce-advanced-product-options' ); ?></option>
															<option value="percentage"><?php echo __( '% markup', 'yith-woocommerce-advanced-product-options' ); ?></option>
														</select>
													</div>
													<div class="option-price"><input type="text" name="options[price][]" value="" placeholder="0" /></div>
													<div class="option-min"><input type="text" name="options[min][]" value="" placeholder="0" /></div>
													<div class="option-max"><input type="text" name="options[max][]" value="" placeholder="0" /></div>
													<div class="option-delete"><a class="button" style="display: none;"><?php echo __( 'Delete', 'yith-woocommerce-advanced-product-options' );?></a></div>
													<div class="option-description"><input type="text" name="options[description][]" value="" placeholder="Description" /></div>
													<div class="option-default"><input type="checkbox" name="options[default][]" value="" /> <?php echo __( 'Checked', 'yith-woocommerce-advanced-product-options' );?></div>
												</td>
											</tr>
											<tr>
												<td colspan="7"><i><?php echo __( 'Choose an option to see more options ;)', 'yith-woocommerce-advanced-product-options' );?></i></td>
											</tr>
										</table>
									</div>
								</div>
								<div class="form-row">
									<div class="delete" style="color: #a00; float: right;">
										<input type="checkbox" name="del" value="1"> <?php echo __( 'Delete this Add-on', 'yith-woocommerce-advanced-product-options' );?>
										<span class="dashicons dashicons-trash"></span>
									</div>
									<div class="submit">
										<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __( 'Save add-on', 'yith-woocommerce-advanced-product-options' );?>">
									</div>
								</div>
							</div>

							<div class="clear"></div>
						</form>

					</li>

				<?php endforeach; ?>

			</ul>

		</div>

	<?php endif; ?>

	<p class="submit">
		<input type="submit" name="submit" id="submit" form="group-form" class="button button-primary" value="<?php echo __( 'Save group', 'yith-woocommerce-advanced-product-options' );?>">
		<input type="checkbox" name="del" value="1" form="group-form" style="margin-left: 20px;">
		<span style="color: #a00;"><?php echo __( 'Delete this group', 'yith-woocommerce-advanced-product-options' );?> <span class="dashicons dashicons-trash" style="margin-top: 5px;"></span></span>
	</p>

	</form>

</div>

<script>

	// OPEN TYPE NEW
	jQuery('.wapo-type-edit').click( function() {
		jQuery(this).next('form').toggle('fast');
	});
	jQuery('.wapo-type-new').click( function() {
		jQuery(this).hide();
		jQuery(this).next('form').slideDown('fast');
	});
	jQuery('.cancel.button').click( function() {
		jQuery(this).parents('form').slideUp();
		jQuery('.wapo-type-new').fadeIn();
	});

	// MANAGE OPTIONS TABLE
	jQuery('.options table .option-label input').live( 'change', function(){

		var delete_button = jQuery( '.button.remove-row', jQuery(this).parents('tr') );
		if ( jQuery(this).val() ) { delete_button.fadeIn(); }
		else { delete_button.fadeOut(); }
		
		var empty_fields = jQuery( '.option-label input', jQuery(this).parents('table') ).filter( function(){ return ! jQuery(this).val(); }).length;
		if ( empty_fields < 1 ) {
			var tr = jQuery(this).parents('tr');
			var clone = tr.clone();
			clone.find(':text').val('');
			clone.find(':checkbox').removeAttr('checked');
			clone.find('.button.remove-row').css('display','none').css('opacity','1');
			//clone.find('#option-image-new').html('<p class="save-first">Save to upload the image!</p>');
			tr.after( clone );
		}

	});
	jQuery('.button.remove-row').live( 'click', function(){
		jQuery(this).parents('tr').remove();
	});

	// CHANGE TYPE
	jQuery('.type select').live( 'change', function(){
		jQuery(this).parents('form').removeClass().addClass(jQuery(this).val());
		changeType( jQuery(this) );
	});

	function changeType( item ) {

		if ( item ) { var parent = item.parents('.type-row'); }
		else { var parent = jQuery('body'); }
		
		jQuery('form .option-min input', parent).val('-').attr('disabled','disabled');
		jQuery('form .option-max input', parent).val('-').attr('disabled','disabled');

		jQuery('form.number .option-min input', parent).val('').removeAttr('disabled');
		jQuery('form.number .option-max input', parent).val('').removeAttr('disabled');
		
		jQuery('form.price .option-min input', parent).val('').removeAttr('disabled');
		jQuery('form.price .option-max input', parent).val('').removeAttr('disabled');
		
		jQuery('form.range .option-min input', parent).val('').removeAttr('disabled');
		jQuery('form.range .option-max input', parent).val('').removeAttr('disabled');

		jQuery('form.textarea .option-min input', parent).val('').removeAttr('disabled');
		jQuery('form.textarea .option-max input', parent).val('').removeAttr('disabled');

	}

	changeType( );

	// SELECT 2
	jQuery(".products_id-select2").select2();
	jQuery(".categories_id-select2").select2();
	jQuery(".attributes_id-select2").select2();
	jQuery(".depend-select2").select2();

	// SORTABLE
	jQuery('.sortable').sortable({
		axis: 'y',
		update: function (event, ui) {
			var priority = 1;
			var types_order = '';
			jQuery('.sortable > li').each(function(i) {
				//jQuery( 'input[name="priority"]', this ).val( priority );
				var id = jQuery( 'input[name="id"]', this ).val();
				types_order += id + ',';
				jQuery('input[name="types-order"]').val( types_order );
				priority++;
			});
		}
	});
	
	// DEFAULT / CHECKED
	jQuery('form.select .option-default input[type=checkbox], form.radio .option-default input[type=checkbox]').on('click', function(){
		var form = jQuery(this).parents('form');
		if ( jQuery(this).is(':checked') ){
			jQuery('.option-default input[type=checkbox]', form).removeAttr('checked');
			jQuery(this).attr('checked', 'checked');
		}
	});

	// TITLE PAGE
	document.title = "YITH Advanced Product Options";

</script>