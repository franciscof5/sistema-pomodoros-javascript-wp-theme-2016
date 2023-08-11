<?php
function wptp_add_categories_to_attachments() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'wptp_add_categories_to_attachments' );

####
add_filter( 'prepend_attachment', 'custom_prepend_attachment' );
/**
 * Callback for WordPress 'prepend_attachment' filter.
 * 
 * Change the attachment page image size to 'large'
 * 
 * @package WordPress
 * @category Attachment
 * @see wp-includes/post-template.php
 * 
 * @param string $attachment_content the attachment html
 * @return string $attachment_content the attachment html
 */
function custom_prepend_attachment( $attachment_content ){
        
        // set the attachment image size to 'large'
        $attachment_content = sprintf( '<p>%s</p>', wp_get_attachment_link(0, 'large', false) );
        
        // return the attachment content
        return $attachment_content;
        
}


##########

/* Set attachment post date (thanks to http://wordpress.org/support/profile/herrvollbaer, posting a solution here: http://wordpress.org/support/topic/modify-date-of-attachments?replies=5#post-3070220) */
// Add a custom field to an attachment in WordPress
if(!function_exists('mam_attachment_date_edit')){
	function mam_attachment_date_edit($form_fields, $post) {
	    $form_fields['post_date']['label'] = __('Date & time', 'mod-att-meta');
	    $form_fields['post_date']['value'] = $post->post_date;
	    $form_fields['post_date']['helps'] = __('Modify the original upload date', 'mod-att-meta');
	    return $form_fields;
	}
	
	add_filter( 'attachment_fields_to_edit', 'mam_attachment_date_edit', 10, 2);
}
// save custom field to post_meta
if(!function_exists('mam_attachment_date_save')){
	function mam_attachment_date_save($post, $attachment) {
		if(strtotime($attachment['post_date'])){ //is a valid date?
			$post['post_date'] = $attachment['post_date'];
	    	return $post;	
		} else {
			// Do nothing silently. That's what you get when you don't give us valid input!
		}
	}
	add_filter( 'attachment_fields_to_save', 'mam_attachment_date_save', 10, 2);
}
/* Adding a field for menu_order setting for a file in case you order them by this. Thanks to https://wordpress.org/support/profile/aspacecodyssey for this one: https://wordpress.org/support/topic/adding-menu_order-to-plugin?replies=1 */
if(!function_exists('mam_attachment_menu_order_edit')){
	function mam_attachment_menu_order_edit($form_fields, $post) {
	    $form_fields['post_menu_order']['label'] = __('Menu Order', 'mod-att-meta');
	    $form_fields['post_menu_order']['value'] = $post->menu_order;
	    $form_fields['post_menu_order']['helps'] = __('Modify the original menu order', 'mod-att-meta');
	    return $form_fields;
	}
	add_filter( 'attachment_fields_to_edit', 'mam_attachment_menu_order_edit', 10, 2);
}
if(!function_exists('mam_attachment_menu_order_save')){
	function mam_attachment_menu_order_save($post, $attachment) {
		$post['menu_order'] = $attachment['post_menu_order'];
    	return $post;
	}
	add_filter( 'attachment_fields_to_save', 'mam_attachment_menu_order_save', 10, 2);
}