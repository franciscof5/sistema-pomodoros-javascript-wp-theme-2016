<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
/****************************************************************************************/
add_action('widgets_init', 'magcast_widgets_init');
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function magcast_widgets_init()
{
	// Registering Header add sidebar
	register_sidebar(array(
		'name' => __('Header Sidebar', 'magcast') ,
		'id' => 'magcast_headeradd_sidebar',
		'description' => __('Show TH: Advertisement widget beside Site Logo/Title.', 'magcast') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	// Registering Magazine Page template Primary
	register_sidebar(array(
		'name' => __('Magazine Template Primary', 'magcast') ,
		'id' => 'magcast_magazine_template_primary',
		'description' => __('Shows widgets on Magazine Page Template. Suitable widget: TH: Horizontal Vertical Post, TH: Two Column Category Post, TH: Two Column Grid, TH: Two Column Large Image', 'magcast') ,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	// Registering Magazine Page template Secondary
	register_sidebar(array(
		'name' => __('Magazine Template Secondary', 'magcast') ,
		'id' => 'magcast_magazine_template_secondary',
		'description' => __('Shows widgets on Magazine Page Template. Suitable widget: TH: Horizontal Vertical Post, TH: Two Column Category Post, TH: Two Column Grid, TH: Two Column Large Image', 'magcast') ,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	// Registering main left sidebar
	register_sidebar(array(
		'name' => __('Left Sidebar', 'magcast') ,
		'id' => 'magcast_left_sidebar',
		'description' => __('Shows widgets at Left side.', 'magcast') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	// Registering main right sidebar
	register_sidebar(array(
		'name' => __('Right Sidebar', 'magcast') ,
		'id' => 'magcast_right_sidebar',
		'description' => __('Shows widgets at Right side.', 'magcast') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	// Registering contact Page sidebar
	register_sidebar(array(
		'name' => __('Contact Template Sidebar', 'magcast') ,
		'id' => 'magcast_contact_page_sidebar',
		'description' => __('Shows widgets on Contact Page Template.', 'magcast') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	/**
	 * Registering footer sidebar 1
	 * For upgrade compatible reason footer id not kept magcast_footer_column1
	 */
	register_sidebar(array(
		'name' => __('Footer - Column1', 'magcast') ,
		'id' => 'magcast_footer_sidebar',
		'description' => __('Shows widgets at footer Column 1.', 'magcast') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	// Registering footer sidebar 2
	register_sidebar(array(
		'name' => __('Footer - Column2', 'magcast') ,
		'id' => 'magcast_footer_column2',
		'description' => __('Shows widgets at footer Column 2.', 'magcast') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	// Registering footer sidebar 3
	register_sidebar(array(
		'name' => __('Footer - Column3', 'magcast') ,
		'id' => 'magcast_footer_column3',
		'description' => __('Shows widgets at footer Column 3.', 'magcast') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	// Registering widgets
	register_widget("magcast_advertisement_widget");
	register_widget("magcast_two_column_largeimage_widget");
	register_widget("magcast_horizontal_vertical_widget");
	register_widget("magcast_two_column_category_widget");
	register_widget("magcast_two_column_grid_widget");
}

/****************************************************************************************/
/**
 * Widget for magazine that shows selected page content,title and featured image.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class magcast_two_column_largeimage_widget extends WP_Widget

{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_2_column_large_image clearfix',
			'description' => __('Display Two Column Large Image (Magazine Template)', 'magcast')
		);
		$control_ops = array(
			'width' => 200,
			'height' => 250
		);
		parent::__construct(false, $name = __('TH: Two Column Large Image', 'magcast') , $widget_ops, $control_ops);
	}
	function form($instance)
	{

		$instance = wp_parse_args((array)$instance, array(
			'magcast_title' => '', 'magcast_link'=>'', 'magcast_date' => false, 'magcast_author' => false, 'magcast_category' =>'', 'magcast_number' => 2
		));
		$magcast_title = esc_attr($instance['magcast_title']);
		$magcast_link = esc_url($instance['magcast_link']);
		$magcast_date = absint($instance['magcast_date']);
		$magcast_author = absint($instance['magcast_author']);
		$magcast_category = esc_attr($instance['magcast_category']);
		$magcast_number = (int)$instance['magcast_number']; ?>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_number'); ?>">
					<?php esc_html_e('Number of Post:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_number'); ?>" name="<?php echo $this->get_field_name('magcast_number'); ?>" type="text" value="<?php echo (int)$magcast_number; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'magcast_date' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['magcast_date'] ); ?> id="<?php echo $this->get_field_id( 'magcast_date' ); ?>" name="<?php echo $this->get_field_name( 'magcast_date' ); ?>" />
				<?php esc_html_e( 'Hide Date', 'magcast' ); ?>
			</label>
			&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id( 'magcast_author' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['magcast_author'] ); ?> id="<?php echo $this->get_field_id( 'magcast_author' ); ?>" name="<?php echo $this->get_field_name( 'magcast_author' ); ?>" />
				<?php esc_html_e( 'Hide Author', 'magcast' ); ?>
			</label>
		</p>
		<hr>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_title'); ?>">
					<?php esc_html_e('Title:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_title'); ?>" name="<?php echo $this->get_field_name('magcast_title'); ?>" type="text" value="<?php echo esc_attr($magcast_title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_link'); ?>">
					<?php esc_html_e('Link:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_link'); ?>" name="<?php echo $this->get_field_name('magcast_link'); ?>" type="text" value="<?php echo esc_url($magcast_link); ?>" />
		</p>
			<label for="<?php
			echo $this->get_field_id('magcast_category'); ?>">
							<?php
			esc_html_e('Category', 'magcast'); ?>
						:</label>
						<?php
			wp_dropdown_categories(array(
				'show_option_none' => ' ',
				'name' => $this->get_field_name('magcast_category') ,
				'selected' => $instance['magcast_category' ]
			)); ?>
			<hr>
		<?php
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['magcast_title'] = esc_attr($new_instance['magcast_title']);
		$instance['magcast_link'] = esc_url($new_instance['magcast_link']);
		$instance['magcast_date'] = magcast_sanitize_checkbox($new_instance['magcast_date']);
		$instance['magcast_author'] = magcast_sanitize_checkbox($new_instance['magcast_author']);
		$instance['magcast_category'] = esc_attr($new_instance['magcast_category']);
		$instance['magcast_number'] = (int)$new_instance['magcast_number'];
		return $instance;
	}
	function widget($args, $instance)
	{
		extract($args);
		extract($instance);
		global $post;
		$magcast_title = isset( $instance[ 'magcast_title' ] ) ? $instance[ 'magcast_title' ] : '';
		$magcast_link = isset( $instance[ 'magcast_link' ] ) ? $instance[ 'magcast_link' ] : '';
		$magcast_date = isset( $instance[ 'magcast_date' ] ) ? $instance[ 'magcast_date' ] : false;
		$magcast_author = isset( $instance[ 'magcast_author' ] ) ? $instance[ 'magcast_author' ] : false;
		$magcast_category = isset( $instance[ 'magcast_category' ] ) ? $instance[ 'magcast_category' ] : '';
		$magcast_number = isset( $instance[ 'magcast_number' ] ) ? $instance[ 'magcast_number' ] : '';
		$get_featured_pages = new WP_Query(array(
			'posts_per_page' => $magcast_number,
			'post_type' => array(
				'post'
			) ,
			'category__in' => $magcast_category,
		));
		echo $before_widget;
		$i=1;
			if(!empty($magcast_title)){ ?>
				<h2 class="widget-title"><a href="<?php echo esc_url($magcast_link); ?>" title="<?php echo esc_attr($magcast_title); ?>"><?php echo esc_attr($magcast_title); ?></a></h2>
			<?php } ?>
		<div class="owl-carousel clearfix">
		<?php while ($get_featured_pages->have_posts()):
			$get_featured_pages->the_post(); ?>
			<article <?php post_class('col'); ?>>
				<?php if ( has_post_thumbnail() ) { ?>
				<figure class="post-featured-image">
					<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail('magcast-large-thumb'); ?></a>
					<span class="cat-links">
						<?php do_action( 'magcast_post_categories' ); ?>
					</span>
				</figure><!-- .post-featured-image -->
				<?php } ?>
				<h2 class="entry-title">
					<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
				</h2><!-- .entry-title -->
				<?php if(($magcast_date == false) || ($magcast_author == false)){ ?>
					<div class="entry-meta clearfix">
						<?php if($magcast_date == false){ ?>
							<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div>
						<?php } 
						 if($magcast_author == false){?>
							<div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>"><?php the_author(); ?> </a></div>
						<?php } ?>
					</div><!-- .entry-meta -->
				<?php } ?>
			</article><!-- .post .col -->
		<?php
		endwhile;
		// Reset Post Data
		wp_reset_query(); ?>
		</div><!-- .owl-carousel -->
		<?php
		echo $after_widget . '<!--.widget_2_column_large_image -->';
	}
}

/****************************************************************************************/
/**
 * Widget for magazine that shows selected page content,title and featured image.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class magcast_advertisement_widget extends WP_Widget

{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_add_size_728x90',
			'description' => __('Display Advertisement', 'magcast')
		);
		$control_ops = array(
			'width' => 200,
			'height' => 250
		);
		parent::__construct(false, $name = __('TH: Advertisement', 'magcast') , $widget_ops, $control_ops);
	}
	function form($instance)
	{

		$instance = wp_parse_args((array)$instance, array(
			'magcast_advertisement_image' => '',
			'magcast_advertisement_image_url' => ''
		));
		$magcast_advertisement_image = esc_url($instance['magcast_advertisement_image']);
		$magcast_advertisement_image_url = esc_url($instance['magcast_advertisement_image_url']); ?>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_advertisement_image'); ?>">
				<?php esc_html_e('Image Link:', 'magcast'); ?>
			</label>
			<input type="text" class="upload1" id="<?php echo $this->get_field_id( 'magcast_advertisement_image' ); ?>" name="<?php echo $this->get_field_name('magcast_advertisement_image'); ?>" value="<?php echo esc_url($magcast_advertisement_image); ?>"/>

         <input type="button" class="button  custom_media_button"name="<?php echo $this->get_field_name('magcast_advertisement_image'); ?>" id="custom_media_button_services" value="<?php esc_attr_e('Upload Image','magcast');?>" onclick="mediaupload.uploader( '<?php echo $this->get_field_id( 'magcast_advertisement_image' ); ?>' ); return false;"/>

		</p>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_advertisement_image_url'); ?>">
				<?php esc_html_e('Redirect Url:', 'magcast'); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('magcast_advertisement_image_url'); ?>" name="<?php echo $this->get_field_name('magcast_advertisement_image_url'); ?>" type="text" value="<?php echo $magcast_advertisement_image_url; ?>" />
		</p>
		<?php
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['magcast_advertisement_image'] = esc_url($new_instance['magcast_advertisement_image']);
		$instance['magcast_advertisement_image_url'] = esc_url($new_instance['magcast_advertisement_image_url']);
		return $instance;
	}
	function widget($args, $instance)
	{
		extract($args);
		extract($instance);
		$magcast_advertisement_image = apply_filters('magcast_advertisement_image', empty($instance['magcast_advertisement_image']) ? '' : $instance['magcast_advertisement_image'], $instance, $this->id_base);
		$magcast_advertisement_image_url = apply_filters('magcast_advertisement_image_url', empty($instance['magcast_advertisement_image_url']) ? '' : $instance['magcast_advertisement_image_url'], $instance, $this->id_base);
		echo $before_widget; ?>
		<a href="<?php echo esc_url($magcast_advertisement_image_url); ?>" title="add_size_728x90"><img alt="add_size_728x90" src="<?php echo esc_url($magcast_advertisement_image); ?>"></a>
		<?php echo $after_widget;
	}
} 
/****************************************************************************************/
/**
 * Widget for magazine that shows selected page content,title and featured image.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class magcast_horizontal_vertical_widget extends WP_Widget

{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_horizontal_vertical_post clearfix',
			'description' => __('Display Horizontal Vertical Post (Magazine Template)', 'magcast')
		);
		$control_ops = array(
			'width' => 200,
			'height' => 250
		);
		parent::__construct(false, $name = __('TH: Horizontal Vertical Post', 'magcast') , $widget_ops, $control_ops);
	}
	function form($instance)
	{

		$instance = wp_parse_args((array)$instance, array(
			'magcast_title' => '', 'magcast_link'=>'', 'magcast_date' => false, 'magcast_author' => false, 'magcast_category' =>'', 'magcast_number' => 5, 'magcast_horizontal'=> true, 'magcast_vertical'=> false
		));
		$magcast_title = esc_attr($instance['magcast_title']);
		$magcast_link = esc_url($instance['magcast_link']);
		$magcast_date = absint($instance['magcast_date']);
		$magcast_author = absint($instance['magcast_author']);
		$magcast_category = esc_attr($instance['magcast_category']);
		$magcast_number = (int)$instance['magcast_number'];
		$featured_display = ( isset( $instance['featured_display'] ) && is_numeric( $instance['featured_display'] ) ) ? (int) $instance['featured_display'] : 1; ?>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_number'); ?>">
					<?php esc_html_e('Number of Post:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_number'); ?>" name="<?php echo $this->get_field_name('magcast_number'); ?>" type="text" value="<?php echo (int)$magcast_number; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'magcast_date' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['magcast_date'] ); ?> id="<?php echo $this->get_field_id( 'magcast_date' ); ?>" name="<?php echo $this->get_field_name( 'magcast_date' ); ?>" />
				<?php esc_html_e( 'Hide Date', 'magcast' ); ?>
			</label>
			&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id( 'magcast_author' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['magcast_author'] ); ?> id="<?php echo $this->get_field_id( 'magcast_author' ); ?>" name="<?php echo $this->get_field_name( 'magcast_author' ); ?>" />
				<?php esc_html_e( 'Hide Author', 'magcast' ); ?>
			</label>
		</p>
		<p>
			<legend><?php esc_html_e('Post Display Option:','magcast');?></legend>
			<input type="radio" id="<?php echo ($this->get_field_id( 'featured_display' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'featured_display' )) ?>" value="1" <?php checked( $featured_display == 1, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'featured_display' ) . '-1' ) ?>"><?php esc_html_e('Horizontal', 'magcast') ?></label> 
			&nbsp;&nbsp;&nbsp;
			<input type="radio" id="<?php echo ($this->get_field_id( 'featured_display' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'featured_display' )) ?>" value="2" <?php checked( $featured_display == 2, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'featured_display' ) . '-2' ) ?>"><?php esc_html_e('Vertical', 'magcast') ?></label>
		</p>
		<hr>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_title'); ?>">
					<?php esc_html_e('Title:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_title'); ?>" name="<?php echo $this->get_field_name('magcast_title'); ?>" type="text" value="<?php echo esc_attr($magcast_title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_link'); ?>">
					<?php esc_html_e('Link:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_link'); ?>" name="<?php echo $this->get_field_name('magcast_link'); ?>" type="text" value="<?php echo esc_url($magcast_link); ?>" />
		</p>
			<label for="<?php
			echo $this->get_field_id('magcast_category'); ?>">
							<?php
			esc_html_e('Category', 'magcast'); ?>
						:</label>
						<?php
			wp_dropdown_categories(array(
				'show_option_none' => ' ',
				'name' => $this->get_field_name('magcast_category') ,
				'selected' => $instance['magcast_category' ]
			)); ?>
			<hr>
		<?php
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['magcast_title'] = esc_attr($new_instance['magcast_title']);
		$instance['magcast_link'] = esc_url($new_instance['magcast_link']);
		$instance['magcast_date'] = magcast_sanitize_checkbox($new_instance['magcast_date']);
		$instance['magcast_author'] = magcast_sanitize_checkbox($new_instance['magcast_author']);
		$instance['magcast_category'] = esc_attr($new_instance['magcast_category']);
		$instance['magcast_number'] = (int)$new_instance['magcast_number'];
		$instance['featured_display'] = ( isset( $new_instance['featured_display'] ) && $new_instance['featured_display'] > 0 && $new_instance['featured_display'] < 3 ) ? (int) $new_instance['featured_display'] : 0;
		return $instance;
	}
	function widget($args, $instance)
	{
		extract($args);
		extract($instance);
		global $post;
		$magcast_title = isset( $instance[ 'magcast_title' ] ) ? $instance[ 'magcast_title' ] : '';
		$magcast_link = isset( $instance[ 'magcast_link' ] ) ? $instance[ 'magcast_link' ] : '';
		$magcast_date = isset( $instance[ 'magcast_date' ] ) ? $instance[ 'magcast_date' ] : false;
		$magcast_author = isset( $instance[ 'magcast_author' ] ) ? $instance[ 'magcast_author' ] : false;
		$magcast_category = isset( $instance[ 'magcast_category' ] ) ? $instance[ 'magcast_category' ] : '';
		$magcast_number = isset( $instance[ 'magcast_number' ] ) ? $instance[ 'magcast_number' ] : '';
		$featured_display = ( isset( $instance['featured_display'] ) && is_numeric( $instance['featured_display'] ) ) ? (int) $instance['featured_display'] : 1;
		$get_featured_pages = new WP_Query(array(
			'posts_per_page' => $magcast_number,
			'post_type' => array(
				'post'
			) ,
			'category__in' => $magcast_category,
		));
		echo $before_widget;
		$i=1;
			if(!empty($magcast_title)){ ?>
				<h2 class="widget-title"><a href="<?php echo esc_url($magcast_link); ?>" title="<?php echo esc_attr($magcast_title); ?>"><?php echo esc_attr($magcast_title); ?></a></h2>
			<?php }
				if($featured_display == 1){
					$classes = 'horizontal-post clearfix';
				}else{
					$classes = 'vertical-post widget-column-wrap clearfix';
				} ?>
			<div class="<?php echo esc_attr($classes); ?>">
			<?php  while ($get_featured_pages->have_posts()):
			$get_featured_pages->the_post(); 
				if($i==1){ ?>
					<article <?php post_class('col clearfix'); ?>>
						<?php if ( has_post_thumbnail() ) { ?>
							<div class="post-featured-image-wrap">
								<figure class="post-featured-image">
									<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail('magcast-large-thumb'); ?></a>
									<span class="cat-links">
										<?php do_action( 'magcast_post_categories' ); ?>
									</span>
								</figure><!-- .post-featured-image -->
							</div><!-- .post-featured-image-wrap -->
						<?php } ?>
						<div class="post-featured-content">
							<h2 class="entry-title">
								<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
							</h2><!-- .entry-title -->
							<?php if(($magcast_date == false) || ($magcast_author == false)){ ?>
								<div class="entry-meta clearfix">
									<?php if($magcast_date == false){ ?>
										<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div>
									<?php } 
									 if($magcast_author == false){?>
										<div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>"><?php the_author(); ?> </a></div>
									<?php } ?>
								</div><!-- .entry-meta -->
							<?php } ?>
							<div class="entry-content">
								<?php the_excerpt(); ?>
							</div><!-- .entry-content -->
						</div><!-- .post-featured-content -->
					</article><!-- .post -->
					<div class="thumbnail-post col clearfix">
					<?php } else { ?>
							<div class="single-thumbnail-post">
								<article <?php post_class('clearfix'); ?>>
									<figure class="post-featured-image">
										<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail('magcast-small-thumb'); ?></a>
									</figure><!-- .post-featured-image -->
									<div class="post-featured-content">
										<h2 class="entry-title">
											<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
										</h2><!-- .entry-title -->
										<?php if(($magcast_date == false) || ($magcast_author == false)){ ?>
											<div class="entry-meta clearfix">
												<?php if($magcast_date == false){ ?>
													<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div>
												<?php } 
												 if($magcast_author == false){?>
													<div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>"><?php the_author(); ?> </a></div>
												<?php } ?>
											</div><!-- .entry-meta -->
										<?php } ?>
									</div><!-- .post-featured-content -->
								</article><!-- .post -->
							</div><!-- .single-thumbnail-post -->
					<?php }
					 $i++;
					endwhile;
					// Reset Post Data
				wp_reset_query(); ?>
				</div><!-- .thumbnail-post col -->
			</div><!-- .<?php echo esc_attr($classes); ?> -->
		<?php
		echo $after_widget . '<!--.widget_horizontal_vertical_post -->';
	}
} 
/****************************************************************************************/
/**
 * Widget for magazine that shows selected page content,title and featured image.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class magcast_two_column_category_widget extends WP_Widget

{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_2_column_category widget-column-wrap clearfix',
			'description' => __('Display Two Column Category Post (Magazine Template)', 'magcast')
		);
		$control_ops = array(
			'width' => 200,
			'height' => 250
		);
		parent::__construct(false, $name = __('TH: Two Column Category Post', 'magcast') , $widget_ops, $control_ops);
	}
	function form($instance)
	{

		$instance = wp_parse_args((array)$instance, array(
			'magcast_first_title' => '', 'magcast_first_link'=>'', 'magcast_second_title' => '', 'magcast_second_link'=>'', 'magcast_date' => false, 'magcast_author' => false, 'magcast_category_first' =>'', 'magcast_category_second' =>'', 'magcast_number' => 5
		));
		$magcast_first_title = esc_attr($instance['magcast_first_title']);
		$magcast_second_title = esc_attr($instance['magcast_second_title']);
		$magcast_first_link = esc_url($instance['magcast_first_link']);
		$magcast_second_link = esc_url($instance['magcast_second_link']);
		$magcast_date = absint($instance['magcast_date']);
		$magcast_author = absint($instance['magcast_author']);
		$magcast_category_first = esc_attr($instance['magcast_category_first']);
		$magcast_category_second = esc_attr($instance['magcast_category_second']);
		$magcast_number = (int)$instance['magcast_number']; ?>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_number'); ?>">
					<?php esc_html_e('Number of Post:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_number'); ?>" name="<?php echo $this->get_field_name('magcast_number'); ?>" type="text" value="<?php echo (int)$magcast_number; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'magcast_date' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['magcast_date'] ); ?> id="<?php echo $this->get_field_id( 'magcast_date' ); ?>" name="<?php echo $this->get_field_name( 'magcast_date' ); ?>" />
				<?php esc_html_e( 'Hide Date', 'magcast' ); ?>
			</label>
			&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id( 'magcast_author' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['magcast_author'] ); ?> id="<?php echo $this->get_field_id( 'magcast_author' ); ?>" name="<?php echo $this->get_field_name( 'magcast_author' ); ?>" />
				<?php esc_html_e( 'Hide Author', 'magcast' ); ?>
			</label>
		</p>
		<hr>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_first_title'); ?>">
					<?php esc_html_e('First Column Title:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_first_title'); ?>" name="<?php echo $this->get_field_name('magcast_first_title'); ?>" type="text" value="<?php echo esc_attr($magcast_first_title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_first_link'); ?>">
					<?php esc_html_e('First Column Link:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_first_link'); ?>" name="<?php echo $this->get_field_name('magcast_first_link'); ?>" type="text" value="<?php echo esc_url($magcast_first_link); ?>" />
		</p>
		<p>
			<label for="<?php
			echo $this->get_field_id('magcast_category_first'); ?>">
							<?php
			esc_html_e('First Column Category', 'magcast'); ?>
						:</label>
						<?php
			wp_dropdown_categories(array(
				'show_option_none' => ' ',
				'name' => $this->get_field_name('magcast_category_first') ,
				'selected' => $instance['magcast_category_first' ]
			)); ?>
		</p>
		<hr>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_second_title'); ?>">
					<?php esc_html_e('Second Column Title:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_second_title'); ?>" name="<?php echo $this->get_field_name('magcast_second_title'); ?>" type="text" value="<?php echo esc_attr($magcast_second_title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_second_link'); ?>">
					<?php esc_html_e('Second Column Link:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_second_link'); ?>" name="<?php echo $this->get_field_name('magcast_second_link'); ?>" type="text" value="<?php echo esc_url($magcast_second_link); ?>" />
		</p>
		<p>
			<label for="<?php
			echo $this->get_field_id('magcast_category_second'); ?>">
							<?php
			esc_html_e('Second Column Category', 'magcast'); ?>
						:</label>
						<?php
			wp_dropdown_categories(array(
				'show_option_none' => ' ',
				'name' => $this->get_field_name('magcast_category_second') ,
				'selected' => $instance['magcast_category_second' ]
			)); ?>
		</p>
		<hr>
		<?php
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['magcast_first_title'] = esc_attr($new_instance['magcast_first_title']);
		$instance['magcast_first_link'] = esc_url($new_instance['magcast_first_link']);
		$instance['magcast_second_title'] = esc_attr($new_instance['magcast_second_title']);
		$instance['magcast_second_link'] = esc_url($new_instance['magcast_second_link']);
		$instance['magcast_date'] = magcast_sanitize_checkbox($new_instance['magcast_date']);
		$instance['magcast_author'] = magcast_sanitize_checkbox($new_instance['magcast_author']);
		$instance['magcast_category_first'] = esc_attr($new_instance['magcast_category_first']);
		$instance['magcast_category_second'] = esc_attr($new_instance['magcast_category_second']);
		$instance['magcast_number'] = (int)$new_instance['magcast_number'];
		return $instance;
	}
	function widget($args, $instance)
	{
		extract($args);
		extract($instance);
		global $post;
		$magcast_first_title = isset( $instance[ 'magcast_first_title' ] ) ? $instance[ 'magcast_first_title' ] : '';
		$magcast_first_link = isset( $instance[ 'magcast_first_link' ] ) ? $instance[ 'magcast_first_link' ] : '';
		$magcast_second_title = isset( $instance[ 'magcast_second_title' ] ) ? $instance[ 'magcast_second_title' ] : '';
		$magcast_second_link = isset( $instance[ 'magcast_second_link' ] ) ? $instance[ 'magcast_second_link' ] : '';
		$magcast_date = isset( $instance[ 'magcast_date' ] ) ? $instance[ 'magcast_date' ] : false;
		$magcast_author = isset( $instance[ 'magcast_author' ] ) ? $instance[ 'magcast_author' ] : false;
		$magcast_category_first = isset( $instance[ 'magcast_category_first' ] ) ? $instance[ 'magcast_category_first' ] : '';
		$magcast_category_second = isset( $instance[ 'magcast_category_second' ] ) ? $instance[ 'magcast_category_second' ] : '';
		$magcast_number = isset( $instance[ 'magcast_number' ] ) ? $instance[ 'magcast_number' ] : '';
		$get_featured_category_first = new WP_Query(array(
			'posts_per_page' => $magcast_number,
			'post_type' => array(
				'post'
			) ,
			'category__in' => $magcast_category_first,
		));

		$get_featured_category_second = new WP_Query(array(
			'posts_per_page' => $magcast_number,
			'post_type' => array(
				'post'
			) ,
			'category__in' => $magcast_category_second,
		));
		echo $before_widget;
		$i=1; ?>
		<div class="col">
		<?php	if(!empty($magcast_first_title)){ ?>
				<h2 class="widget-title"><a href="<?php echo esc_url($magcast_first_link); ?>" title="<?php echo esc_attr($magcast_first_title); ?>"><?php echo esc_attr($magcast_first_title); ?></a></h2>
			<?php } ?>
			
			<?php  while ($get_featured_category_first->have_posts()):
			$get_featured_category_first->the_post(); 
				if($i==1){ ?>
					<article <?php post_class(); ?>>
						<?php if ( has_post_thumbnail() ) { ?>
								<figure class="post-featured-image">
									<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail('magcast-large-thumb'); ?></a>
									<div class="entry-header">
										<span class="cat-links">
											<?php do_action( 'magcast_post_categories' ); ?>
										</span>
										<h2 class="entry-title">
											<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
										</h2><!-- .entry-title -->
										<?php if(($magcast_date == false) || ($magcast_author == false)){ ?>
											<div class="entry-meta clearfix">
												<?php if($magcast_date == false){ ?>
													<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div>
												<?php } 
												 if($magcast_author == false){?>
													<div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>"><?php the_author(); ?> </a></div>
												<?php } ?>
											</div><!-- .entry-meta -->
										<?php } ?>
									</div><!-- .entry-header -->
								</figure><!-- .post-featured-image -->
						<?php } ?>
					</article><!-- .post -->
					<div class="thumbnail-post">
					<?php } else {?>
							<article <?php post_class('clearfix'); ?>>
								<figure class="post-featured-image">
									<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail('magcast-small-thumb'); ?></a>
								</figure><!-- .post-featured-image -->
								<div class="post-featured-content">
									<h2 class="entry-title">
										<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
									</h2><!-- .entry-title -->
									<?php if(($magcast_date == false) || ($magcast_author == false)){ ?>
										<div class="entry-meta clearfix">
											<?php if($magcast_date == false){ ?>
												<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div>
											<?php } 
											 if($magcast_author == false){?>
												<div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>"><?php the_author(); ?> </a></div>
											<?php } ?>
										</div><!-- .entry-meta -->
									<?php } ?>
								</div><!-- .post-featured-content -->
							</article><!-- .post -->
					<?php }
					 $i++;
					endwhile;
					// Reset Post Data
				wp_reset_query(); ?>
				</div><!-- .thumbnail-post -->
		</div><!-- .col -->
		<?php
		$j=1; ?>
		<div class="col">
		<?php	if(!empty($magcast_second_title)){ ?>
				<h2 class="widget-title"><a href="<?php echo esc_url($magcast_second_link); ?>" title="<?php echo esc_attr($magcast_second_title); ?>"><?php echo esc_attr($magcast_second_title); ?></a></h2>
			<?php } ?>
			
			<?php  while ($get_featured_category_second->have_posts()):
			$get_featured_category_second->the_post(); 
				if($j==1){ ?>
					<article <?php post_class('clearfix'); ?>>
						<?php if ( has_post_thumbnail() ) { ?>
								<figure class="post-featured-image">
									<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail('magcast-large-thumb'); ?></a>
									<div class="entry-header">
										<span class="cat-links">
											<?php do_action( 'magcast_post_categories' ); ?>
										</span>
										<h2 class="entry-title">
											<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
										</h2><!-- .entry-title -->
										<?php if(($magcast_date == false) || ($magcast_author == false)){ ?>
											<div class="entry-meta clearfix">
												<?php if($magcast_date == false){ ?>
													<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div>
												<?php } 
												 if($magcast_author == false){?>
													<div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>"><?php the_author(); ?> </a></div>
												<?php } ?>
											</div><!-- .entry-meta -->
										<?php } ?>
									</div><!-- .entry-header -->
								</figure><!-- .post-featured-image -->
						<?php } ?>
					</article><!-- .post -->
					<div class="thumbnail-post">
					<?php } else {?>
							<article <?php post_class('clearfix'); ?>>
								<figure class="post-featured-image">
									<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail('magcast-small-thumb'); ?></a>
								</figure><!-- .post-featured-image -->
								<div class="post-featured-content">
									<h2 class="entry-title">
										<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
									</h2><!-- .entry-title -->
									<?php if(($magcast_date == false) || ($magcast_author == false)){ ?>
										<div class="entry-meta clearfix">
											<?php if($magcast_date == false){ ?>
												<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div>
											<?php } 
											 if($magcast_author == false){?>
												<div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>"><?php the_author(); ?> </a></div>
											<?php } ?>
										</div><!-- .entry-meta -->
									<?php } ?>
								</div><!-- .post-featured-content -->
							</article><!-- .post -->
					<?php }
					 $j++;
					endwhile;
					// Reset Post Data
				wp_reset_query(); ?>
				</div><!-- .thumbnail-post -->
		</div><!-- .col -->
		<?php echo $after_widget . '<!-- .widget_2_column_category .widget-column-wrap -->';
	}
}
/****************************************************************************************/
/**
 * Widget for magazine that shows selected page content,title and featured image.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class magcast_two_column_grid_widget extends WP_Widget

{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_2_column_grid clearfix',
			'description' => __('Display Two Column Grid (Magazine Template)', 'magcast')
		);
		$control_ops = array(
			'width' => 200,
			'height' => 250
		);
		parent::__construct(false, $name = __('TH: Two Column Grid', 'magcast') , $widget_ops, $control_ops);
	}
	function form($instance)
	{

		$instance = wp_parse_args((array)$instance, array(
			'title' => '', 'link'=>'', 'magcast_date' => false, 'magcast_author' => false, 'category' =>'', 'magcast_number' => 4, 'hide_title'=>false
		));
		$title = esc_attr($instance['title']);
		$link = esc_url($instance['link']);
		$magcast_date = absint($instance['magcast_date']);
		$magcast_author = absint($instance['magcast_author']);
		$hide_title = absint($instance['hide_title']);
		$category = esc_attr($instance['category']);
		$magcast_number = (int)$instance['magcast_number']; ?>
		<p>
			<label for="<?php echo $this->get_field_id('magcast_number'); ?>">
					<?php esc_html_e('Number of Post:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('magcast_number'); ?>" name="<?php echo $this->get_field_name('magcast_number'); ?>" type="text" value="<?php echo (int)$magcast_number; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'magcast_date' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['magcast_date'] ); ?> id="<?php echo $this->get_field_id( 'magcast_date' ); ?>" name="<?php echo $this->get_field_name( 'magcast_date' ); ?>" />
				<?php esc_html_e( 'Hide Date', 'magcast' ); ?>
			</label>
			&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id( 'magcast_author' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['magcast_author'] ); ?> id="<?php echo $this->get_field_id( 'magcast_author' ); ?>" name="<?php echo $this->get_field_name( 'magcast_author' ); ?>" />
				<?php esc_html_e( 'Hide Author', 'magcast' ); ?>
			</label>
			&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id( 'hide_title' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['hide_title'] ); ?> id="<?php echo $this->get_field_id( 'hide_title' ); ?>" name="<?php echo $this->get_field_name( 'hide_title' ); ?>" />
				<?php esc_html_e( 'Hide Title', 'magcast' ); ?>
			</label>
		</p>
		<hr>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
					<?php esc_html_e('Title:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>">
					<?php esc_html_e('Link:', 'magcast'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_url($link); ?>" />
		</p>
			<label for="<?php
			echo $this->get_field_id('category'); ?>">
							<?php
			esc_html_e('Category', 'magcast'); ?>
						:</label>
						<?php
			wp_dropdown_categories(array(
				'show_option_none' => ' ',
				'name' => $this->get_field_name('category') ,
				'selected' => $instance['category' ]
			)); ?>
			<hr>
		<?php
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = esc_attr($new_instance['title']);
		$instance['link'] = esc_url($new_instance['link']);
		$instance['magcast_date'] = magcast_sanitize_checkbox($new_instance['magcast_date']);
		$instance['magcast_author'] = magcast_sanitize_checkbox($new_instance['magcast_author']);
		$instance['hide_title'] = magcast_sanitize_checkbox($new_instance['hide_title']);
		$instance['category'] = esc_attr($new_instance['category']);
		$instance['magcast_number'] = (int)$new_instance['magcast_number'];
		return $instance;
	}
	function widget($args, $instance)
	{
		extract($args);
		extract($instance);
		global $post;
		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$link = isset( $instance[ 'link' ] ) ? $instance[ 'link' ] : '';
		$magcast_date = isset( $instance[ 'magcast_date' ] ) ? $instance[ 'magcast_date' ] : false;
		$magcast_author = isset( $instance[ 'magcast_author' ] ) ? $instance[ 'magcast_author' ] : false;
		$hide_title = isset( $instance[ 'hide_title' ] ) ? $instance[ 'hide_title' ] : false;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$magcast_number = isset( $instance[ 'magcast_number' ] ) ? $instance[ 'magcast_number' ] : '';
		$get_featured_pages = new WP_Query(array(
			'posts_per_page' => $magcast_number,
			'post_type' => array(
				'post'
			) ,
			'category__in' => $category,
		));
		echo $before_widget;
		$i=1;
			if(!empty($title)){ ?>
				<h2 class="widget-title"><a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>"><?php echo esc_attr($title); ?></a></h2>
			<?php } ?>
		<div class="widget-column-wrap clearfix">
		<?php while ($get_featured_pages->have_posts()):
			$get_featured_pages->the_post(); ?>
			<article <?php post_class('col'); ?>>
				<?php if ( has_post_thumbnail() ) { ?>
				<figure class="post-featured-image">
					<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail('magcast-small-thumb'); ?></a>
					<span class="cat-links">
						<?php do_action( 'magcast_post_categories' ); ?>
					</span>
				</figure><!-- .post-featured-image -->
				<?php } 
				if($hide_title == false){ ?>
					<h2 class="entry-title">
						<a title="<?php the_title(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
					</h2><!-- .entry-title -->
				<?php }
				if(($magcast_date == false) || ($magcast_author == false)){ ?>
					<div class="entry-meta clearfix">
						<?php if($magcast_date == false){ ?>
							<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div>
						<?php } 
						 if($magcast_author == false){?>
							<div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>"><?php the_author(); ?> </a></div>
						<?php } ?>
					</div><!-- .entry-meta -->
				<?php } ?>
			</article><!-- .post .col -->
		<?php endwhile;
		// Reset Post Data
		wp_reset_query(); ?>
		</div><!--.widget-column-wrap -->
		<?php
		echo $after_widget . '<!--.widget_2_column_grid -->';
	}
}?>