<?php

class TimelineTwitter {

	public $consumer_key;
	public $consumer_secret;
	public $user_token;
	public $user_secret;

	public $connection;

	public $expiration;
	public $timeline_id;

	public $transient_key;

	// Store Tweets / Username / Tweets number temporarily is transient unavailable
	public $twitter_obj;

	// HTTP Code Returned By API
	public $http_code;

	public $twitter_path;

	// set up parameters to pass
	public $parameters = array();

	public function __construct( $credentials = array(), $params = array() ) {
		$this->consumer_key    = $credentials['consumer_key']; 
		$this->consumer_secret = $credentials['consumer_secret']; 
		$this->user_token      = $credentials['user_token']; 
		$this->user_secret     = $credentials['user_secret']; 


		$this->expiration = $params['feed_expiration'];
		$this->timeline_id = $params['timeline_id'];

		$this->transient_key = TRANSIENT_KEY . '_' . $params['timeline_id'];


		$this->parameters();
		$this->get_cache();
	}

	public function validation() {

	}

	public function validate_cache($object) {
		if( !$object ) return;

		if(isset($object->username)) {
			if($object->username !== $this->parameters['screen_name']) {
				delete_transient($this->transient_key);
				$this->get_recent_cache();
				return true;
			}
		}

		if(isset($object->tweet_count)) {
			if($object->tweet_count !== $this->parameters['count']) {
				delete_transient($this->transient_key);
				$this->get_recent_cache();
				return true;
			}
			
		}	

		if(isset($object->tweets)) {
			if($object->tweets[0]['title'] !== TWITTER_TITLE) {
				delete_transient($this->transient_key);
				$this->get_recent_cache();
				return true;
			}
		}	
	}

	public function set_cache() {
		$this->validation();
		$this->connection = $this->connection();
		
		$this->fetch_tweets();
		return $this->twitter_obj;
	}

	public function get_cache() {
		$tweets = get_transient($this->transient_key);
		$validation = $this->validate_cache($tweets);

		if( $validation == true ) return;

		if( !$tweets ) {  $this->get_recent_cache(); return; }

		$this->twitter_obj = $tweets;
	}

	public function get_recent_cache() {
		$tweets_obj = $this->set_cache();
	}

	private function connection() {
		return new TimelinetmhOAuth(array(
		  'consumer_key'    => $this->consumer_key,
		  'consumer_secret' => $this->consumer_secret,
		  'user_token'      => $this->user_token, //access token
		  'user_secret'     => $this->user_secret //access token secret
		));
	} 

	public function parameters() {

			$this->parameters['count']       =  get_field(TWEET_COUNT, $this->timeline_id);
			$this->parameters['screen_name'] =  get_field(TWITTER_USER, $this->timeline_id);
		 	$this->twitter_path              = TWITTER_PATH;
	}

	public function request_code() {
		$connection = $this->connection;
		$this->http_code = $connection->request('GET', $connection->url($this->twitter_path), $this->parameters );
		$this->response();
	}

	public function response() {
		$connection = $this->connection;
		if ($this->http_code === 200) { // if everything's good
			$response = strip_tags($connection->response['response']);
		 	$this->process($response);
		 	update_option( 'timeline_connection_error', $this->http_code );
		} else {
			update_option( 'timeline_connection_error', $this->http_code );
		}
	}

	public function process($response) {
		$tweets = json_decode($response);

		// In Case API Returns an Error
		if( isset($tweets->error) ) return false;

		$data = new stdClass();

		if( isset($this->parameters['screen_name']) ) { $data->username = $this->parameters['screen_name']; }
		if( isset($this->parameters['count']) ) { $data->tweet_count = $this->parameters['count']; }

		$data->tweets = array();
		//$data->time = array();

		foreach( $tweets as $tweet ) {   

			$data->tweets[] = array(
			                    'title'     => TWITTER_TITLE,
			                    'permalink' => '',
								'excerpt'   => $this->filter_tweets($tweet->text),
			 					'time'      => strtotime($tweet->created_at),
			 					'type'	    => 'tweet'
			           		  );
		}

		$transient  = $this->transient_key;
		$expiration = 60 * $this->expiration;

		set_transient( $transient, $data, $expiration );

		$this->twitter_obj = $data;
	}

	public function fetch_tweets() {
		$this->request_code();
	}

	public function filter_tweets($tweet) {
		$tweet = preg_replace('/[^(\x20-\x7F)]*/','', $tweet);
		$tweet = preg_replace('/(http[^\s]+)/i', '<a class="timeline-tweet-link twitter-link" target="_blank" href="$1">$1</a>', $tweet);
		$tweet = preg_replace_callback('/(\#w*[a-zA-Z_]+\w*)/', create_function(
					'$matches',
        	        'return \'<a class="timeline-tweet-link twitter-hashtag" target="_blank" href="https://twitter.com/search?q=\'.urlencode($matches[1]).\'">\'.$matches[1].\'</a>\';'
    				),
    			$tweet);
		$tweet = preg_replace_callback('/(@[A-Za-z0-9_]{1,15})/', create_function(
					'$matches',
        	        'return \'<a class="timeline-tweet-link twitter-username" target="_blank" href="http://www.twitter.com/\'.str_replace("@", "", $matches[1]).\'">\'.$matches[1].\'</a>\';'
    				),
    			$tweet);
		//$tweet = preg_replace('/(@[A-Za-z0-9_]{1,15})/', '<a class="timeline-tweet-link twitter-username" target="_blank" href="http://www.twitter.com/$1">$1</a>', $tweet);
		

		return $tweet;
	}

}