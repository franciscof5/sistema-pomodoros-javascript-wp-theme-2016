<?php

class TimelinePosts {

	public $args = array();
	public $posts;

	/**
	 * [__construct description]
	 * @param array $parameters [description]
	 * array1 = args
	 * array2 = 
	 */
	function __construct( $parameters = array() ) {
		$this->args   = $parameters['args'];

		$this->query_post($this->args);
	}

	public function query_post($args) {
		
		$loop = new WP_Query($args);

		$posts = new stdClass;
		$posts->posts = array();

		if( $loop->have_posts() ) :
			while( $loop->have_posts() ) :
			$loop->the_post();
				$posts->posts[] = array(
									'title'      => get_the_title(),
									'permalink'  => get_permalink(),
									'excerpt'    => get_the_excerpt(),
									'time'       => strtotime(get_the_time('c')),
									'type'       => 'post',
									'id'		 => get_the_ID(),
								);
				
 			endwhile;	
		endif;	
		
		$this->posts = $posts;
		//var_dump($posts);die;
		wp_reset_postdata();
	}
}