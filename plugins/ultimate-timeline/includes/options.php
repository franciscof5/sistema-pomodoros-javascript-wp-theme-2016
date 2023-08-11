<?php


/**
 * WordPress settings API demo class
 *
 * @author Sam Berson
 */
if ( !class_exists('ExecuteTimelineSettings' ) ):
class ExecuteTimelineSettings {

    private $settings_api;
    function __construct() {
        $this->settings_api = new TimelineSettings;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {

        $parent_slug = 'edit.php?post_type=timeline'; 
        $page_title = 'Timeline Options';
        $menu_title = 'Timeline Options';
        $capability = 'administrator'; 
        $menu_slug  = 'ul-timeline-options';  

        add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'plugin_page'));
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'timeline_connection',
                'title' => __( 'Connection Settings', 'ultimate-timeline' )
            ),
             array(
                'id' => 'timeline_basics',
                'title' => __( 'General Settings', 'ultimate-timeline' )
            ),
            array(
                'id' => 'timeline_appearance',
                'title' => __( 'Appearance', 'ultimate-timeline' )
            ),
            
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'timeline_connection' => array(
                array(
                    'name' => 'twitter_textblock1',
                    'label' => __( '', 'ultimate-timeline' ),
                    'desc' => __( '<b>Connection Settings for Twitter</b>', 'ultimate-timeline' ),
                    'type' => 'textblock',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'consumer_key',
                    'label' => __( 'API Key', 'ultimate-timeline' ),
                    'desc' => __( 'Required', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'consumer_secret',
                    'label' => __( 'API Secret', 'ultimate-timeline' ),
                    'desc' => __( 'Required', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'user_token',
                    'label' => __( 'Access Token', 'ultimate-timeline' ),
                    'desc' => __( 'Optional', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'user_secret',
                    'label' => __( 'Access Secret', 'ultimate-timeline' ),
                    'desc' => __( 'Optional', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'twitter_textblock',
                    'label' => __( '', 'ultimate-timeline' ),
                    'desc' => __( 'You can get your twitter API Keys <a target="_blank" href="https://apps.twitter.com/app/new">here</a>', 'ultimate-timeline' ),
                    'type' => 'textblock',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'fb_textblock',
                    'label' => __( '', 'ultimate-timeline' ),
                    'desc' => __( '<b>Connection Settings for Facebook</b>', 'ultimate-timeline' ),
                    'type' => 'textblock',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'fb_access_token',
                    'label' => __( 'Access Token', 'ultimate-timeline' ),
                    'desc' => __( 'Optional', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                // array(
                //     'name' => 'fb_app_id',
                //     'label' => __( 'App ID', 'ultimate-timeline' ),
                //     'desc' => __( 'Required', 'ultimate-timeline' ),
                //     'type' => 'text',
                //     'default' => '',
                //     //'sanitize_callback' => 'intval'
                // ),
                // array(
                //     'name' => 'fb_consumer_secret',
                //     'label' => __( 'API Secret', 'ultimate-timeline' ),
                //     'desc' => __( 'Required', 'ultimate-timeline' ),
                //     'type' => 'text',
                //     'default' => '',
                //     //'sanitize_callback' => 'intval'
                // ),
                array(
                    'name' => 'fb_textblock1',
                    'label' => __( '', 'ultimate-timeline' ),
                    'desc' => __( 'You can get your facebook Access Token <a target="_blank" href="https://developers.facebook.com/apps/">here</a>', 'ultimate-timeline' ),
                    'type' => 'textblock',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'instagram_textblock',
                    'label' => __( '', 'ultimate-timeline' ),
                    'desc' => __( '<b>Connection Settings for Instagram</b>', 'ultimate-timeline' ),
                    'type' => 'textblock',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'instagram_client_id',
                    'label' => __( 'Client ID', 'ultimate-timeline' ),
                    'desc' => __( 'Required', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'instagram_access_token',
                    'label' => __( 'Access Token', 'ultimate-timeline' ),
                    'desc' => __( 'Required', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'instagram_client_secret',
                    'label' => __( 'Client Secret', 'ultimate-timeline' ),
                    'desc' => __( 'Required', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'instagram_textblock1',
                    'label' => __( '', 'ultimate-timeline' ),
                    'desc' => __( 'You can get your instagram Client Keys <a target="_blank" href="http://instagram.com/developer/">here</a><br><br><span>Access Token: <a target="_blank" href="http://jelled.com/instagram/access-token">http://jelled.com/instagram/access-token</a></span>', 'ultimate-timeline' ),
                    'type' => 'textblock',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
            ),
            'timeline_basics' => array(
               array(
                    'name' => 'tweet_title',
                    'label' => __( 'Title For Tweets', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => 'From Twitter',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'facebook_title',
                    'label' => __( 'Title For Facebook Posts', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => 'Facebook',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'dribbble_title',
                    'label' => __( 'Title For Dribbble Posts', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => 'Dribbble',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'instagram_title',
                    'label' => __( 'Title For Instagram Posts-N-u-L-L2-4.NE-T', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => 'Instagram',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'default_content',
                    'label' => __( 'Text For No Post Content', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => 'Click the post title for more info',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'per_load',
                    'label' => __( 'Items Per Load', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'number',
                    'default' => 10,
                    'sanitize_callback' => 'int'
                ),
               array(
                    'name' => 'link_titles',
                    'label' => __( 'Link Post Titles', 'ultimate-timeline' ),
                    'desc' => __( 'If Yes Title will link to individual blog post', 'ultimate-timeline' ),
                    'type' => 'select',
                    'options' => array(
                        'yes' => 'Yes',
                        'no' => 'No'
                    )
                ),
               array(
                    'name' => 'load_more_method',
                    'label' => __( 'Load More Method', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'select',
                    'options' => array(
                        'click'  => 'Click',
                        'scroll' => 'Scroll'
                    )
                ),
               array(
                    'name' => 'display_time',
                    'label' => __( 'Show Time After Date-N,uL-L2-4.NE-T', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'default' => 'no',
                    'options' => array(
                        'yes'  => 'Yes',
                        'no' => 'No'
                    )
                ),
               array(
                    'name' => 'fontawesome_turn',
                    'label' => __( 'Font Awesome Integration', 'ultimate-timeline' ),
                    'desc' => __( 'Turn off if your theme conflicts with Font Awesome', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'default' => 'yes',
                    'options' => array(
                        'yes'  => 'On',
                        'no' => 'Off',
                        //'default' => 'On'
                    )
                ),
               array(
                    'name' => 'icon_choice',
                    'label' => __( 'Icons Type', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'default' => 'default',
                    'options' => array(
                        'default'  => 'Default',
                        'images'  => 'Images',
                        'fa-icons' => 'Font Awesome Icons'
                    )
                ),
               array(
                    'name' => 'tweet_icon',
                    'label' => __( 'Display Twitter Icon', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'options' => array(
                        'yes'  => 'Yes',
                        'no' => 'No'
                    )
                ),
               array(
                    'name' => 'tweet_icon_file',
                    'label' => __( 'Twitter Icon', 'ultimate-timeline' ),
                    'desc' => __( 'File description', 'ultimate-timeline' ),
                    'type' => 'file',
                    'default' => ''
                ),
               array(
                    'name' => 'tweet_icon_fontawesome',
                    'label' => __( 'Twitter Icon Font Awesome Code', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'facebook_icon',
                    'label' => __( 'Display Facebook Icon', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'options' => array(
                        'yes'  => 'Yes',
                        'no' => 'No'
                    )
                ),
               array(
                    'name' => 'facebook_icon_file',
                    'label' => __( 'Facebook Icon', 'ultimate-timeline' ),
                    'desc' => __( 'File description', 'ultimate-timeline' ),
                    'type' => 'file',
                    'default' => ''
                ),
               array(
                    'name' => 'facebook_icon_fontawesome',
                    'label' => __( 'Facebook Icon Font Awesome Code', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'dribbble_icon',
                    'label' => __( 'Display Dribbble Icon', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'options' => array(
                        'yes'  => 'Yes',
                        'no' => 'No'
                    )
                ),
               array(
                    'name' => 'dribbble_icon_file',
                    'label' => __( 'Dribbble Icon', 'ultimate-timeline' ),
                    'desc' => __( 'File description', 'ultimate-timeline' ),
                    'type' => 'file',
                    'default' => ''
                ),
               array(
                    'name' => 'dribbble_icon_fontawesome',
                    'label' => __( 'Dribbble Icon Font Awesome Code', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'instagram_icon',
                    'label' => __( 'Display Instagram Icon', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'options' => array(
                        'yes'  => 'Yes',
                        'no' => 'No'
                    )
                ),
               array(
                    'name' => 'instagram_icon_file',
                    'label' => __( 'Instagram Icon', 'ultimate-timeline' ),
                    'desc' => __( 'File description', 'ultimate-timeline' ),
                    'type' => 'file',
                    'default' => ''
                ),
               array(
                    'name' => 'instagram_icon_fontawesome',
                    'label' => __( 'Instagram Icon Font Awesome Code', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'post_icon',
                    'label' => __( 'Display Post Icon', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'options' => array(
                        'yes'  => 'Yes',
                        'no' => 'No'
                    )
                ),
               array(
                    'name' => 'post_icon_file',
                    'label' => __( 'Post Icon', 'ultimate-timeline' ),
                    'desc' => __( 'File description', 'ultimate-timeline' ),
                    'type' => 'file',
                    'default' => ''
                ),
               array(
                    'name' => 'post_icon_fontawesome',
                    'label' => __( 'Post Icon Font Awesome Code', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'status_icon',
                    'label' => __( 'Display Status Icon', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'options' => array(
                        'yes'  => 'Yes',
                        'no' => 'No'
                    ),
                ),
               array(
                    'name' => 'status_icon_file',
                    'label' => __( 'Status Icon', 'ultimate-timeline' ),
                    'desc' => __( 'File description', 'ultimate-timeline' ),
                    'type' => 'file',
                    'default' => ''
                ),
               array(
                    'name' => 'status_icon_fontawesome',
                    'label' => __( 'Status Icon Font Awesome Code', 'ultimate-timeline' ),
                    'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => '',
                    //'sanitize_callback' => 'intval'
                ),
               array(
                    'name' => 'affiliate_link',
                    'label' => __( 'Display Affiliate Link', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'options' => array(
                        'yes'  => 'Yes',
                        'no' => 'No'
                    ),
                ),
               array(
                    'name' => 'affiliate_id',
                    'label' => __( 'Envato Affiliate ID', 'ultimate-timeline' ),
                    'desc' => __( 'File description', 'ultimate-timeline' ),
                    'type' => 'text',
                    'default' => ''
                )
            ),
            'timeline_appearance' => array(
                array(
                    'name' => 'default_css',
                    'label' => __( 'Use Default CSS', 'ultimate-timeline' ),
                    //'desc' => __( '', 'ultimate-timeline' ),
                    'type' => 'radio',
                    'options' => array(
                        'yes'  => 'Yes',
                        'no' => 'No'
                    )
                ),
                array(
                    'name' => 'background_color',
                    'label' => __( 'Main Background Colour', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'sepereator',
                    'label' => __( 'Seperating Line', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'sepereator_dots',
                    'label' => __( 'Sepereator Dots', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'text_container_bg',
                    'label' => __( 'Text Container', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'icon_color',
                    'label' => __( 'Icon Color', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'title_color',
                    'label' => __( 'Title Color', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'content_color',
                    'label' => __( 'Content Color', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'links_color',
                    'label' => __( 'Links Color', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'date_color',
                    'label' => __( 'Date Color', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'footer_bg',
                    'label' => __( 'Timeline Footer Background', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'begin_end_text_color',
                    'label' => __( 'Begin End Color', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                ),
                array(
                    'name' => 'begin_end_text_bg',
                    'label' => __( 'Begin End Background', 'ultimate-timeline' ),
                    'type' => 'color',
                    'default' => ''
                )
            )
        
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';
        echo '<h2 class="mb-10">WordPress Ultimate Timeline</h2>';    
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

$settings = new ExecuteTimelineSettings;