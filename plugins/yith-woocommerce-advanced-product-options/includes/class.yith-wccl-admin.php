<?php
/**
 * Admin class
 *
 * @author Yithemes
 * @package YITH WooCommerce Color and Label Variations Premium
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WAPO' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCCL_Admin' ) ) {
	/**
	 * Admin class.
	 * The class manage all the admin behaviors.
	 *
	 * @since 1.0.0
	 */
	class YITH_WCCL_Admin {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCCL_Admin
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin option
		 *
		 * @var array
		 * @access public
		 * @since 1.0.0
		 */
		public $option = array();

		/**
		 * Plugin custom taxonomy
		 *
		 * @var array
		 * @access public
		 * @since 1.0.0
		 */
		public $_custom_tax = array();

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_WAPO_VERSION;

		/**
		 * @var $_panel Object
		 */
		protected $_panel;

		/**
		 * @var string panel page
		 */
		protected $_panel_page = 'yith_wapo_panel';

		/**
		 * Various links
		 *
		 * @var string
		 * @access public
		 * @since 1.0.0
		 */
		public $doc_url = 'http://yithemes.com/docs-plugins/yith-woocommerce-color-label-variations';

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCCL_Admin
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct() {

			// define custom taxonomy
			$this->_custom_tax = array(
				'colorpicker' => __( 'Colorpicker', 'yith-woocommerce-advanced-product-options' ),
				'image'       => __( 'Image', 'yith-woocommerce-advanced-product-options' ),
				'label'       => __( 'Label', 'yith-woocommerce-advanced-product-options' )
			);

			// add_action( 'admin_menu', array( $this, 'register_panel' ), 5) ;

			// enqueue style and scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			// add new attribute types
			add_action( 'woocommerce_admin_attribute_types', array( $this, 'attribute_types' ) );

			// add description field to products attribute
			add_action( 'admin_footer', array( $this, 'add_description_field' ) );
			add_action( 'woocommerce_attribute_added', array( $this, 'attribute_add_description_field' ), 10, 2 );
			add_action( 'woocommerce_attribute_updated', array( $this, 'attribute_update_description_field' ), 10, 3 );
			add_action( 'woocommerce_attribute_deleted', array( $this, 'attribute_delete_description_field' ), 10, 3 );

			// product attribute taxonomies
			add_action( 'init', array( $this, 'attribute_taxonomies' ) );

			// print attribute field type
			add_action( 'yith_wccl_print_attribute_field', array( $this, 'print_attribute_type' ), 10, 3 );

			// choose variations in product page
			add_action( 'woocommerce_product_option_terms', array($this, 'product_option_terms' ), 10, 2 );

			// add term directly from product variation
			add_action( 'admin_footer', array( $this, 'product_option_add_terms_form' ) );

			// save new term
			add_action( 'created_term', array( $this, 'attribute_save' ), 10, 3 );
			add_action( 'edit_term', array( $this, 'attribute_save' ), 10, 3 );

			// ajax add attribute
			add_action( 'wp_ajax_yith_wccl_add_new_attribute', array( $this, 'yith_wccl_add_new_attribute_ajax' ) );
			add_action( 'wp_ajax_nopriv_yith_wccl_add_new_attribute', array( $this, 'yith_wccl_add_new_attribute_ajax' ) );
		}


		/**
		 * Add a panel under YITH Plugins tab
		 *
		 * @return   void
		 * @since    1.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 * @use     /Yit_Plugin_Panel class
		 * @see      plugin-fw/lib/yit-plugin-panel.php
		 */
		public function register_panel() {

			if ( ! empty( $this->_panel ) ) {
				return;
			}

			$admin_tabs = array(
				'general' => __( 'Manage variations', 'yith-woocommerce-advanced-product-options' )
			);

			$args = array(
				'create_menu_page' => true,
				'parent_slug'      => '',
				'page_title'       => __( 'Advanced Product Options', 'yith-woocommerce-advanced-product-options' ),
				'menu_title'       => __( 'Advanced Product Options', 'yith-woocommerce-advanced-product-options' ),
				'capability'       => 'manage_options',
				'parent'           => '',
				'parent_page'      => 'yit_plugin_panel',
				'page'             => $this->_panel_page,
				'admin-tabs'       => apply_filters( 'yith-wccl-admin-tabs', $admin_tabs ),
				'options-path'     => YITH_WAPO_DIR . '/plugin-options'
			);

			/* === Fixed: not updated theme  === */
			if( ! class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
				require_once( YITH_WAPO_DIR . '/plugin-fw/lib/yit-plugin-panel-wc.php' );
			}

			$this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );

            add_action( 'woocommerce_admin_field_yith_wapo_upload', array( $this->_panel, 'yit_upload' ), 10, 1 );

		}

		/**
		 * Enqueue scripts
		 *
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function enqueue_scripts(){
			global $pagenow;

			if( ( ( 'edit-tags.php' == $pagenow || 'edit.php' == $pagenow ) && isset( $_GET['post_type'] ) && 'product' == $_GET['post_type'] )
			    || ( 'post.php' == $pagenow && isset( $_GET['action'] ) && $_GET['action'] == 'edit' )
			    || ( 'post-new.php' == $pagenow && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'product' ) ) {

				wp_enqueue_media();
				wp_enqueue_style( 'yith-wccl-admin', YITH_WAPO_URL . '/assets/css/yith-wccl-admin.css', array( 'wp-color-picker' ), $this->version );
				wp_enqueue_script( 'yith-wccl-admin', YITH_WAPO_URL . '/assets/js/yith-wccl-admin.js', array(
						'jquery',
						'wp-color-picker'
					), $this->version, true );

				wp_localize_script( 'yith-wccl-admin', 'yith_wccl_admin', array(
					'ajaxurl'   => admin_url( 'admin-ajax.php' ),
				));
			}
		}

		/**
		 * Add description field to add/edit products attribute
		 *
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function add_description_field(){
			global $pagenow, $wpdb;

			if( ! ( 'edit.php' == $pagenow && isset( $_GET['post_type'] ) && 'product' == $_GET['post_type'] && isset( $_GET['page'] ) && $_GET['page'] == 'product_attributes' ) ) {
				return;
			}

			$edit = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : false;
			$att_description = false;

			if( $edit ) {
				$attribute_to_edit = $wpdb->get_var( "SELECT meta_value FROM " . $wpdb->prefix . "yith_wccl_meta WHERE wc_attribute_tax_id = '$edit'" );
				$att_description  = isset( $attribute_to_edit ) ? $attribute_to_edit : false;
			}

			ob_start();

			wc_get_template( 'yith-wccl-description-field.php', array(
				'value'   => $att_description,
				'edit'    => $edit
			), '', YITH_WAPO_DIR . 'templates/admin/' );

			$html = ob_get_clean();


			wp_localize_script( 'yith-wccl-admin', 'yith_wccl_admin', array(
				'html' => $html
			) );

		}

		/**
		 * Add new product attribute description
		 *
		 * @since 1.0.0
		 * @param integer $id
		 * @param mixed $attribute
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function attribute_add_description_field( $id, $attribute ) {
			global $wpdb;

			// get attribute description
			$descr = isset( $_POST['attribute_description'] ) ? wc_clean( $_POST['attribute_description'] ) : '';

			// insert db value
			if( $descr ) {
				$attr = array();

				$attr['wc_attribute_tax_id'] = $id;
				// add description
				$attr['meta_key']   = '_wccl_attribute_description';
				$attr['meta_value'] = $descr;

				$wpdb->insert( $wpdb->prefix . 'yith_wccl_meta', $attr );
			}
		}

		/**
		 * Update product attribute description
		 *
		 * @since 1.0.0
		 * @param integer $id
		 * @param mixed $attribute
		 * @param mixed $old_attributes
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function attribute_update_description_field( $id, $attribute, $old_attributes ) {
			global $wpdb;

			$descr = isset( $_POST['attribute_description'] ) ? wc_clean( $_POST['attribute_description'] ) : '';

			// get meta value
			$meta = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "yith_wccl_meta WHERE wc_attribute_tax_id = %d", $id ) );

			if( ! isset( $meta ) ) {
				$this->attribute_add_description_field(  $id, $attribute );
			}
			elseif( $meta->meta_value != $descr ) {

				$attr = array();

				$attr['meta_value'] = $descr;

				$wpdb->update( $wpdb->prefix . 'yith_wccl_meta', $attr, array( 'meta_id' => $meta->meta_id ) );
			}
		}

		/**
		 * Delete product attribute description
		 *
		 * @since 1.0.0
		 * @param $attribute_id
		 * @param $attribute_name
		 * @param $taxonomy
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function attribute_delete_description_field( $attribute_id, $attribute_name, $taxonomy ) {
			global $wpdb;

			$meta_id = $wpdb->get_var( $wpdb->prepare( "SELECT meta_id FROM " . $wpdb->prefix . "yith_wccl_meta WHERE wc_attribute_tax_id = %d", $attribute_id ) );

			if( $meta_id ) {
				$wpdb->query( "DELETE FROM {$wpdb->prefix}yith_wccl_meta WHERE wc_attribute_tax_id = $attribute_id" );
			}
		}

		/**
		 * Add new attribute types to standard woocommerce
		 *
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function attribute_types(){
			global $wpdb;

			// init selected type
			$att_type = '';

			if( isset( $_GET['edit'] ) ) {
				// else if isset edit get selected type
				$edit              = absint( $_GET['edit'] );
				$attribute_to_edit = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_id = '$edit'" );
				$att_type          = $attribute_to_edit->attribute_type;
			}

			foreach ( $this->_custom_tax as $key => $name ) : ?>
				<option value="<?php echo $key ?>" <?php selected( $att_type, $key ); ?>><?php echo $name ?></option>
			<?php
			endforeach;
		}

		/**
		 * Init product attribute taxonomies
		 *
		 * @since 1.0.0
		 * @access public
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function attribute_taxonomies(){

			$attribute_taxonomies = wc_get_attribute_taxonomies();

			if ( $attribute_taxonomies ) {
				foreach ( $attribute_taxonomies as $tax ) {

					// check if tax is custom
					if( ! array_key_exists( $tax->attribute_type, $this->_custom_tax ) ) {
						continue;
					}

					add_action( wc_attribute_taxonomy_name( $tax->attribute_name ) . '_add_form_fields', array( $this, 'add_attribute_field' ) );
					add_action( wc_attribute_taxonomy_name( $tax->attribute_name ) . '_edit_form_fields', array( $this, 'edit_attribute_field' ), 10, 2 );

					add_filter( 'manage_edit-' . wc_attribute_taxonomy_name( $tax->attribute_name ) . '_columns', array( $this, 'product_attribute_columns' ) );
					add_filter( 'manage_' . wc_attribute_taxonomy_name( $tax->attribute_name ) . '_custom_column', array( $this, 'product_attribute_column' ), 10, 3 );
				}
			}
		}

		/**
		 * Add field for each product attribute taxonomy
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function add_attribute_field( $taxonomy ) {
			global $wpdb;

			$attribute = substr( $taxonomy, 3 );
			$attribute = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attribute'" );

			$values = array(
				'value'    => array(
					'value' => false,
					'label' => $this->_custom_tax[ $attribute->attribute_type ],
					'desc'  => ''
				),
				'tooltip'  => array(
					'value' => false,
					'label' => __( 'Tooltip', 'yith-woocommerce-advanced-product-options' ),
					'desc'  => __( 'Use this placeholder {show_image} to preview the image in the tooltip. Available only for image type', 'yith-woocommerce-advanced-product-options' ),
				),
			);

			do_action( 'yith_wccl_print_attribute_field', $attribute->attribute_type, $values );
		}

		/**
		 * Edit field for each product attribute taxonomy
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function edit_attribute_field( $term, $taxonomy ) {
			global $wpdb;

			$attribute = substr( $taxonomy, 3 );
			$attribute = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attribute'" );

			$values = array(
				'value'    => array(
					'value' => get_woocommerce_term_meta( $term->term_id, $taxonomy . '_yith_wccl_value' ),
					'label' => $this->_custom_tax[ $attribute->attribute_type ],
					'desc'  => ''
				),
				'tooltip'  => array(
					'value' => get_woocommerce_term_meta( $term->term_id, $taxonomy . '_yith_wccl_tooltip' ),
					'label' => __( 'Tooltip', 'yith-woocommerce-advanced-product-options' ),
					'desc'  =>  __( 'Use this placeholder {show_image} to preview the image in the tooltip. Only available for image type', 'yith-woocommerce-advanced-product-options' ),
				),
			);

			do_action( 'yith_wccl_print_attribute_field', $attribute->attribute_type, $values, true );
		}


		/**
		 * Print Attribute Tax Type HTML
		 *
		 * @access public
		 * @since 1.0.0
		 * @param $type
		 * @param mixed $values
		 * @param bool $table
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function print_attribute_type( $type, $values, $table = false ){

			foreach( $values as $key => $value ) :

				$data  = $key == 'value' ? 'data-type="' . $type . '"' : '';

				if( $table ): ?>
					<tr class="form-field">
					<th scope="row" valign="top"><label for="term_<?php echo $key ?>"><?php echo $value['label'] ?></label></th>
					<td>
				<?php else: ?>
					<div class="form-field">
					<label for="term_<?php echo $key ?>"><?php echo $value['label'] ?></label>
				<?php endif ?>

				<input type="text" name="term_<?php echo $key ?>" id="term_<?php echo $key ?>" value="<?php if ( $value['value'] ) echo $value['value'] ?>" <?php echo $data ?>/>

				<p><?php echo $value['desc'] ?></p>

				<?php if( $table ): ?>
					</td>
					</tr>
				<?php else: ?>
					</div>
				<?php endif;
			endforeach;
		}

		/**
		 * Save attribute field
		 *
		 * @access public
		 * @since 1.0.0
		 * @param $term_id
		 * @param $tt_id
		 * @param $taxonomy
		 * @author Francesco Licandro <francesco.licandro@yithemec.com>
		 */
		public function attribute_save( $term_id, $tt_id, $taxonomy ) {
			if( isset( $_POST['term_value'] ) ) {
				update_woocommerce_term_meta( $term_id, $taxonomy . '_yith_wccl_value', $_POST['term_value'] );
			}
			if( isset( $_POST['term_tooltip'] ) ) {
				update_woocommerce_term_meta( $term_id, $taxonomy . '_yith_wccl_tooltip', $_POST['term_tooltip'] );
			}
		}

		/**
		 * Create new column for product attributes
		 *
		 * @access public
		 * @since 1.0.0
		 * @param $columns
		 * @return mixed
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function product_attribute_columns( $columns ) {
			$temp_cols = array();
			// checkbox
			$temp_cols['cb'] = $columns['cb'];
			// value
			$temp_cols['yith_wccl_value'] = __( 'Value', 'yith-woocommerce-advanced-product-options' );

			unset( $columns['cb'] );
			$columns = array_merge( $temp_cols, $columns );

			return $columns;
		}

		/**
		 * Print the column content
		 *
		 * @access public
		 * @since 1.0.0
		 * @param $columns
		 * @param $column
		 * @param $id
		 * @return mixed
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function product_attribute_column( $columns, $column, $id ) {
			global $taxonomy, $wpdb;

			if ( $column == 'yith_wccl_value' ) {

				$attribute  = substr( $taxonomy, 3 );
				$attribute  = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attribute'");
				$att_type 	= $attribute->attribute_type;

				$value = get_woocommerce_term_meta( $id, $taxonomy . '_yith_wccl_value' );
				$columns .= $this->_print_attribute_column( $value, $att_type );
			}

			return $columns;
		}


		/**
		 * Print the column content according to attribute type
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		protected function _print_attribute_column( $value, $type ) {
			$output = '';

			if( $type == 'colorpicker' ) {
				$output = '<span class="yith-wccl-color" style="background-color:'. $value .'"></span>';
			} elseif( $type == 'label' ) {
				$output = '<span class="yith-wccl-label">'. $value .'</span>';
			} elseif( $type == 'image' ) {
				$output = '<img class="yith-wccl-image" src="'. $value .'" alt="" />';
			}

			return $output;
		}

		/**
		 * Print select for product variations
		 *
		 * @since 1.0.0
		 * @param $taxonomy
		 * @param $i
		 * @author Francesco Licandro <francesco.licandro@yithemec.com>
		 */
		public function product_option_terms( $taxonomy, $i ) {

			if( ! array_key_exists( $taxonomy->attribute_type, $this->_custom_tax ) ) {
				return;
			}

			global $thepostid;

			$attribute_taxonomy_name = wc_attribute_taxonomy_name( $taxonomy->attribute_name );

			?>

			<select multiple="multiple" data-placeholder="<?php _e( 'Select terms', 'yith-woocommerce-advanced-product-options' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo $i; ?>][]">
				<?php
				$all_terms = get_terms( $attribute_taxonomy_name, 'orderby=name&hide_empty=0' );
				if ( $all_terms ) {
					foreach ( $all_terms as $term ) {
						echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( has_term( absint( $term->term_id ), $attribute_taxonomy_name, $thepostid ), true, false ) . '>' . $term->name . '</option>';
					}
				}
				?>
			</select>
			<button class="button plus select_all_attributes"><?php _e( 'Select all', 'yith-woocommerce-advanced-product-options' ); ?></button>
			<button class="button minus select_no_attributes"><?php _e( 'Deselect all', 'yith-woocommerce-advanced-product-options' ); ?></button>
			<button class="button fr plus yith_wccl_add_new_attribute" data-type_input="<?php echo $taxonomy->attribute_type ?>"><?php _e( 'Add new', 'yith-woocommerce-advanced-product-options' ); ?></button>

			<?php
		}

		/**
		 * Add form in footer to add new attribute from edit product page
		 *
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function product_option_add_terms_form() {

			global $pagenow, $post;

			if( $pagenow != 'post.php' && isset( $post ) && get_post_type( $post->ID ) != 'product' ){
				return;
			}

			ob_start();

			?>

			<div id="yith_wccl_dialog_form" title="<?php _e('Create new attribute term','yith-woocommerce-advanced-product-options')?>" style="display:none;">
				<span class="dialog_error"></span>
				<form>
					<fieldset>
						<label for="term_name"><?php _e( 'Name', 'yith-woocommerce-advanced-product-options' ) ?>:
							<input type="text" name="term_name" id="term_name" value="" >
						</label>
						<label for="term_slug"><?php _e( 'Slug', 'yith-woocommerce-advanced-product-options' ) ?>:
							<input type="text" name="term_slug" id="term_slug" value="">
						</label>
						<label for="term_value"><?php _e( 'Value', 'yith-woocommerce-advanced-product-options' ); ?>:
							<input type="text" name="term_value" id="term_value" value="" data-type="label">
						</label>
						<label for="term_tooltip"><?php _e( 'Tooltip', 'yith-woocommerce-advanced-product-options' ); ?>:
							<input type="text" name="term_tooltip" id="term_tooltip" value="">
						</label>
					</fieldset>
				</form>
			</div>

			<?php

			echo ob_get_clean();
		}

		/**
		 * Ajax action to add new attribute terms
		 *
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function yith_wccl_add_new_attribute_ajax() {

			if( ! isset( $_POST['taxonomy'] ) || ! isset( $_POST['term_name'] ) || ! isset( $_POST['term_value'] ) ) {
				die();
			}

			$tax     = esc_attr( $_POST['taxonomy'] );
			$term    = wc_clean( $_POST['term_name'] );
			$slug    = wc_clean( $_POST['term_slug'] );
			$value   = wc_clean( $_POST['term_value'] );
			$tooltip = wc_clean( $_POST['term_tooltip'] );
			$args    = array();

			if( $value == '' ) {
				wp_send_json( array(
					'error' => __( 'A value is required for this term', 'yith-woocommerce-advanced-product-options' )
				) );
			}

			if ( taxonomy_exists( $tax ) ) {

				if( $slug ) {
					$args['slug'] = $slug;
				}
				// insert term
				$result = wp_insert_term( $term, $tax, $args );

				if ( is_wp_error( $result ) ) {
					wp_send_json( array(
						'error' => $result->get_error_message()
					) );
				}
				else {
					$term = get_term_by( 'id', $result['term_id'], $tax );

					// add value
					update_woocommerce_term_meta( $term->term_id, $tax . '_yith_wccl_value', $value );
					if( $tooltip ) {
						update_woocommerce_term_meta( $term->term_id, $tax . '_yith_wccl_tooltip', $tooltip );
					}

					wp_send_json( array(
						'term_id' => $term->term_id,
						'name'    => $term->name,
						'slug'    => $term->slug
					) );
				}
			}

			die();

		}

	}
}
/**
 * Unique access to instance of YITH_WCCL_Admin class
 *
 * @return \YITH_WCCL_Admin
 * @since 1.0.0
 */
function YITH_WCCL_Admin(){
	return YITH_WCCL_Admin::get_instance();
}