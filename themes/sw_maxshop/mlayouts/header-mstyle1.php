<?php 
	/* 
	** Content Header
	*/
	$sticky_mobile	= ya_options()->getCpanelValue( 'sticky_menu' );
?>
<?php if( is_front_page() || get_post_meta( get_the_ID(), 'page_mobile_enable', true ) || is_search()):?>
<header id="header" class="header header-mobile-style1">
	<div class="header-wrrapper clearfix">
		<div class="header-top-mobile clearfix">
			<div class="header-menu-categories pull-left">
				<?php if ( has_nav_menu('vertical_menu') ) {?>
					<div class="vertical_megamenu">
						<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
			<?php } ?>
			</div>
			<div class="ya-logo pull-left">
				<?php ya_logo(); ?>
			</div>
			<div class="mobile-search">
				<div class="non-margin">
					<div class="widget-inner">
						<?php get_template_part( 'widgets/ya_top/searchcate' ); ?>
					</div>
				</div>
			</div>			
		</div>
		<?php if ( has_nav_menu('mobile_menu1') ) {?>
				<div class="header-menu-page pull-left">
						<div class="wrapper_menu">
							<?php wp_nav_menu(array('theme_location' => 'mobile_menu1', 'menu_class' => 'nav menu-mobile1')); ?>
						</div>
				</div>
		<?php } ?>
	</div>
</header>
<?php else : ?>
<!--  header page -->
<?php get_template_part( 'mlayouts/breadcrumb', 'mobile' ); ?>
	<!-- End header -->
<?php endif; ?>