<?php

/* #######################################################################

	Register Sidebars for Widgets

####################################################################### */

if ( function_exists('register_sidebar') )
	register_sidebar(array(
			'name' => __( 'Footer Widget Area', 'meanthemes' ),
			'before_widget' => '<div class="widget footer">',
			'after_widget' => '</div>',
			'before_title' => '<h6>',
			'after_title' => '</h6>',
			'id' => 'sidebar-1',
		));


if ( function_exists('register_sidebar') )
	register_sidebar(array(
			'name' => __( 'Sidebar Widget Area', 'meanthemes' ),
			'before_widget' => '<div class="widget sidebar">',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
			'id' => 'sidebar-2',
		));

if ( function_exists('register_sidebar') )
	register_sidebar(array(
			'name' => __( 'Sidebar Widget Area (Page)', 'meanthemes' ),
			'before_widget' => '<div class="widget sidebar">',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
			'id' => 'sidebar-3',
		));

if ( function_exists('register_sidebar') )
	register_sidebar(array(
			'name' => __( 'Social Footer Widget Area - w`p`l`o`c`k`e`r`.`c`o`m', 'meanthemes' ),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '',
			'after_title' => '',
			'id' => 'sidebar-4',
		));


 /**
  * Plugin Name: MeanThemes Social Widget
  * Description: Add your social links.
  * Version: 0.1
  * Author: MeanThemes
  * Author URI: http://meanthemes.com
  */


 add_action( 'widgets_init', 'my_widget' );


 function my_widget() {
 	register_widget( 'MY_Widget' );
 }

 class MY_Widget extends WP_Widget {

 	function __construct() {
 		$widget_ops = array( 'classname' => 'meanthemes', 'description' => __('Add your social links. ', 'meanthemes') );

 		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'meanthemes-widget' );

 		parent::__construct( 'meanthemes-widget', __('MeanThemes Social Widget', 'meanthemes'), $widget_ops, $control_ops );
 	}

 	function widget( $args, $instance ) {
 		extract( $args );

 		//Our variables from the widget settings.
 		$title = $instance['title'];
 		$description = $instance['description'];
 		$twitter = $instance['twitter'];
 		$facebook = $instance['facebook'];
 		$linkedin = $instance['linkedin'];
 		$googleplus = $instance['googleplus'];
 		$zerply = $instance['zerply'];
 		$vimeo = $instance['vimeo'];
 		$youtube = $instance['youtube'];
 		$pinterest = $instance['pinterest'];
 		$dribbble = $instance['dribbble'];
 		$github = $instance['github'];
 		$instagram = $instance['instagram'];
 		$flickr = $instance['flickr'];
 		$adn = $instance['adn'];
 		$behance = $instance['behance'];
 		$tumblr = $instance['tumblr'];
 		$lastfm = $instance['lastfm'];
 		$soundcloud = $instance['soundcloud'];
 		$mixcloud = $instance['mixcloud'];
 		$spotify = $instance['spotify'];
 		$xing = $instance['xing'];
 		$foursquare = $instance['foursquare'];
 		$rss = $instance['rss'];
 		$open_new = isset( $instance['open_new'] ) ? $instance['open_new'] : false;
 		$white = isset( $instance['white'] ) ? $instance['white'] : false;

 		echo $before_widget;

 		// Display the widget title
 		if ( $title )
 			echo $before_title . $title . $after_title;

		// Display the widget title
		if ( $description )
			echo '<p>' . $description . '</p>';

		$open = "";
		if ( $open_new )
			$open = ' target="_blank"';

		$white_icon = "";
		if ( $white )
			$white_icon = ' white';

		echo '<div class="socials">';

 		//Display the socials
 		if ( $twitter )
 			printf( '<a class="social twitter' . $white_icon .'" href="' . $twitter . '"' . $open . '>' . __('Twitter', 'meanthemes') . '</a>' );

 		if ( $facebook )
 			printf( '<a class="social facebook' . $white_icon .'" href="' . $facebook . '"' . $open . '>' . __('Facebook', 'meanthemes') . '</a>' );

 		if ( $linkedin )
 			printf( '<a class="social linkedin' . $white_icon .'" href="' . $linkedin . '"' . $open . '>' . __('LinkedIn', 'meanthemes') . '</a>' );

 		if ( $googleplus )
 			printf( '<a class="social googleplus' . $white_icon .'" href="' . $googleplus . '"' . $open . '>' . __('Google+', 'meanthemes') . '</a>' );

 		if ( $zerply )
 			printf( '<a class="social zerply' . $white_icon .'" href="' . $zerply . '"' . $open . '>' . __('Zerply', 'meanthemes') . '</a>' );

 		if ( $vimeo )
 			printf( '<a class="social vimeo' . $white_icon .'" href="' . $vimeo . '"' . $open . '>' . __('Vimeo', 'meanthemes') . '</a>' );

 		if ( $youtube )
 			printf( '<a class="social youtube' . $white_icon .'" href="' . $youtube . '"' . $open . '>' . __('YouTube', 'meanthemes') . '</a>' );

 		if ( $pinterest )
 			printf( '<a class="social pinterest' . $white_icon .'" href="' . $pinterest . '"' . $open . '>' . __('Pinterest', 'meanthemes') . '</a>' );

 		if ( $dribbble )
 			printf( '<a class="social dribbble' . $white_icon .'" href="' . $dribbble . '"' . $open . '>' . __('Dribbble', 'meanthemes') . '</a>' );

 		if ( $github )
 			printf( '<a class="social github' . $white_icon .'" href="' . $github . '"' . $open . '>' . __('Github', 'meanthemes') . '</a>' );

 		if ( $instagram )
 			printf( '<a class="social instagram' . $white_icon .'" href="' . $instagram . '"' . $open . '>' . __('Instagram', 'meanthemes') . '</a>' );

 		if ( $flickr )
 			printf( '<a class="social flickr' . $white_icon .'" href="' . $flickr . '"' . $open . '>' . __('Flickr', 'meanthemes') . '</a>' );

 		if ( $adn )
 			printf( '<a class="social adn' . $white_icon .'" href="' . $adn . '"' . $open . '>' . __('App.Net', 'meanthemes') . '</a>' );

 		if ( $behance )
 			printf( '<a class="social behance' . $white_icon .'" href="' . $behance . '"' . $open . '>' . __('Behance', 'meanthemes') . '</a>' );

 		if ( $tumblr )
 			printf( '<a class="social tumblr' . $white_icon .'" href="' . $tumblr . '"' . $open . '>' . __('Tumblr', 'meanthemes') . '</a>' );

 		if ( $lastfm )
 			printf( '<a class="social lastfm' . $white_icon .'" href="' . $lastfm . '"' . $open . '>' . __('Last.fm', 'meanthemes') . '</a>' );

 		if ( $soundcloud )
 			printf( '<a class="social soundcloud' . $white_icon .'" href="' . $soundcloud . '"' . $open . '>' . __('SoundCloud', 'meanthemes') . '</a>' );

 		if ( $mixcloud )
 			printf( '<a class="social mixcloud' . $white_icon .'" href="' . $mixcloud . '"' . $open . '>' . __('MixCloud', 'meanthemes') . '</a>' );

 		if ( $spotify )
 			printf( '<a class="social spotify' . $white_icon .'" href="' . $spotify . '"' . $open . '>' . __('Spotify', 'meanthemes') . '</a>' );

 		if ( $xing )
 			printf( '<a class="social xing' . $white_icon .'" href="' . $xing . '"' . $open . '>' . __('Xing', 'meanthemes') . '</a>' );
		if ( $foursquare )
			printf( '<a class="social foursquare' . $white_icon .'" href="' . $foursquare . '"' . $open . '>' . __('Foursquare', 'meanthemes') . '</a>' );

		if ( $rss )
			printf( '<a class="social rss' . $white_icon .'" href="' . $rss . '"' . $open . '>' . __('rss', 'meanthemes') . '</a>' );

		echo '</div>';

 		echo $after_widget;
 	}

 	//Update the widget

 	function update( $new_instance, $old_instance ) {
 		$instance = $old_instance;

 		//Strip tags from title and name to remove HTML

 		$instance['title'] = strip_tags( $new_instance['title'] );
 		$instance['description'] = strip_tags( $new_instance['description'] );
 		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
 		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
 		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
 		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );
 		$instance['zerply'] = strip_tags( $new_instance['zerply'] );
 		$instance['vimeo'] = strip_tags( $new_instance['vimeo'] );
 		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
 		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
 		$instance['dribbble'] = strip_tags( $new_instance['dribbble'] );
 		$instance['github'] = strip_tags( $new_instance['github'] );
 		$instance['instagram'] = strip_tags( $new_instance['instagram'] );
 		$instance['flickr'] = strip_tags( $new_instance['flickr'] );
 		$instance['adn'] = strip_tags( $new_instance['adn'] );
 		$instance['behance'] = strip_tags( $new_instance['behance'] );
 		$instance['tumblr'] = strip_tags( $new_instance['tumblr'] );
 		$instance['lastfm'] = strip_tags( $new_instance['lastfm'] );
 		$instance['soundcloud'] = strip_tags( $new_instance['soundcloud'] );
 		$instance['mixcloud'] = strip_tags( $new_instance['mixcloud'] );
 		$instance['spotify'] = strip_tags( $new_instance['spotify'] );
 		$instance['xing'] = strip_tags( $new_instance['xing'] );
 		$instance['foursquare'] = strip_tags( $new_instance['foursquare'] );
 		$instance['rss'] = strip_tags( $new_instance['rss'] );
 		$instance['open_new'] = $new_instance['open_new'];
 		$instance['white'] = $new_instance['white'];


 		return $instance;
 	}


 	function form( $instance ) {

 		//Set up some default widget settings.
 		$defaults = array(
	 		"title" => "",
	 		"description" => "",
	 		"twitter" => "",
	 		"facebook" => "",
	 		"linkedin" => "",
	 		"googleplus" => "",
	 		"zerply" => "",
	 		"vimeo" => "",
	 		"youtube" => "",
	 		"pinterest" => "",
	 		"dribbble" => "",
	 		"github" => "",
	 		"instagram" => "",
	 		"flickr" => "",
	 		"adn" => "",
	 		"behance" => "",
	 		"tumblr" => "",
	 		"lastfm" => "",
	 		"soundcloud" => "",
	 		"mixcloud" => "",
	 		"spotify" => "",
	 		"xing" => "",
	 		"foursquare" => "",
	 		"rss" => "",
	 		'open_new' => false,
	 		'white' => false
 		);
 		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

 		<?php //Widget Title: Text Input. ?>

 		<p><em><?php _e('Please add Full URLs e.g. http://twitter.com/getmeanthemes','meanthemes'); ?></em></p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
 		</p>


 		<?php //Text Input. ?>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Description:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" value="<?php echo $instance['description']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Facebook:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('LinkedIn:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $instance['linkedin']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'googleplus' ); ?>"><?php _e('Google+:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'googleplus' ); ?>" name="<?php echo $this->get_field_name( 'googleplus' ); ?>" value="<?php echo $instance['googleplus']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'zerply' ); ?>"><?php _e('Zerply:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'zerply' ); ?>" name="<?php echo $this->get_field_name( 'zerply' ); ?>" value="<?php echo $instance['zerply']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e('Vimeo:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" value="<?php echo $instance['vimeo']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e('YouTube:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="<?php echo $instance['youtube']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e('Pinterest:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" value="<?php echo $instance['pinterest']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'dribbble' ); ?>"><?php _e('Dribbble:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo $instance['dribbble']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'github' ); ?>"><?php _e('Github:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" value="<?php echo $instance['github']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e('Instagram:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" value="<?php echo $instance['instagram']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'flickr' ); ?>"><?php _e('Flickr:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" value="<?php echo $instance['flickr']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'adn' ); ?>"><?php _e('App.Net:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'adn' ); ?>" name="<?php echo $this->get_field_name( 'adn' ); ?>" value="<?php echo $instance['adn']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'behance' ); ?>"><?php _e('Behance:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'behance' ); ?>" name="<?php echo $this->get_field_name( 'behance' ); ?>" value="<?php echo $instance['behance']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'tumblr' ); ?>"><?php _e('Tumblr:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" value="<?php echo $instance['tumblr']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'lastfm' ); ?>"><?php _e('LastFM:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'lastfm' ); ?>" name="<?php echo $this->get_field_name( 'lastfm' ); ?>" value="<?php echo $instance['lastfm']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'soundcloud' ); ?>"><?php _e('SoundCloud:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'soundcloud' ); ?>" name="<?php echo $this->get_field_name( 'soundcloud' ); ?>" value="<?php echo $instance['soundcloud']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'mixcloud' ); ?>"><?php _e('MixCloud:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'mixcloud' ); ?>" name="<?php echo $this->get_field_name( 'mixcloud' ); ?>" value="<?php echo $instance['mixcloud']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'spotify' ); ?>"><?php _e('Spotify:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'spotify' ); ?>" name="<?php echo $this->get_field_name( 'spotify' ); ?>" value="<?php echo $instance['spotify']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'xing' ); ?>"><?php _e('Xing:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'xing' ); ?>" name="<?php echo $this->get_field_name( 'xing' ); ?>" value="<?php echo $instance['xing']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'foursquare' ); ?>"><?php _e('Foursquare:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'foursquare' ); ?>" name="<?php echo $this->get_field_name( 'foursquare' ); ?>" value="<?php echo $instance['foursquare']; ?>" style="width:100%;" />
 		</p>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e('RSS:', 'meanthemes'); ?></label>
 			<input id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="<?php echo $instance['rss']; ?>" style="width:100%;" />
 		</p>

 		<?php //Checkbox. ?>
 		<p>
 			<input class="checkbox" type="checkbox" <?php if ( ( $instance['open_new'] ) === "on" ) { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'open_new' ); ?>" name="<?php echo $this->get_field_name( 'open_new' ); ?>" />
 			<label for="<?php echo $this->get_field_id( 'open_new' ); ?>"><?php _e('Open links in new window?', 'meanthemes'); ?></label>
 		</p>

 		<p>
 			<input class="checkbox" type="checkbox" <?php if ( ( $instance['white'] ) === "on" ) { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'white' ); ?>" name="<?php echo $this->get_field_name( 'white' ); ?>" />
 			<label for="<?php echo $this->get_field_id( 'white' ); ?>"><?php _e('Use white icons?', 'meanthemes'); ?></label>
 		</p>

 	<?php
 	}
 }



?>
