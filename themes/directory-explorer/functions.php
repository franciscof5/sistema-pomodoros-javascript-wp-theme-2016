<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'dw-minion', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'dw-minion-widget', get_template_directory_uri() . 'inc/css/dynamic-widget.css' );
}
