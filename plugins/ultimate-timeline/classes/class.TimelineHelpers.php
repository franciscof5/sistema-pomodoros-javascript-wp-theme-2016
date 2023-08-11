<?php 

class TimelineHelpers {

	public $timeline_connection = array();
	public $timeline_basics;
	public $timeline_appearance;

	public function __construct() {

		add_action( 'init', array($this, 'multisite_verify') );
		
	}

	public function timeline_activation() {

		$this->verify_database();

	}

	public function verify_database() {

		$this->after_update_defaults();

		// Check If Options Exists in database
		if( get_option('timeline_connection') && get_option('timeline_basics') && get_option('timeline_appearance')) return;

		$this->register_default_options();
		

	}

	public function register_default_options() {
		$this->timeline_connection_defaults();
		$this->timeline_basics_defaults();
		$this->timeline_appearance_defaults();

		update_option( 'timeline_connection', $this->timeline_connection );
		update_option( 'timeline_basics', $this->timeline_basics );
		update_option( 'timeline_appearance', $this->timeline_appearance );
	}

	public function timeline_connection_defaults() {
		$this->timeline_connection = array(
			'consumer_key'    => '',
			'consumer_secret' => '',
			'user_token'      => '',
			'user_secret'     => ''
			);
	}

	public function timeline_basics_defaults() {
		$this->timeline_basics = array(
			'tweet_title'      	 => 'Tweets!',
			'default_content'  	 => 'Text For No Post Content',
			'per_load'         	 => '10',
			'link_titles'      	 => 'yes',
			'load_more_method' 	 => 'scroll',
			'tweet_icon'       	 => 'yes',
			'facebook_icon'	   	 => 'yes',
			'dribbble_icon'    	 => 'yes',
			'tweet_icon_file'  	 => '',
		    'dribbble_icon_file' => '',
			'post_icon'        	 => 'yes',
			'post_icon_file'   	 => '',
			'status_icon'      	 => 'yes',
			'status_icon_file' 	 => '',
			'affiliate_link'   	 => 'yes',
			'affiliate_id'     	 => '',
			);	
	}

	public function timeline_appearance_defaults() {
		$this->timeline_appearance = array(
			'default_css'          => 'yes',
			'background_color'     => '',
			'sepereator'           => '',
			'sepereator_dots'      => '',
			'text_container_bg'    => '',
			'title_color'          => '',
			'content_color'        => '',
			'links_color'          => '',
			'date_color'           => '',
			'footer_bg'            => '',
			'begin_end_text_color' => '',
			'begin_end_text_bg'    => ''
			);
	}

	function multisite_verify() {

		if( !is_multisite() ) return;

		$this->verify_database();
	}

	function after_update_defaults() {


		// Defaults For Timeline Basics
		$timeline_basics = get_option('timeline_basics');

		if( $timeline_basics ) :

			if( !isset( $timeline_basics['dribbble_icon'] ) ) { $timeline_basics['dribbble_icon'] = 'yes'; }

		endif;	
		update_option('timeline_basics', $timeline_basics );

	}
}

new TimelineHelpers;