<?php 



/* #######################################################################

	Custom Meta for Single to deal with Post Formats

####################################################################### */

function single_format_init(){
		add_meta_box(
			"single_format-meta", 
			__("Post Formats" , "meanthemes"), 
			"single_format_meta_options", 
			"post", 
			"normal", 
			"core");
	}

	function single_format_meta_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		
		$single_format_link_url = "";
		$single_format_link_url_self = "";
		$single_format_video = "";
		$single_format_audio = "";
		$single_format_quote = "";
		$single_format_quote_url = "";
		$single_format_status = "";
		
		if( isset( $custom["single_format_link_url"] ) ) {
			$single_format_link_url = $custom["single_format_link_url"][0];
		}
		if( isset( $custom["single_format_link_url_self"] ) ) {
			$single_format_link_url_self = $custom["single_format_link_url_self"][0];
		}
		if( isset( $custom["single_format_video"] ) ) {
			$single_format_video = $custom["single_format_video"][0];
		}
		if( isset( $custom["single_format_audio"] ) ) {
			$single_format_audio = $custom["single_format_audio"][0];
		}
		if( isset( $custom["single_format_quote"] ) ) {
			$single_format_quote = $custom["single_format_quote"][0];
		}
		if( isset( $custom["single_format_quote_url"] ) ) {
			$single_format_quote_url = $custom["single_format_quote_url"][0];
		}
		if( isset( $custom["single_format_status"] ) ) {
			$single_format_status = $custom["single_format_status"][0];
		}
		
?>

<?php wp_nonce_field( basename( __FILE__ ), 'single_format_nonce' ); ?>

	<div>
		<div><br /><i><?php _e("To keep things simple, please fill out the following below per post format, you must ensure you also choose the right post format from the 'Format' panel for the below to work" , "meanthemes"); ?></i></div>
		<h4><?php _e("Link Format" , "meanthemes"); ?></h4>
		<label><?php _e("URL (Web Address):" , "meanthemes"); ?></label><br /><input name="single_format_link_url" type="text" value="<?php echo $single_format_link_url; ?>" class="large-text" /><br />
		<label style="margin-top: 5px; display: block;"><?php _e("Open this link in the same window (this overrides the default new window/tab)" , "meanthemes"); ?>&nbsp;&nbsp;<input name="single_format_link_url_self" type="checkbox" value="1" <?php if ( $single_format_link_url_self == 1) { echo "checked"; } else { $single_format_link_url_self = 0; } ?> /></label>
		
		<h4><?php _e("Video Format:" , "meanthemes"); ?></h4>
		<label><?php _e("Video Embed Code:" , "meanthemes"); ?></label><br />
		<textarea class="large-text" name="single_format_video" rows="10" value="<?php echo esc_attr($single_format_video); ?>"><?php echo esc_attr($single_format_video); ?></textarea>
		<br />
		
		<h4><?php _e("Status Format:" , "meanthemes"); ?></h4>
		<label><?php _e("Insert Facebook or Twitter Embed Code:" , "meanthemes"); ?></label><br />
		<textarea class="large-text" name="single_format_status" rows="10" value="<?php echo esc_attr($single_format_status); ?>"><?php echo esc_attr($single_format_status); ?></textarea>
		<br />
		
		<h4><?php _e("Audio Format (mp3):" , "meanthemes"); ?></h4>
		<label><?php _e("Audio Web Address (URL - you can upload via WordPress and then copy link into here):" , "meanthemes"); ?></label><br />
		<input name="single_format_audio" type="text" value="<?php echo $single_format_audio; ?>" class="large-text" /><br />
				<h4><?php _e("Quote Format" , "meanthemes"); ?></h4>
				<label><?php _e("Source:" , "meanthemes"); ?></label><br /><input name="single_format_quote" type="text" value="<?php echo $single_format_quote; ?>" class="large-text" /><br /><br />
				<label><?php _e("Source URL:" , "meanthemes"); ?></label><br /><input name="single_format_quote_url" type="text" value="<?php echo $single_format_quote_url; ?>" class="large-text" /><br /><br />
	</div>
		
<?php
	}

function save_single_format_meta(){
	global $post;
	
	
		if (isset( $post->post_type) && $post->post_type !== 'page' ){
		/* Verify the nonce before proceeding. */
		if ( isset( $_POST['single_format_nonce'] ) || wp_verify_nonce( $_POST['single_format_nonce'], basename( __FILE__ ) ) ) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
			} else {
				if( isset( $post->ID ) ) {
					update_post_meta($post->ID, "single_format_link_url", $_POST["single_format_link_url"]);
					
					$isChecked = !empty($_POST["single_format_link_url_self"]) && $_POST["single_format_link_url_self"] == "1"; 
					
					update_post_meta($post->ID, "single_format_link_url_self", $isChecked);   
					
					
					update_post_meta($post->ID, "single_format_video", balanceTags( $_POST["single_format_video"] ) );
					update_post_meta($post->ID, "single_format_audio", $_POST["single_format_audio"]);
					update_post_meta($post->ID, "single_format_quote", $_POST["single_format_quote"]);
					update_post_meta($post->ID, "single_format_quote_url", $_POST["single_format_quote_url"]);
					update_post_meta($post->ID, "single_format_status", $_POST["single_format_status"]);
				}
			}
		}	
	}	
}

add_action("admin_init", "single_format_init");
add_action('save_post', 'save_single_format_meta');


/* #######################################################################

	Custom Meta for Header Background Colour on all pages & post types

####################################################################### */


if ( get_theme_mod( 'use_subtle_layout', '0' ) == '0' ) {

	
		function lead_colour_init(){
			add_meta_box(
				"lead_colour-meta", 
				__("Header Background settings", 
				"meanthemes"), 
				"lead_colour_meta_options", 
				"page", 
				"side", 
				"low");
				
			add_meta_box(
				"lead_colour-meta", 
				__("Header Background settings", "meanthemes"),
				"lead_colour_meta_options", 
				"post", 
				"side", 
				"low");
		}
	
	
		function lead_colour_meta_options(){
			global $post;
			$custom = get_post_custom($post->ID);
			$lead_colour_background = "";	
			$lead_text_color = "";	
			$lead_p_background = "";
			$lead_p_background_position = "";
			$lead_p_background_opacity = "";
			
			if( isset( $custom["lead_colour_background"] ) ) {
				$lead_colour_background = $custom["lead_colour_background"][0];
			}	
			
			if( isset( $custom["lead_text_color"] ) ) {
				$lead_text_color = $custom["lead_text_color"][0];
			}	
			
			if( isset( $custom["lead_p_background"] ) ) {
				$lead_p_background = $custom["lead_p_background"][0];
			}	
			
			if( isset( $custom["lead_p_background_position"] ) ) {
				$lead_p_background_position = $custom["lead_p_background_position"][0];
			}	
			
			if( isset( $custom["lead_p_background_opacity"] ) ) {
				$lead_p_background_opacity = $custom["lead_p_background_opacity"][0];
			}
			
	?>
				<?php wp_nonce_field( basename( __FILE__ ), 'lead_colour_background_nonce' ); ?>
		<div>
			<div style=" padding-top: 10px;"><i><b><?php _e("Choose your header background colour - if you set a header image below, the colour will sit behind that image." , "meanthemes"); ?></b></i><br /><br /></div>
			<div style="padding-bottom: 20px">
				<strong style="padding-bottom: 4px; display: block;"><?php _e("Choose Background Colour", "meanthemes"); ?><br /></strong>
			<input name="lead_colour_background" type="text" value="<?php echo $lead_colour_background; ?>" class="mt-colorpicker" />
			</div>
			<div>
			<div style="padding-bottom: 20px">
				<strong style="padding-bottom: 4px; display: block;"><?php _e("Choose Text Colour", "meanthemes"); ?><br /></strong>
			<input name="lead_text_color" type="text" value="<?php echo $lead_text_color; ?>" class="mt-colorpicker" /><br />
			</div>
			</div>
		</div>
		
		<div style="border-top: 1px solid #ccc; padding-top: 20px; margin-top: 10px;">
		<div><i><b><?php _e("Background Cover or Repeat..." , "meanthemes"); ?></b></i></div>
		
		<select name="lead_p_background" id="lead_p_background">
			<option value="cover" <?php if ($lead_p_background === "cover") { echo "selected"; } ?>><?php _e( 'Cover background (Default)' , 'meanthemes' ); ?></option>
			<option value="no-repeat" <?php if ($lead_p_background === "no-repeat") { echo "selected"; } ?> ><?php _e( 'No-repeat ' , 'meanthemes' ); ?></option>
			<option value="repeat" <?php if ($lead_p_background === "repeat") { echo "selected"; } ?> ><?php _e( "Repeat (Tiled)" , 'meanthemes' ); ?></option>
			<option value="repeat-x" <?php if ($lead_p_background === "repeat-x") { echo "selected"; } ?> ><?php _e( "Repeat-X (Horizontal)" , 'meanthemes' ); ?></option>
			<option value="repeat-y" <?php if ($lead_p_background === "repeat-y") { echo "selected"; } ?> ><?php _e( "Repeat-Y (Vertical)" , 'meanthemes' ); ?></option>
		</select>
		
		</div>
		
		<div style="border-top: 1px solid #ccc; padding-top: 20px; margin-top: 10px;">
		<div><i><b><?php _e("Position background image..." , "meanthemes"); ?></b></i></div>
		
		<select name="lead_p_background_position" id="lead_p_background_position">
			<option value="center center" <?php if ($lead_p_background_position === "center center") { echo "selected"; } ?>><?php _e( 'Center Center (Default)' , 'meanthemes' ); ?></option>
			<option value="top center" <?php if ($lead_p_background_position === "top center") { echo "selected"; } ?>><?php _e( 'Top Center' , 'meanthemes' ); ?></option>
			<option value="bottom center" <?php if ($lead_p_background_position === "bottom center") { echo "selected"; } ?>><?php _e( 'Bottom Center' , 'meanthemes' ); ?></option>
			<option value="left top" <?php if ($lead_p_background_position === "left top") { echo "selected"; } ?>><?php _e( 'Top Left' , 'meanthemes' ); ?></option>
			<option value="right top" <?php if ($lead_p_background_position === "right top") { echo "selected"; } ?>><?php _e( 'Top Right' , 'meanthemes' ); ?></option>
			<option value="left bottom" <?php if ($lead_p_background_position === "left bottom") { echo "selected"; } ?>><?php _e( 'Bottom Left' , 'meanthemes' ); ?></option>
			<option value="right bottom" <?php if ($lead_p_background_position === "right bottom") { echo "selected"; } ?>><?php _e( 'Bottom Right' , 'meanthemes' ); ?></option>
		</select>
		
		</div>
		
		
		<div style="border-top: 1px solid #ccc; padding-top: 20px; margin-top: 10px;">
		<div><i><b><?php _e("Opacity of the Image Layer..." , "meanthemes"); ?></b></i></div>
		
		<select name="lead_p_background_opacity" id="lead_p_background_opacity">
			<option value="opacity:0.3;filter(alpha=opacity=30)" <?php if ($lead_p_background_opacity === "opacity:0.3;filter(alpha=opacity=30)") { echo "selected"; } ?>><?php _e( '30% (Default)' , 'meanthemes' ); ?></option>
			<option value="opacity:0.05;filter(alpha=opacity=05)" <?php if ($lead_p_background_opacity === "opacity:0.05;filter(alpha=opacity=05)") { echo "selected"; } ?>><?php _e( '5%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.1;filter(alpha=opacity=10)" <?php if ($lead_p_background_opacity === "opacity:0.1;filter(alpha=opacity=10)") { echo "selected"; } ?>><?php _e( '10%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.15;filter(alpha=opacity=15)" <?php if ($lead_p_background_opacity === "opacity:0.15;filter(alpha=opacity=15)") { echo "selected"; } ?>><?php _e( '15%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.2;filter(alpha=opacity=20)" <?php if ($lead_p_background_opacity === "opacity:0.2;filter(alpha=opacity=20)") { echo "selected"; } ?>><?php _e( '20%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.25;filter(alpha=opacity=25)" <?php if ($lead_p_background_opacity === "opacity:0.25;filter(alpha=opacity=25)") { echo "selected"; } ?>><?php _e( '25%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.35;filter(alpha=opacity=35)" <?php if ($lead_p_background_opacity === "opacity:0.35;filter(alpha=opacity=35)") { echo "selected"; } ?>><?php _e( '35%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.4;filter(alpha=opacity=40)" <?php if ($lead_p_background_opacity === "opacity:0.4;filter(alpha=opacity=40)") { echo "selected"; } ?>><?php _e( '40%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.45;filter(alpha=opacity=45)" <?php if ($lead_p_background_opacity === "opacity:0.45;filter(alpha=opacity=45)") { echo "selected"; } ?>><?php _e( '45%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.50;filter(alpha=opacity=50)" <?php if ($lead_p_background_opacity === "opacity:0.50;filter(alpha=opacity=50)") { echo "selected"; } ?>><?php _e( '50%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.55;filter(alpha=opacity=55)" <?php if ($lead_p_background_opacity === "opacity:0.55;filter(alpha=opacity=55)") { echo "selected"; } ?>><?php _e( '55%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.6;filter(alpha=opacity=60)" <?php if ($lead_p_background_opacity === "opacity:0.6;filter(alpha=opacity=60)") { echo "selected"; } ?>><?php _e( '60%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.65;filter(alpha=opacity=65)" <?php if ($lead_p_background_opacity === "opacity:0.65;filter(alpha=opacity=65)") { echo "selected"; } ?>><?php _e( '65%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.7;filter(alpha=opacity=70)" <?php if ($lead_p_background_opacity === "opacity:0.7;filter(alpha=opacity=70)") { echo "selected"; } ?>><?php _e( '70%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.75;filter(alpha=opacity=75)" <?php if ($lead_p_background_opacity === "opacity:0.75;filter(alpha=opacity=75)") { echo "selected"; } ?>><?php _e( '75%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.8;filter(alpha=opacity=80)" <?php if ($lead_p_background_opacity === "opacity:0.8;filter(alpha=opacity=80)") { echo "selected"; } ?>><?php _e( '80%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.85;filter(alpha=opacity=85)" <?php if ($lead_p_background_opacity === "opacity:0.85;filter(alpha=opacity=85)") { echo "selected"; } ?>><?php _e( '85%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.9;filter(alpha=opacity=90)" <?php if ($lead_p_background_opacity === "opacity:0.9;filter(alpha=opacity=90)") { echo "selected"; } ?>><?php _e( '90%' , 'meanthemes' ); ?></option>
			<option value="opacity:0.95;filter(alpha=opacity=95)" <?php if ($lead_p_background_opacity === "opacity:0.95;filter(alpha=opacity=95)") { echo "selected"; } ?>><?php _e( '95%' , 'meanthemes' ); ?></option>
			<option value="opacity:1;filter(alpha=opacity=100)" <?php if ($lead_p_background_opacity === "opacity:1;filter(alpha=opacity=100)") { echo "selected"; } ?>><?php _e( '100%' , 'meanthemes' ); ?></option>
			
			
		</select>
		
		</div>
		
	<?php
		}
	
	function save_lead_colour_meta(){
		global $post;
		
		/* Verify the nonce before proceeding. */
		if ( isset( $_POST['lead_colour_background_nonce'] ) && wp_verify_nonce( $_POST['lead_colour_background_nonce'], basename( __FILE__ ) ) ) {
			
			if (isset( $post->post_type) && $post->post_type != 'announcement'){
				if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return $post->ID;
				} else {
					if( isset( $post->ID ) ) {
						update_post_meta($post->ID, "lead_colour_background", $_POST["lead_colour_background"]);
						update_post_meta($post->ID, "lead_text_color", $_POST["lead_text_color"]);
						
						update_post_meta($post->ID, "lead_p_background", $_POST["lead_p_background"]);
						update_post_meta($post->ID, "lead_p_background_position", $_POST["lead_p_background_position"]);
						update_post_meta($post->ID, "lead_p_background_opacity", $_POST["lead_p_background_opacity"]);
					}
				}
			}
		}		
	}
	
	add_action("admin_init", "lead_colour_init");
	add_action('save_post', 'save_lead_colour_meta');
	
	
	}


/* #######################################################################

	Custom Meta for turning featured image on/off on any archive page

####################################################################### */


	function disable_featured_image_init(){
		add_meta_box("disable_featured_image-meta", __("Disable Featured Image on Archive?" , "meanthemes"), "disable_featured_image_meta_options", "post", "side", "default");
	}

	function disable_featured_image_meta_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$disable_featured_image = "";
		
		if( isset( $custom["disable_featured_image"] ) ) {
			$disable_featured_image = $custom["disable_featured_image"][0];
		}

?>

	<?php wp_nonce_field( basename( __FILE__ ), 'disable_featured_image_nonce' ); ?>
	
	<div>
		<div><i><b><?php _e("Disable Featured Image from showing on the index/archive/home whilst still being able to use it on this single post or page." , "meanthemes"); ?></b></i><br /><br /></div>
		<input type="radio" name="disable_featured_image" id="disable_featured_image-no" <?php if ($disable_featured_image != "yes") { ?> checked="checked" <?php } ?> value="no" /> <label for="disable_featured_image-no"><?php _e("No" , "meanthemes"); ?></label><br />
		<input type="radio" name="disable_featured_image" id="disable_featured_image-yes" <?php if ($disable_featured_image == "yes") { ?> checked="checked" <?php } ?> value="yes" /> <label for="disable_featured_image-yes"><?php _e("Yes" , "meanthemes"); ?></label><br />
	</div>
<?php
	}

function save_disable_featured_image_meta(){
	global $post;
		if (isset( $post->post_type) && $post->post_type !== 'page') {
		if ( isset( $_POST['disable_featured_image_nonce'] ) && wp_verify_nonce( $_POST['disable_featured_image_nonce'], basename( __FILE__ ) ) ) {
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
			} else {
				if( isset( $post->ID ) ) {
					update_post_meta($post->ID, "disable_featured_image", $_POST["disable_featured_image"]);
				}
			}
		}
	}	
}

add_action("admin_init", "disable_featured_image_init");
add_action('save_post', 'save_disable_featured_image_meta');

?>