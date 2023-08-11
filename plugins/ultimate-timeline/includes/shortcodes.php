<?php

add_shortcode('timeline', 'timeline_shortcode');

function timeline_shortcode($atts) {

	$error = _('<p class="timeline-error">Please Enter the shorcode in the format <b>[timeline id=548]</b>. Remember to replace the number with correct post id.</p>');
	if( !isset($atts['id']) ) { return $error; }
	
	$timeline_id   = $atts['id'];
	$timeline      = new TimelineInitialize($timeline_id);
	$data          = $timeline->merge;

	$title_count   = get_field(TITLE_COUNT, $timeline_id);
	$content_count = get_field(CONTENT_COUNT, $timeline_id);

	$options = get_option('timeline_basics');
	
	// Print Dynamic Styles
	$output  = timeline_dynamic_styles();
	$output .= timeline_dynamic_icons();

	$output .= '<div id="timeline-' .$timeline_id. '" class="ut-timeline" data-loadposts="' .$options['per_load']. '" data-loadmethod="' .$options['load_more_method']. '" data-titlecount="' .$title_count. '" data-contentcount="' .$content_count. '">';
	$output .= '<div class="ut-timeline-begin">';
	$output .= '<span class="begin-text">' .get_field(BEGIN_TEXT, $timeline_id). '</span>';
	$output .= '</div><!-- END .ut-timeline-begin -->';

	$output .= '<div class="ut-timeline-content">';
	$output .= '<ul class="ut-timeline-ulist">';
	
	$count = 0;
	foreach($data as $key => $value) :	
	++$count;

	if(($value['type'] == 'post') && (empty($value['excerpt']))) { $value['excerpt'] = $options['default_content']; }

	if($value['type'] == 'tweet') { $value["title"] = $options['tweet_title']; }

	$output .= '<li class="ut-timeline-list-item ' .timeline_odd_even($count). '">';
	$output .= '<div class="ut-timeline-col1">';
	$output .= '<p class="ut-timeline-date">';

	//Ago Time
	if(get_field('time_ago', $timeline_id) == 'enable') {
		$output .= timeline_time_ago( $value['time'] );
	}  //Custom Time Format
	else {
		$output .= date(get_field('time_format', $timeline_id) ,$value["time"]);

		if( $options['display_time'] == 'yes') :
			$output .= ' - ' . date('h:i A' ,$value["time"]);
		endif;
	}

	$output .= '</p>';	
	$output .= '</div><!-- END .ut-timeline-col1 -->';

	$output .= '<div class="ut-timeline-col2">';
	$output .= '<div class="ut-timeline-text-wrap">';
	$output .= get_timeline_icons($value, $timeline_id);

	$output .= '<div class="ut-timeline-text-wrap-inner">';
	if( ($options['link_titles'] == 'yes') && $value['type'] == 'post') :
		$output .= '<a class="timeline-permalink" href="' .$value['permalink']. '">';
	endif;

	$output .= '<h3 class="ut-timeline-title">' .$value["title"]. '</h3>';

	if( ($options['link_titles'] == 'yes') && $value['type'] == 'post') :
		$output .= '</a>';
	endif;

	$output .= timeline_excerpt( $value, $timeline_id );	
	$output .= '</div><!-- END .ut-timeline-text-wrap-inner -->';
	$output .= '<div class="clear"></div>';
	$output .= '</div><!-- END .ut-timeline-text-wrap -->';
	$output .= '</div><!-- END .ut-timeline-col2 -->';
	$output .= '</li>';
	endforeach;	

	$output .= '</ul>';	
	$output .= '</div><!-- END .ut-timeline-content -->';

	$output .= '<div class="load-more-wrap">';
	$output .= '<span class="timeline-load-more">Load More</span>';
	$output .= '</div>';

	$output .= '<div class="ut-timeline-footer-wrap">';
	$output .= '<div class="ut-timeline-end">';
	$output .= '<span class="end-text">' .get_field(END_TEXT, $timeline_id). '</span>';
	$output .= '</div><!-- END .ut-timeline-end -->';
	
	$output .= '<div class="ut-timeline-footer">';
	$output .= get_field(FOOTER_MESSAGE, $timeline_id);
	$output .= '</div>';
	$output .= timeline_affiliates();
	$output .= '</div>';
	$output .= '</div><!-- END .ut-timeline -->';

	return $output;
}


function timeline_excerpt($data, $timeline_id) {

	if( $data['type'] == 'dribbble' ) {

		if( get_field('enable_dribbble_thumbnail', $timeline_id) != 'no' ) :
			$output  = '<a class="thumbnail-wrap" href="' .$data['permalink']. '">';
			$output .= '<img src="' .$data['thumbnail']. '" class="dribbble-thumb"/>';
			$output .= '</a>';
		endif;	
		
		$output .= '<p class="ut-timeline-text">';
		$output .= $data['excerpt'];
		$output .='</p>';

		return $output;
	}

	if( $data['type'] == 'instagram' ) {

		$output  = '<a class="thumbnail-wrap" href="' .$data['permalink']. '" target="blank">';
		$output .= '<img src="' .$data['thumbnail']. '" class="instagram-thumb"/>';
		$output .= '</a>';
		$output .= '<p class="ut-timeline-text">';
		$output .= $data['excerpt'];
		$output .='</p>';

		return $output;
	}


	if( $data['type'] == 'facebook' ) {

		$output = '';

		if( get_field('facebook_thumbnail', $timeline_id) == 'yes' && isset($data['thumbnail']) ) : 

		$output  = '<a class="thumbnail-wrap" href="' .$data['permalink']. '" target="_blank">';
		$output .= '<img src="' .$data['thumbnail']. '" class="facebook-thumb"/>';
		$output .= '</a>';

		endif;

		$output .= '<p class="ut-timeline-text">';
		$output .= $data['excerpt'];
		$output .='</p>';

		return $output;
	}


	if( $data['type'] == 'post' ) {

		$output = '';

		if( get_field('enable_post_thumbnail', $timeline_id) == 'yes' && has_post_thumbnail( $data['id'] ) ) : 

		$url = wp_get_attachment_thumb_url( get_post_thumbnail_id( $data['id'] ) );

		$output  = '<a class="thumbnail-wrap" href="' .$data['permalink']. '">';
		$output .= '<img src="' .$url. '" class="post-thumb"/>';
		$output .= '</a>';

		endif;

		$output .= '<p class="ut-timeline-text">';
		$output .= $data['excerpt'];
		$output .='</p>';

		return $output;
	}

	$output .= '<p class="ut-timeline-text">';
	$output .= $data['excerpt'];
	$output .='</p>';

	return $output;
}


function timeline_title() {

}