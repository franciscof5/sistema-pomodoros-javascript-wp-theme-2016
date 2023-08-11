<?php

class TimelineFacebook {

	public $data;

	public $args;

	public $options;

	public function __construct( $args = array() ) {

		if( empty($args['access_token']) ) { $args['access_token'] = '674499912621593|BSs-w-7ZilZJ9z-H-Oyk_jHTV1g'; }

		$this->args = $args;

		$this->options = get_option('timeline_basics');

		$this->get_cache($args);
	}



	/**
	 * [verify_cache description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_cache($args) {

		$transient_key = TRANSIENT_KEY_FB . '_' . $args['timeline_id'];

		$cache = get_transient($transient_key);

		if( $cache && $this->validation($cache, $args)) { 

			$this->data = $cache; 
			return;
		}

		$this->set_cache($args);
		
	}


	public function validation($cache, $args) {

		if( $cache->page_id != $args['page_id'] ) return false;
		if( $cache->refresh != $args['refresh_cache'] ) return false;
		if( $cache->title   != $this->options['facebook_title'] ) return false;
		if( $cache->count   != $args['post_count'] ) return false;
		return true;
	}



	public function set_cache($args) {

		$transient_key = TRANSIENT_KEY_FB . '_' . $args['timeline_id'];

		$response = $this->fetch($args);


		$refresh_cache = $args['refresh_cache'];
		$expiration = 60 * $refresh_cache;
		set_transient( $transient_key, $response, $expiration );	
		$this->data = $response;   
	}

	public function fetch($args) {

		$options = get_option('timeline_basics');

		$obj = new stdClass;
		

		$obj->page_id = $args['page_id'];
		$obj->refresh = $args['refresh_cache'];
		$obj->title = $this->options['facebook_title'];
		$obj->count = ($args['post_count']) ? $args['post_count'] : 10; 

		$obj->data = array();

		$feed_url = "https://graph.facebook.com/{$args['page_id']}/feed?access_token={$args['access_token']}&limit={$obj->count}";

		if(is_callable('curl_init')){
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $feed_url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        $feedData = curl_exec($ch);
	        curl_close($ch);
	    //If not then use file_get_contents
	    }

		$FBdata = json_decode($feedData);

		if( isset($FBdata->error) ) return;


		//var_dump($FBdata);
		$data = $FBdata->data;


		foreach( $data as $key ) {

			if( !isset($key->message) ) continue;

			$obj->data[] =	array(
					'title'      => $this->options['facebook_title'],
					'permalink'  => $key->link,
					'excerpt'    => $this->filter_facebook($key->message),
					'time'       => strtotime($key->created_time),
					'type'       => 'facebook',
					'thumbnail'  => $key->picture
				);
		}

		return $obj;

	}

	public function filter_facebook($data) {
		$data = preg_replace('/(http[^\s]+)/im', '<a target = "_blank" href="$1">$1</a>', $data);
		$data= preg_replace_callback('/(\#w*[a-zA-Z_]+\w*)/', create_function(
					'$matches',
        	        'return \'<a class="timeline-facebook-link facebook-hashtag" target="_blank" href="https://www.facebook.com/hashtag/\'.urlencode(str_replace("#", "", $matches[1])).\'">\'.utf8_encode($matches[1]).\'</a>\';'
    				),
    			$data);
		return $data;
	}
	
}