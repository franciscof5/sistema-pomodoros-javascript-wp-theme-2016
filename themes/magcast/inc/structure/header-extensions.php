<?php
/**
 * Adds header structures.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 * @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link http://themehorse.com/themes/magcast
 */
/****************************************************************************************/
add_action('magcast_view_port', 'magcast_viewport', 5);
/**
 * Add meta tags.
 */
function magcast_viewport() { ?>
		<meta name="viewport" content="width=device-width">
<?php
}
/****************************************************************************************/
add_action('magcast_header', 'magcast_headercontent_details', 10);
/**
 * Shows Header content details
 *
 * Shows the site logo, title, description, searchbar, social icons and many more
 */
function magcast_headercontent_details() { 
	global $magcast_settings;
	$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults() );
	$magcast_header_image = get_header_image();
	if (!empty($magcast_header_image)):?>
		<a href="<?php echo esc_url(home_url('/'));?>"><img src="<?php echo esc_url($magcast_header_image);?>" class="header-image" width="<?php echo get_custom_header()->width;?>" height="<?php echo get_custom_header()->height;?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display'));?>"> 
		</a>
	<?php endif; ?>
	<header id="masthead" class="site-header" role="banner">
		<?php
		if($magcast_settings['magcast_hide_infobar'] ==0){
			if ( has_nav_menu( 'left-section' ) || ($magcast_settings['magcast_hide_date'] ==0) || has_nav_menu( 'right-section' )){?>
				<div class="info-bar">
					<div class="container clearfix">
					<?php if ( has_nav_menu( 'left-section' ) || ($magcast_settings['magcast_hide_date'] ==0)){ ?>
						<div class="left-section clearfix">
							<button class="info-bar-menu-toggle-left"><?php esc_html_e('Responsive Menu', 'magcast' ); ?></button>
							<?php if($magcast_settings['magcast_hide_date'] ==0){ ?>
								<div class="date"><?php echo date_i18n("l, F j , Y"); ?></div>
							<?php } 
							if ( has_nav_menu( 'left-section' ) ){
								wp_nav_menu( array(
									'theme_location' 	=> 'left-section',
									'container' 		=> '',
									'depth'          	=> 1,
									'items_wrap'      => '<ul class="nav-menu-left">%3$s</ul>',
								) );
							} ?>
						</div><!-- .left-section -->
					<?php } 
					 if ( has_nav_menu( 'right-section' )){ ?>
						<div class="right-section clearfix">
							<button class="info-bar-menu-toggle-right"><?php esc_html_e('Responsive Menu', 'magcast' ); ?></button>
							<?php
							wp_nav_menu( array(
								'theme_location' 	=> 'right-section',
								'container' 		=> '',
								'depth'          	=> 1,
								'items_wrap'      => '<ul class="nav-menu-right">%3$s</ul>',
							) ); ?>
						</div><!-- .right-section -->
						<?php } ?>
					</div><!-- .container -->
				</div><!-- .info-bar -->
			<?php }
		}
	if($magcast_settings['magcast_header_design'] !='sitetitle_social_icons_search'){
		$classes ='headeradd';
	}else{
		$classes ='';
		}?>
		<div class="hgroup-wrap <?php echo esc_attr($classes);?> clearfix">
			<div class="container clearfix">
					<div id="site-logo" class="clearfix">
						<?php magcast_the_custom_logo();?><!-- #site-logo -->
							<?php if(is_single() || (!is_page_template('page-templates/page-template-magazine.php' )) && !is_home()){ ?>
								<h2 id="site-title">
									<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a> 
								</h2><!-- #site-title -->
								<?php } else { ?>
								<h1 id="site-title">
									<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a> 
								</h1><!-- #site-title -->
								<?php }
								$magcast_site_description = get_bloginfo( 'description', 'display' );
								if($magcast_site_description){?>
								<h2 id="site-description"><?php bloginfo('description');?> </h2>
							<?php } ?>
					</div><!-- #site-logo -->
				<button class="menu-toggle"><?php esc_html_e('Responsive Menu', 'magcast' ); ?></button>
				<?php
				global $magcast_settings;
				if($magcast_settings['magcast_hide_header_social_icon'] ==0 && ($magcast_settings['magcast_header_design'] =='sitetitle_social_icons_search') ){ ?>
					<div class="hgroup-left">
						<?php magcast_display_social_icons(); ?>
					</div><!-- .hgroup-left -->
				<?php }
				if($magcast_settings['magcast_header_design'] =='sitetitle_social_icons_search'){
					if($magcast_settings['magcast_hide_top_search'] !=1){ ?>
						<div class="hgroup-right">
							<div class="search-toggle-top"></div><!-- .search-toggle -->
							<div id="search-box-top" class="hide">
								<?php get_search_form();?>
								<span class="arrow"></span>
							</div><!-- #search-box -->
						</div><!-- .hgroup-right -->
					<?php }
				}else{ ?>
				<div class="hgroup-right">
					<?php if ( is_active_sidebar( 'magcast_headeradd_sidebar' ) ) :
						dynamic_sidebar( 'magcast_headeradd_sidebar' );
					endif;?>
				</div>
				<?php } ?>
			</div><!-- .container -->
		</div><!-- .hgroup-wrap -->
		<div class="navigation-bar">
			<div class="container clearfix">
				<nav id="site-navigation" class="main-navigation clearfix" role="navigation">
					<?php  
					if (has_nav_menu('primary')) {// if there is nav menu then content displayed from nav menu else from pages ?>
					<?php $args = array(
								'theme_location' => 'primary',
								'container'      => '',
								'items_wrap'     => '<ul class="nav-menu">%3$s</ul>',
							); 
						wp_nav_menu($args);//extract the content from apperance-> nav menu 
					} else {// extract the content from page menu only 
						wp_page_menu(array('menu_class' => 'nav-menu'));
					}
					$magcast_search_form = $magcast_settings['magcast_search_header_settings'];
					if (1 != $magcast_search_form) { ?>
					<div class="search-toggle"></div><!-- .search-toggle -->
					<div id="search-box" class="hide">
						<?php get_search_form();?>
						<span class="arrow"></span>
					</div><!-- #search-box -->
					<?php } ?>
				</nav><!-- #site-navigation .main-navigation -->
				<?php 
				$number = absint($magcast_settings['magcast_post_num_highligted']);
				if(($magcast_settings['magcast_hide_highligted_options'] =='on') || ($magcast_settings['magcast_hide_highligted_options'] =='only_magazine') || ($magcast_settings['magcast_hide_highligted_options'] =='only_blog_magazine') ){
					$magcast_get_featured_post = new WP_Query(array(
						'posts_per_page' => $number,
						'post_type' => array(
							'post'
						) ,
						'category__in' => $magcast_settings['magcast_dropdown_categories'],
					));
					if($magcast_settings['magcast_hide_highligted_options'] =='only_magazine' && (is_page_template('page-templates/page-template-magazine.php')) ){ ?>
							<div class="highlighted-posts clearfix">
								<span><?php echo ($magcast_settings['magcast_highligted_title']); ?></span>
								<ul class="newsticker">
								<?php 
									while ($magcast_get_featured_post->have_posts()):
									$magcast_get_featured_post->the_post(); ?>
									<li><a title="<?php the_title_attribute();?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php
								endwhile;
								// Reset Post Data
								wp_reset_query(); ?>
								</ul>
							</div>
					<?php } elseif(($magcast_settings['magcast_hide_highligted_options'] =='only_blog_magazine') && (is_home() || is_page_template('page-templates/page-template-magazine.php')) ){ ?>
							<div class="highlighted-posts clearfix">
								<span><?php echo ($magcast_settings['magcast_highligted_title']); ?></span>
								<ul class="newsticker">
								<?php 
									while ($magcast_get_featured_post->have_posts()):
									$magcast_get_featured_post->the_post(); ?>
									<li><a title="<?php the_title_attribute();?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php
								endwhile;
								// Reset Post Data
								wp_reset_query(); ?>
								</ul>
							</div>
					<?php }elseif($magcast_settings['magcast_hide_highligted_options'] =='on'){ ?>
							<div class="highlighted-posts clearfix">
								<span><?php echo ($magcast_settings['magcast_highligted_title']); ?></span>
								<ul class="newsticker">
								<?php 
									while ($magcast_get_featured_post->have_posts()):
									$magcast_get_featured_post->the_post(); ?>
									<li><a title="<?php the_title_attribute();?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php
								endwhile;
								// Reset Post Data
								wp_reset_query(); ?>
								</ul>
							</div>
					<?php }
				} ?>
			</div><!-- .container -->
		</div><!-- .navigation-bar -->
		<?php global $magcast_disable_slider;
		global $magcast_settings;
		if (is_front_page()) { 
			$magcast_disable_slider = $magcast_settings['magcast_disable_slider'];
			if ($magcast_disable_slider ==0) { 
				if (function_exists('magcast_featured_sliders')) {
					magcast_featured_sliders();
				}
			}
		} else{
			if (('' != magcast_header_title()) || function_exists('bcn_display_list')) {
				$magcast_sitetitle_img_setting = $magcast_settings['magcast_site_title_setting'];

				$magcast_sitetitle_image = $magcast_settings['magcast-img-upload-site-title']; ?>
				<div class="page-title-wrap" <?php if ( $magcast_sitetitle_img_setting != '1'  && $magcast_sitetitle_image != '' ){ ?> style="background-image:url('<?php echo esc_url($magcast_sitetitle_image);?>');" <?php } ?> >
					<div class="container clearfix">
					<?php if(is_home()){?>
						<h2 class="page-title"><?php echo magcast_header_title();?></h2><!-- .page-title -->
					<?php } else { ?>
						<h1 class="page-title"><?php echo magcast_header_title();?></h1><!-- .page-title -->
					<?php }
						if (function_exists('magcast_breadcrumb')) {
							magcast_breadcrumb();
						} ?>
					</div><!-- .container -->
				</div><!-- .page-title-wrap -->
			<?php
			}
		} ?>
	</header><!-- #masthead -->
<?php }

/****************************************************************************************/

if (!function_exists('magcast_featured_sliders')):
/**
 * displaying the featured image in home page
 *
 */
function magcast_featured_sliders() {
	global $post;
	global $magcast_settings,$magcast_array_of_default_settings;
	$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults() );
	$magcast_featured_sliders = '';
	$magcast_get_featured_posts 		= new WP_Query(array(
				'posts_per_page'      	=> $magcast_settings['magcast_slider_quantity'],
				'post_type'           	=> array('post'),
				'post__in'            	=> $magcast_settings['magcast_featured_post_slider'],
				'orderby'             	=> 'post__in',
				'ignore_sticky_posts' 	=> 1
			));
	if($magcast_get_featured_posts->have_posts() || $magcast_featured_sliders !=''){
		$magcast_featured_sliders 	.= '<div class="featured-slider"><div class="owl-carousel">';
				
		while ($magcast_get_featured_posts->have_posts()):$magcast_get_featured_posts->the_post(); 
					$title_attribute       	 	 = apply_filters('the_title', get_the_title($post->ID));
					$categories = get_the_category();
			$magcast_featured_sliders    	.= '<article class="post feature-slide">';
			if (has_post_thumbnail()) {
				$magcast_featured_sliders 	.= '<a title="'.esc_html($title_attribute).'" href="'.get_permalink().'"> '. get_the_post_thumbnail($post->ID, 'magcast-slider-image').'</a>';
			}	
			$magcast_featured_sliders 	.= '<div class="entry-header">';
			$magcast_featured_sliders .= '<h2 class="entry-title"><a href="'.get_permalink().'" title="'.the_title('', '', false).'">'.get_the_title().'</a></h2><!-- .entry-title -->';
			if(($magcast_settings['magcast_hide_slider_date']==0) || ($magcast_settings['magcast_hide_slider_author']==0) ){
				$magcast_featured_sliders 	.= '<div class="entry-meta clearfix">';
					if($magcast_settings['magcast_hide_slider_date']==0){
						$magcast_featured_sliders 	.= '<div class="date"><a href="'. esc_url_raw( get_the_permalink()).'" title="'. esc_attr( get_the_time('j F Y') ).'">'. esc_attr(get_the_time('j F Y')).'</a></div>';
					}
					if($magcast_settings['magcast_hide_slider_author']==0){
						$magcast_featured_sliders 	.= '<div class="by-author"><a href="'.esc_url_raw(get_author_posts_url( get_the_author_meta( 'ID' ) )). '" title="'. esc_attr(get_the_author()).'">'. esc_attr(get_the_author()).'</a></div></div><!-- .entry-meta -->';
					}
			}
			$magcast_featured_sliders 	.= '</div><!-- .entry-header -->';
			$magcast_featured_sliders 	.= '</article><!-- .post -->';
		endwhile;
				wp_reset_query();
				$magcast_featured_sliders .= '</div><!-- .owl-carousel --></div><!-- .featured-slider -->';
	}
				echo $magcast_featured_sliders;
}
endif;
/****************************************************************************************/
if (!function_exists('magcast_breadcrumb')):
/**
 * Display breadcrumb on header.
 *
 * If the page is home or front page, slider is displayed.
 * In other pages, breadcrumb will display if breadcrumb NavXT plugin exists.
 */
function magcast_breadcrumb() {
	if (function_exists('bcn_display')) { ?>
		<div class="breadcrumb">
			<?php bcn_display(); ?>
		</div> <!-- .breadcrumb -->
	<?php }
}
endif;
/****************************************************************************************/
if (!function_exists('magcast_header_title')):
/**
 * Show the title in header
 *
 * @since Magcast 1.0
 */
function magcast_header_title() {
	if (is_archive()) {
		if( class_exists( 'WooCommerce' ) && is_woocommerce()){
			$magcast_header_title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		}else{
			$magcast_header_title = get_the_archive_title('', FALSE);
		}
	} elseif (is_home()){
		$magcast_header_title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif (is_404()) {
		$magcast_header_title = esc_html__('Page NOT Found', 'magcast');
	} elseif (is_search()) {
		$magcast_header_title = esc_html__('Search Results', 'magcast');
	} elseif (is_page_template()) {
		$magcast_header_title = get_the_title();
	} else {
		$magcast_header_title = get_the_title();
	}
	return $magcast_header_title;
}
endif;
?>
