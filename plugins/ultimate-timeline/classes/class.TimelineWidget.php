<?php

class TimelineWidget extends WP_Widget {

	function __construct() {

		$params = array(
					'description' => 'Widget for the Timeline',
					'name'		  => 'Timeline Widget'
			);
		parent::__construct('TimelineWidget', '', $params);
	}

	public function form($instance) {
		extract($instance);

	?>
	<p>
		<label for="<?php echo $this->get_field_id('title') ;?>">Title:</label>	
		<input type="text" class="widefat"
		id="<?php echo $this->get_field_id('title') ;?>"
		name="<?php echo $this->get_field_name('title') ;?>"
		value="<?php if(isset($title)) echo esc_attr($title) ;?>"
		/>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('title') ;?>">Choose Timeline:</label>	
		<select 
			name="<?php echo $this->get_field_name('time_line') ;?>"
			id="<?php echo $this->get_field_id('time_line') ;?>">
			<?php 

				$args = array(
							'post_type' => 'timeline'
						);

				$loop = new WP_Query($args);

				if( $loop->have_posts() ) :

					while( $loop->have_posts() ) : $loop->the_post();
						?><option <?php if(get_the_ID() == $time_line ) echo 'selected'; ?> value="<?php the_ID(); ?>"><?php the_title(); ?></option><?php
					endwhile;

				else :
					
					?> <option value="">-No Timeline Found-</option><?php	

				endif;

				wp_reset_postdata();
			?>
		</select>
	</p>

	<?php

	}


	public function widget($args,$instance) {

		extract($args);
		extract($instance);
		echo $before_widget;
		
		echo $before_title.$title.$after_title;
	
   		echo do_shortcode("[timeline id=$time_line]" ); 
   
	    echo $after_widget;
	}
}

add_action('widgets_init', 'ipix_register_timeline_widget');

function ipix_register_timeline_widget() {

	register_widget('TimelineWidget');
}

