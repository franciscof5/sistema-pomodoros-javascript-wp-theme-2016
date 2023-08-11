<?php
/**
 * Main class
 *
 * @author Yithemes
 * @package YITH WooCommerce Color and Label Variations Premium
 * @version 1.0.0
 */


if ( ! defined( 'YITH_WAPO' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCCL' ) ) {
	/**
	 * YITH WooCommerce Color and Label Variations Premium
	 *
	 * @since 1.0.0
	 */
	class YITH_WCCL {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCCL
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_WAPO_VERSION;


		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WFBT
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
		 * @return mixed YITH_WCCL_Admin | YITH_WCCL_Frontend
		 * @since 1.0.0
		 */
		public function __construct() {

			// Class admin
			if ( is_admin() ) {
				YITH_WCCL_Admin();
			}

			YITH_WCCL_Frontend();
		}
	}
}

/**
 * Unique access to instance of YITH_WCCL class
 *
 * @return \YITH_WCCL
 * @since 1.0.0
 */
function YITH_WCCL(){
	return YITH_WCCL::get_instance();
}