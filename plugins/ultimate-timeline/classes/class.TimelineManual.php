<?php

class TimelineManual {

	public $parameters = array();

	public $status;

	public function __construct($args) {
		$this->parameters = $args;

		$this->status = $this->query_status();
	}

	public function query_status() {
		$status = new stdClass; 
		$status->data = array(); 
		
		// check if the repeater field has rows of data
		if( have_rows('status_update', $this->parameters['post_id']) ):
		    while ( have_rows('status_update', $this->parameters['post_id']) ) : the_row();
				$status->data[] = array(
									'title'              => get_sub_field('status_title', $this->parameters['post_id']),
									'permalink'          => '',
									'excerpt'            => get_sub_field('status_description', $this->parameters['post_id']),
									//'time'               => (int) substr(get_sub_field('status_date', $this->parameters['post_id']), 0, -3),
									'time'               => get_sub_field('status_date', $this->parameters['post_id']),
									'type'               => 'status',
									'custom_icon'		 => get_sub_field('custom_icon', $this->parameters['post_id']),
									'icon'				 => get_sub_field('image', $this->parameters['post_id']),
									'fontawsome'		 => get_sub_field('fontawesome', $this->parameters['post_id']),

					            );
		 
		    endwhile;
		endif;
		//var_dump($status);
		//die;
		return $status;
	}
}

