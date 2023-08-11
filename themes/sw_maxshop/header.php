<?php $box_layout = ya_options()->getCpanelValue('layout'); ?>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
	<div class="body-wrapper theme-clearfix<?php echo ( $box_layout == 'boxed' )? ' box-layout' : '';?> ">
		<?php ya_header_check(); ?>
		<div id="main" class="theme-clearfix">
			<?php

			if (function_exists('ya_breadcrumb') && !ya_mobile_check() ){
				ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
			} 

			?>