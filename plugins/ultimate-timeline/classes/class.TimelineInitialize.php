<?php 

class TimelineInitialize {

	public $twitter;
	public $posts;
	public $manual;
	public $facebook;
	public $dribbble;
	public $instagram;

	public $timeline_id;

	public $feed_expiration;

	public $merge;

	public function __construct($timeline_id) {
		
		$this->timeline_id = $timeline_id;	

		$this->feed_expiration = get_field('refresh_feed', $timeline_id);

		$this->init_actions();
		$this->merge();
		return true;
	}

	// Query Twitter API / WP Transient
	private function ipix_query_twitter() {

		if( get_field(DISPLAY_TWEETS, $this->timeline_id) == 'no' ) return false;

		$connection    = get_option('timeline_connection');

		$credentials   = array(
						'consumer_key'    => $connection['consumer_key'],
						'consumer_secret' => $connection['consumer_secret'],
						'user_token'      => $connection['user_token'],
						'user_secret'     => $connection['user_secret'] 
						);

		$params        = array( 
				        'feed_expiration' => $this->feed_expiration,
				        'timeline_id'     => $this->timeline_id
				        );

		$twitter       = new TimelineTwitter($credentials, $params);

		$this->twitter = $twitter->twitter_obj;
	}

	// Query WP Posts
	private function ipix_query_posts($id) {
		
		if( get_field(DISPLAY_POSTS, $id) == 'no' ) return false;

		$posts = new TimelinePosts(array(
			'args' => array(
						'posts_per_page' => get_field(MAX_POSTS, $id),
						'category__in'   => get_field(POST_CATS, $id),
						'post__not_in'	 => excluded_posts(EXCLUDE_POSTS, $id),
						'author'         => included_authors(POST_AUTHORS, $id),
						'tag__in'        => get_field(POST_TAGS, $id)
					   )
		));
		
		$this->posts = $posts->posts;
	}

	// Query STATUS Updates
	private function ipix_query_updates($id) {

		if( get_field(DISPLAY_STATUS, $id) == 'no' ) return false;
		
		$args = array(
					'post_id' => $id
			    );
		$manual = new TimelineManual($args);
		$this->manual = $manual->status;
	} 
	// Facebook Posts
	private function ipix_facebook_posts($id) {

		$value = get_field(DISPLAY_FB_POSTS, $id);
		
		if( get_field(DISPLAY_FB_POSTS, $id) == 'no' ) return false;

		$connection    = get_option('timeline_connection');

		$args = array(
			'appId'         => $connection['fb_app_id'],
			'secret'        => $connection['fb_consumer_secret'],
			'access_token'  => $connection['fb_access_token'],
			'page_id'       => get_field(FACEBOOK_PAGE_ID, $id),
			'post_count'    => get_field(POST_COUNT, $id),
			'refresh_cache' => get_field(REFRESH_CACHE, $id),
			'timeline_id'   => $id

		);

		$obj = new TimelineFacebook($args);
		$this->facebook = $obj->data;
	}
	
	//Dribbble Posts
	private function ipix_dribbble_posts($id) {//var_dump(get_field(DRIBBBLE_POST_COUNT, $id));die;
		$value = get_field( DISPLAY_DRIBBBLE_POSTS, $id );
		if( $value == 'no' ) return false;
		$args = array(
			'player_name' 			 => get_field(PLAYER_NAME, $id),
			'dribbble_post_count' 	 => get_field(DRIBBBLE_POST_COUNT, $id),
			'dribbble_refresh_cache' => get_field(DRIBBBLE_REFRESH_CACHE, $id),
			'timeline_id' 			 => $id
		);


		$obj = new TimelineDribbble($args);
		$this->dribbble = $obj->data;
	}


	private function ipix_query_instagram($id) {

		if( get_field(DISPLAY_INSTAGRAM, $this->timeline_id) == 'no' ) return false;

		$connection    = get_option('timeline_connection');

		$args  = array(
						'client_id'    				=> $connection['instagram_client_id'],
						'client_secret' 			=> $connection['instagram_client_secret'],
						'instagram_access_token'	=> $connection['instagram_access_token'],
						'instagram_name'	 		=> get_field('instagram_name', $id),
						'instagram_post_count' 		=> get_field(INSTAGRAM_POST_COUNT, $id),
						'instagram_refresh_cache' 	=> get_field(INSTAGRAM_REFRESH_CACHE, $id),
						'timeline_id' 			 	=> $id
						);

		if ( !$args['instagram_access_token'] ) return false;

		$obj = new TimelineInstagram($args);

		$this->instagram = $obj->data;
	}

	public function init_actions() {
		$this->ipix_query_twitter();
		$this->ipix_query_posts($this->timeline_id);
		$this->ipix_query_updates($this->timeline_id);
		$this->ipix_facebook_posts($this->timeline_id);
		$this->ipix_dribbble_posts($this->timeline_id);
		$this->ipix_query_instagram($this->timeline_id);
	}



	public function merge() {
		
		$twitter_obj   = $this->twitter;
		$posts_obj     = $this->posts;
		$manual_obj    = $this->manual;
		$facebook_obj  = $this->facebook;
		$dribbble_obj  = $this->dribbble;
		$instagram_obj = $this->instagram;

		$combine = array();

		if( $twitter_obj  ) { $combine[] = $twitter_obj->tweets; }
		if( $posts_obj    ) { $combine[] = $posts_obj->posts; }
		if( $manual_obj   ) { $combine[] = $manual_obj->data; }
		if( $facebook_obj ) { $combine[] = $facebook_obj->data; }
		if( $dribbble_obj ) { $combine[] = $dribbble_obj->data; }
		if( $instagram_obj ) { $combine[] = $instagram_obj->data; }
		
		$merge = array();
		$time  = array();

		foreach($combine as $data => $key) {
			foreach ($key as $assoc => $arr) {
				$merge[] = $arr;
			}
		}

		// SORT BY TIMESTAMP
		foreach ($merge as $key => $val) {
		    $time[$key] = $val['time'];
		}

		if( get_field('order', $this->timeline_id) == 'ascending' ) :
			array_multisort($time, SORT_ASC, $merge);	
		else :
			array_multisort($time, SORT_DESC, $merge);
		endif;

		$this->merge = $merge;
		return $this->merge;
	}
	
}