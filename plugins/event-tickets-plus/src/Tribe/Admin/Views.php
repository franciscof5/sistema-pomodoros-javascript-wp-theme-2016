<?php
/**
 * Class Tribe__Tickets_Plus__Admin__Views
 */
class Tribe__Tickets_Plus__Admin__Views extends Tribe__Template {
	/**
	 * Building of the Class template configuration
	 *
	 * @since  TBD
	 */
	public function __construct() {
		$this->set_template_origin( Tribe__Tickets_Plus__Main::instance() );
		$this->set_template_folder( 'src/admin-views' );

		// Configures this templating class extract variables
		$this->set_template_context_extract( true );
	}
}