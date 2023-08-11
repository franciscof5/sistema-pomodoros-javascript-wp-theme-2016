<?php

//
/*echo str_replace('sub-menu', 'menu menu_sub', wp_nav_menu( array(
    'echo' => false,
    'theme_location' => 'sidebar-menu',
    'items_wrap' => '<span class="caret">c</span></a><ul class="dropdown-menu">%3$s</ul>' 
  ) )
);*/


//
add_action("admin_menu", "add_theme_menu_item");
add_action( 'wp_enqueue_scripts', 'enqueue' );
add_action("admin_init", "display_theme_panel_fields");

//
function enqueue() {
	//styles
	wp_enqueue_style("bootstrap-css", get_template_directory_uri()."/css/bootstrap.min.css");
	wp_enqueue_style("normalize-css", get_template_directory_uri()."/css/normalize.css");
	wp_enqueue_style("style-css", get_template_directory_uri()."/style.css");
	wp_enqueue_style("include-css", get_template_directory_uri()."/font-include.css");

	//scripts
	wp_enqueue_script("jquery");
	wp_enqueue_script("bootstrap-js", get_template_directory_uri()."/js/bootstrap.min.js");
	wp_enqueue_script("showroom-js", get_template_directory_uri()."/js/showroom.js");
}

//settings page
function showroom_settings_page()
{
    ?>
	    <div class="wrap">
	    <h1>ShowRoom Panel</h1>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("design-section");
	            do_settings_sections("theme-options");      
	            submit_button(); 
	        ?>          
	    </form>
		</div>
	<?php
}


function add_theme_menu_item()
{
	add_menu_page("ShowRoom", "ShowRoom", "manage_options", "showroom-panel", "showroom_settings_page", null, 99);
}

function display_color1_element()
{
	?>
    	<input type="text" name="color1" id="color1" value="<?php echo get_option('color1'); ?>" />
    <?php
}

function display_color2_element()
{
	?>
    	<input type="text" name="color2" id="color2" value="<?php echo get_option('color2'); ?>" />
    <?php
}

function display_theme_panel_fields()
{
    //
	add_settings_section("design-section", "Design Settings", null, "theme-options");  
	add_settings_field("color1", "Color 1", "display_color1_element", "theme-options", "design-section");
    add_settings_field("color2", "Color 2", "display_color2_element", "theme-options", "design-section");

    register_setting("design-section", "color1");
    register_setting("design-section", "color2");
}



add_action("admin_init", "display_theme_panel_fields");

