<?php

/* #######################################################################

	Styles & Scripts

####################################################################### */

function meanthemes_col_one_third( $atts, $content = null ) {
	return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'meanthemes_col_one_third');

function meanthemes_col_one_third_last( $atts, $content = null ) {
	return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'meanthemes_col_one_third_last');

function meanthemes_col_two_third( $atts, $content = null ) {
	return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'meanthemes_col_two_third');

function meanthemes_col_two_third_last( $atts, $content = null ) {
	return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'meanthemes_col_two_third_last');

function meanthemes_col_one_half( $atts, $content = null ) {
	return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'meanthemes_col_one_half');

function meanthemes_col_one_half_last( $atts, $content = null ) {
	return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'meanthemes_col_one_half_last');

function meanthemes_col_one_fourth( $atts, $content = null ) {
	return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'meanthemes_col_one_fourth');

function meanthemes_col_one_fourth_last( $atts, $content = null ) {
	return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fourth_last', 'meanthemes_col_one_fourth_last');

function meanthemes_col_three_fourth( $atts, $content = null ) {
	return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'meanthemes_col_three_fourth');

function meanthemes_col_three_fourth_last( $atts, $content = null ) {
	return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fourth_last', 'meanthemes_col_three_fourth_last');

function meanthemes_col_one_fifth( $atts, $content = null ) {
	return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'meanthemes_col_one_fifth');

function meanthemes_col_one_fifth_last( $atts, $content = null ) {
	return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fifth_last', 'meanthemes_col_one_fifth_last');

function meanthemes_col_two_fifth( $atts, $content = null ) {
	return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'meanthemes_col_two_fifth');

function meanthemes_col_two_fifth_last( $atts, $content = null ) {
	return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_fifth_last', 'meanthemes_col_two_fifth_last');

function meanthemes_col_three_fifth( $atts, $content = null ) {
	return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'meanthemes_col_three_fifth');

function meanthemes_col_three_fifth_last( $atts, $content = null ) {
	return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fifth_last', 'meanthemes_col_three_fifth_last');

function meanthemes_col_four_fifth( $atts, $content = null ) {
	return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'meanthemes_col_four_fifth');

function meanthemes_col_four_fifth_last( $atts, $content = null ) {
	return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('four_fifth_last', 'meanthemes_col_four_fifth_last');

function meanthemes_col_one_sixth( $atts, $content = null ) {
	return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'meanthemes_col_one_sixth');

function meanthemes_col_one_sixth_last( $atts, $content = null ) {
	return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_sixth_last', 'meanthemes_col_one_sixth_last');

function meanthemes_col_five_sixth( $atts, $content = null ) {
	return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'meanthemes_col_five_sixth');

function meanthemes_col_five_sixth_last( $atts, $content = null ) {
	return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('five_sixth_last', 'meanthemes_col_five_sixth_last');

function meanthemes_clear( $atts, $content = null ) {
	return '<div class="clear">' . do_shortcode($content) . '</div>';
}
add_shortcode('clear', 'meanthemes_clear');

function meanthemes_status_ok( $atts, $content = null ) {
	return '<div class="status ok">' . do_shortcode($content) . '</div>';
}
add_shortcode('status_ok', 'meanthemes_status_ok');

function meanthemes_status_oops( $atts, $content = null ) {
	return '<div class="status oops">' . do_shortcode($content) . '</div>';
}
add_shortcode('status_oops', 'meanthemes_status_oops');

function meanthemes_status_lessoops( $atts, $content = null ) {
	return '<div class="status less-oops">' . do_shortcode($content) . '</div>';
}
add_shortcode('status_lessoops', 'meanthemes_status_lessoops');

function meanthemes_highlight( $atts, $content = null ) {
	return '<span class="highlight">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight', 'meanthemes_highlight');

function button( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'url' => '#',
	'target' => '_self',
	'style' => 'grey',
	'size' => 'small'
	), $atts));

	return '<a target="'.$target.'" class="button '.$size.' '.$style.'" href="'.$url.'">' . do_shortcode($content) . '</a>';
}
add_shortcode('button', 'button');

function bullets( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'style' => 'green',
	'type' => 'tick'
	), $atts));

	return '<div class="bullets '.$type.' '.$style.'">' . do_shortcode($content) . '</div>';
}
add_shortcode('bullets', 'bullets');

function toggle( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'title'    	 => 'Title goes here',
		'state'		 => 'open'
    ), $atts));

	return "<div data-id='".$state."' class=\"toggle\"><span class=\"toggle-title\">". $title ."</span><div class=\"toggle-inner\">". do_shortcode($content) ."</div></div>";
}
add_shortcode('toggle', 'toggle');


function tabs( $atts, $content = null ) {
	$defaults = array();
	extract( shortcode_atts( $defaults, $atts ) );
	
	preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
	
	$tab_titles = array();
	if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
	
	$output = '';
	
	if( count($tab_titles) ){
	    $output .= '<div id="tabs-'. rand(1, 100) .'" class="mt-tabs"><div class="tab-inner">';
		$output .= '<ul class="nav clearfix">';
		
		foreach( $tab_titles as $tab ){
			$output .= '<li><a href="#'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
		}
	    
	    $output .= '</ul>';
	    $output .= do_shortcode( $content );
	    $output .= '</div></div>';
	} else {
		$output .= do_shortcode( $content );
	}
	
	return $output;
}
add_shortcode( 'tabs', 'tabs' );

function tab( $atts, $content = null ) {
	$defaults = array( 'title' => 'Tab' );
	extract( shortcode_atts( $defaults, $atts ) );
	
	return '<div id="'. sanitize_title( $title ) .'" class="tab">'. do_shortcode( $content ) .'</div>';
}
add_shortcode( 'tab', 'tab' );

function quote( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'source' => 'Source here',
	'rating' => '5',
	'style' => ''
	), $atts));

	return '<div class="quotemark ' . $style . '">' . do_shortcode($content) . '<div class="quote-source">'. $source . '</div><div class="quote-rating-'. $rating .'"></div></div>';
}
add_shortcode('quote', 'quote');

function social( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'url' => '#',
	'target' => '_self',
	'site' => '',
	'style' => 'black'
	), $atts));

	return '<a target="'.$target.'" class="social '.$site.' '.$style.'" href="'.$url.'">' . do_shortcode($content) . '</a>';
}
add_shortcode('social', 'social');


function meanthemes_insert( $atts, $content = null ) {
	return '<div class="mt-insert">' . do_shortcode($content) . '</div>';
}
add_shortcode('insert', 'meanthemes_insert');

?>