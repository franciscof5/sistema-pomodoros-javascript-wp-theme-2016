<?php

class TimelineInstagram {

	public $options;

	public $args;

	public $data;

	public function __construct( $args = array() ) {

		$this->args = $args;

		$this->get_cache($args);

		$this->options = get_option( 'timeline_basics' );
	}

	public function get_cache($args) {

		$transient_key = TRANSIENT_KEY_INSTAGRAM . '_' . $args['timeline_id'];

		$cache = get_transient( $transient_key );

		if( $cache && $this->validation( $cache, $args )  ) {
			$this->data = $cache;
			return;
		}

		$this->set_cache( $args );
	}


	public function validation( $cache, $args ) {

		if( $cache->name 			!= $args['instagram_name'] ) return false;
		if( $cache->post_count 		!= $args['instagram_post_count'] ) return false;
		if( $cache->refresh_cache 	!= $args['instagram_refresh_cache'] ) return false;
		if( $cache->title 			!= $this->options['instagram_title']) return false;

		return true;
	}


	public function set_cache($args) {

		$transient_key = TRANSIENT_KEY_INSTAGRAM . '_' .$args['timeline_id'];

		$response = $this->fetch_insta_pics( $args );

		$instagram_refresh_cache = $args['instagram_refresh_cache'];
		$expiration = 60 * $instagram_refresh_cache;
		set_transient( $transient_key, $response, $expiration );
		$this->data = $response;
	}

	public function fetch_insta_pics($args) {

		$username     		 = $args['instagram_name'];
        $access_token 		 = $args['instagram_access_token'];

        $obj                 = new stdClass;
        $obj->data           = array();
        
        $userID              = $this->userID($username, $access_token);

        if( !$userID ) return;

        $instagram 			 = $this->userMedia($userID, $access_token, $username); 

        $timeline_basics 	 = get_option( 'timeline_basics' );
        $title 				 = $timeline_basics['instagram_title'];
        $insta_name 		 = $args['instagram_name'];
        $count 				 = $args['instagram_post_count']; // number of images to show
        $refresh_cache 		 = $args['instagram_refresh_cache'];

        $i = 0; 

        foreach ($instagram['data'] as $vm) : 
            if($count == $i) break;
            $i++;

            $img  = $vm['images']['low_resolution']['url'];
            $link = $vm["link"];
            $time = $vm["created_time"];

            $obj->data[]  = array(
								'title' 	  	=> $title,
								'permalink'   	=> $link,
								'excerpt'     	=> '',
								'time'        	=> $time,
								'type'        	=> 'instagram',
								'thumbnail'   	=> $img,
								'image'       	=> $img,
								'name'			=> $insta_name,
								'post_count'  	=> $count,
								'refresh_cache' => $refresh_cache  		  
							);

        endforeach;
        return $obj;

	}

	public function userID($username, $access_token) {

    	$username = strtolower($username); // sanitization
	    $url      = "https://api.instagram.com/v1/users/search?q=".$username."&access_token=".$access_token;
	    $get      = file_get_contents($url);
	    
	    if( !$get ) return;

	    $json     = json_decode($get);

	    foreach($json->data as $user){
	        if($user->username == $username){
	            return $user->id;
	        }
	    }

	    return '00000000'; // return this if nothing is found
    }

    public function userMedia($userID, $access_token, $username){

    	$url     = 'https://api.instagram.com/v1/users/'.$this->userID($username, $access_token).'/media/recent/?access_token='.$access_token;

    	$content = file_get_contents($url);
		  return $json = json_decode($content, true);
    }

}