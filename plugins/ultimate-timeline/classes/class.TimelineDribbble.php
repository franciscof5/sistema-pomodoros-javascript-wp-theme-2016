<?php
$path = UT_PATH . '/includes/Dribbble/Api/Client.php';
include_once($path);

class TimelineDribbble {

	public $args;

	public $options;

	public $data;

	public function __construct( $args = array() ) {
		
		$this->args = $args;

		$this->get_cache( $args );

		$this->options = get_option( 'timeline_basics' );
		
	}

	public function get_cache( $args ) {
		$transient_key = TRANSIENT_KEY_DRIBBBLE . '_' . $args['timeline_id'];  

		$cache = get_transient( $transient_key );

		if( $cache && $this->validation( $cache, $args )  ) {
			$this->data = $cache;
			return;
		}

		$this->set_cache( $args );
		
	}

	public function validation( $cache, $args ) {
		$this->options = get_option('timeline_basics' );
		if( $cache->player_name 			!= $args['player_name'] ) return false;
		if( $cache->dribbble_post_count 	!= $args['dribbble_post_count'] ) return false;
		if( $cache->dribbble_refresh_cache 	!= $args['dribbble_refresh_cache'] ) return false;
		if( $cache->dribbble_title 			!= $this->options['dribbble_title']) return false;
		return true;
	}

	public function set_cache( $args ) {
		$transient_key = TRANSIENT_KEY_DRIBBBLE . '_' .$args['timeline_id'];

		$response = $this->fetch_content( $args );

		$dribbble_refresh_cache = $args['dribbble_refresh_cache'];
		$expiration = 60 * $dribbble_refresh_cache;
		set_transient( $transient_key, $response, $expiration );
		$this->data = $response;
	}

	public function fetch_content( $args ) {

		

		$obj = new stdClass;
		$options 						= get_option('timeline_basics');
		$obj->player_name 				= $args['player_name'];
		$obj->dribbble_post_count 		= $args['dribbble_post_count'];
		$obj->dribbble_refresh_cache 	= $args['dribbble_refresh_cache'];
		$obj->dribbble_title 			= $options['dribbble_title'];

		$obj->data = array();

		$counter = 0;
		$max_posts = $args['dribbble_post_count'];

		$client = new Dribbble_api_client();
		$shots = $client->getPlayerShots($args['player_name']);

		foreach ($shots->shots as $shot) {

			if(++$counter > $max_posts) break;

			$obj->data[]  = array(
								'title' 	  => $shot->title,
								'permalink'   => $shot->url,
								'excerpt'     => strip_tags($shot->description, '<a>'),
								'time'        => strtotime($shot->created_at),
								'type'        => 'dribbble',
								'thumbnail'   => $shot->image_teaser_url,
								'image'       => $shot->image_url,
							);
	    }

		return $obj;
	}

}