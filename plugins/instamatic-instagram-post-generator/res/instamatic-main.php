<?php

   function instamatic_admin_settings()
   {
       $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
       $language_names = array(
           esc_html__("Disabled", 'instamatic-instagram-post-generator'),
           esc_html__("Afrikaans (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Albanian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Arabic (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Amharic (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Armenian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Belarusian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Bulgarian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Catalan (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Chinese Simplified (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Croatian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Czech (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Danish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Dutch (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("English (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Estonian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Filipino (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Finnish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("French (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Galician (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("German (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Greek (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Hebrew (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Hindi (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Hungarian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Icelandic (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Indonesian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Irish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Italian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Japanese (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Korean (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Latvian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Lithuanian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Norwegian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Macedonian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Malay (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Maltese (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Persian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Polish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Portuguese (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Romanian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Russian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Serbian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Slovak (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Slovenian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Spanish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Swahili (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Swedish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Thai (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Turkish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Ukrainian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Vietnamese (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Welsh (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Yiddish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Tamil (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Azerbaijani (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Kannada (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Basque (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Bengali (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Latin (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Chinese Traditional (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Esperanto (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Georgian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Telugu (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Gujarati (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Haitian Creole (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Urdu (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Burmese (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Bosnian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Cebuano (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Chichewa (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Corsican (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Frisian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Scottish Gaelic (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Hausa (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Hawaian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Hmong (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Igbo (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Javanese (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Kazakh (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Khmer (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Kurdish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Kyrgyz (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Lao (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Luxembourgish (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Malagasy (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Malayalam (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Maori (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Marathi (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Mongolian (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Nepali (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Pashto (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Punjabi (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Samoan (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Sesotho (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Shona (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Sindhi (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Sinhala (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Somali (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Sundanese (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Swahili (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Tajik (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Uzbek (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Xhosa (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Yoruba (Google Translate)", 'instamatic-instagram-post-generator'),
           esc_html__("Zulu (Google Translate)", 'instamatic-instagram-post-generator')
       );
       $language_codes = array(
           "disabled",
           "af",
           "sq",
           "ar",
           "am",
           "hy",
           "be",
           "bg",
           "ca",
           "zh-CN",
           "hr",
           "cs",
           "da",
           "nl",
           "en",
           "et",
           "tl",
           "fi",
           "fr",
           "gl",
           "de",
           "el",
           "iw",
           "hi",
           "hu",
           "is",
           "id",
           "ga",
           "it",
           "ja",
           "ko",
           "lv",
           "lt",
           "no",
           "mk",
           "ms",
           "mt",
           "fa",
           "pl",
           "pt",
           "ro",
           "ru",
           "sr",
           "sk",
           "sl",
           "es",
           "sw",
           "sv",   
           "th",
           "tr",
           "uk",
           "vi",
           "cy",
           "yi",
           "ta",
           "az",
           "kn",
           "eu",
           "bn",
           "la",
           "zh-TW",
           "eo",
           "ka",
           "te",
           "gu",
           "ht",
           "ur",
           "my",
           "bs",
           "ceb",
           "ny",
           "co",
           "fy",
           "gd",
           "ha",
           "haw",
           "hmn",
           "ig",
           "jw",
           "kk",
           "km",
           "ku",
           "ky",
           "lo",
           "lb",
           "mg",
           "ml",
           "mi",
           "mr",
           "mn",
           "ne",
           "ps",
           "pa",
           "sm",
           "st",
           "sn",
           "sd",
           "si",
           "so",
           "su",
           "sw",
           "tg",
           "uz",
           "xh",
           "yo",
           "zu"
       );
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
   <div>
      <?php
         $auth = false;
         $error = 'General Error';
         
         ?>
      <form id="myForm" method="post" action="<?php if(is_multisite() && is_network_admin()){echo '../options.php';}else{echo 'options.php';}?>">
         <div class="cr_autocomplete">
            <input type="password" id="PreventChromeAutocomplete" 
               name="PreventChromeAutocomplete" autocomplete="address-level4" />
         </div>
         <?php
            settings_fields('instamatic_option_group');
            do_settings_sections('instamatic_option_group');
            if (isset($instamatic_Main_Settings['instamatic_enabled'])) {
                $instamatic_enabled = $instamatic_Main_Settings['instamatic_enabled'];
            } else {
                $instamatic_enabled = '';
            }
            if (isset($instamatic_Main_Settings['enable_metabox'])) {
                $enable_metabox = $instamatic_Main_Settings['enable_metabox'];
            } else {
                $enable_metabox = '';
            }
            if (isset($instamatic_Main_Settings['secret_word'])) {
                $secret_word = $instamatic_Main_Settings['secret_word'];
            } else {
                $secret_word = '';
            }
            if (isset($instamatic_Main_Settings['sentence_list'])) {
                $sentence_list = $instamatic_Main_Settings['sentence_list'];
            } else {
                $sentence_list = '';
            }
            if (isset($instamatic_Main_Settings['sentence_list2'])) {
                $sentence_list2 = $instamatic_Main_Settings['sentence_list2'];
            } else {
                $sentence_list2 = '';
            }
            if (isset($instamatic_Main_Settings['variable_list'])) {
                $variable_list = $instamatic_Main_Settings['variable_list'];
            } else {
                $variable_list = '';
            }
            if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                $enable_detailed_logging = $instamatic_Main_Settings['enable_detailed_logging'];
            } else {
                $enable_detailed_logging = '';
            }
            if (isset($instamatic_Main_Settings['enable_logging'])) {
                $enable_logging = $instamatic_Main_Settings['enable_logging'];
            } else {
                $enable_logging = '';
            }
            if (isset($instamatic_Main_Settings['auto_clear_logs'])) {
                $auto_clear_logs = $instamatic_Main_Settings['auto_clear_logs'];
            } else {
                $auto_clear_logs = '';
            }
            if (isset($instamatic_Main_Settings['rule_timeout'])) {
                $rule_timeout = $instamatic_Main_Settings['rule_timeout'];
            } else {
                $rule_timeout = '';
            }
            if (isset($instamatic_Main_Settings['disable_scripts'])) {
                $disable_scripts = $instamatic_Main_Settings['disable_scripts'];
            } else {
                $disable_scripts = '';
            }
            if (isset($instamatic_Main_Settings['strip_links'])) {
                $strip_links = $instamatic_Main_Settings['strip_links'];
            } else {
                $strip_links = '';
            }
            if (isset($instamatic_Main_Settings['get_more'])) {
                $get_more = $instamatic_Main_Settings['get_more'];
            } else {
                $get_more = '';
            }
            if (isset($instamatic_Main_Settings['one_import'])) {
                $one_import = $instamatic_Main_Settings['one_import'];
            } else {
                $one_import = '';
            }
            if (isset($instamatic_Main_Settings['send_email'])) {
                $send_email = $instamatic_Main_Settings['send_email'];
            } else {
                $send_email = '';
            }
            if (isset($instamatic_Main_Settings['rule_delay'])) {
                $rule_delay = $instamatic_Main_Settings['rule_delay'];
            } else {
                $rule_delay = '';
            }
            if (isset($instamatic_Main_Settings['proxy_url'])) {
                $proxy_url = $instamatic_Main_Settings['proxy_url'];
            } else {
                $proxy_url = '';
            }
            if (isset($instamatic_Main_Settings['proxy_auth'])) {
                $proxy_auth = $instamatic_Main_Settings['proxy_auth'];
            } else {
                $proxy_auth = '';
            }
            if (isset($instamatic_Main_Settings['post_source_custom'])) {
                $post_source_custom = $instamatic_Main_Settings['post_source_custom'];
            } else {
                $post_source_custom = '';
            }
            if (isset($instamatic_Main_Settings['email_address'])) {
                $email_address = $instamatic_Main_Settings['email_address'];
            } else {
                $email_address = '';
            }
            if (isset($instamatic_Main_Settings['default_types_fb'])) {
                $default_types_fb = $instamatic_Main_Settings['default_types_fb'];
            } else {
                $default_types_fb = '';
            }
            if (isset($instamatic_Main_Settings['translate'])) {
                $translate = $instamatic_Main_Settings['translate'];
            } else {
                $translate = '';
            }
            if (isset($instamatic_Main_Settings['translate_source'])) {
                $translate_source = $instamatic_Main_Settings['translate_source'];
            } else {
                $translate_source = '';
            }
            if (isset($instamatic_Main_Settings['spin_text'])) {
                $spin_text = $instamatic_Main_Settings['spin_text'];
            } else {
                $spin_text = '';
            }
            if (isset($instamatic_Main_Settings['google_trans_auth'])) {
                $google_trans_auth = $instamatic_Main_Settings['google_trans_auth'];
            } else {
                $google_trans_auth = '';
            }
            if (isset($instamatic_Main_Settings['best_user'])) {
                $best_user = $instamatic_Main_Settings['best_user'];
            } else {
                $best_user = '';
            }
            if (isset($instamatic_Main_Settings['best_password'])) {
                $best_password = $instamatic_Main_Settings['best_password'];
            } else {
                $best_password = '';
            }
            if (isset($instamatic_Main_Settings['phantom_path'])) {
                $phantom_path = $instamatic_Main_Settings['phantom_path'];
            } else {
                $phantom_path = '';
            }
            if (isset($instamatic_Main_Settings['screenshot_width'])) {
                $screenshot_width = $instamatic_Main_Settings['screenshot_width'];
            } else {
                $screenshot_width = '';
            }
            if (isset($instamatic_Main_Settings['screenshot_height'])) {
                $screenshot_height = $instamatic_Main_Settings['screenshot_height'];
            } else {
                $screenshot_height = '';
            }
            if (isset($instamatic_Main_Settings['phantom_screen'])) {
                $phantom_screen = $instamatic_Main_Settings['phantom_screen'];
            } else {
                $phantom_screen = '';
            }
            if (isset($instamatic_Main_Settings['puppeteer_screen'])) {
                $puppeteer_screen = $instamatic_Main_Settings['puppeteer_screen'];
            } else {
                $puppeteer_screen = '';
            }
            if (isset($instamatic_Main_Settings['min_word_title'])) {
                $min_word_title = $instamatic_Main_Settings['min_word_title'];
            } else {
                $min_word_title = '';
            }
            if (isset($instamatic_Main_Settings['max_word_title'])) {
                $max_word_title = $instamatic_Main_Settings['max_word_title'];
            } else {
                $max_word_title = '';
            }
            if (isset($instamatic_Main_Settings['min_word_content'])) {
                $min_word_content = $instamatic_Main_Settings['min_word_content'];
            } else {
                $min_word_content = '';
            }
            if (isset($instamatic_Main_Settings['max_word_content'])) {
                $max_word_content = $instamatic_Main_Settings['max_word_content'];
            } else {
                $max_word_content = '';
            }
            if (isset($instamatic_Main_Settings['required_words'])) {
                $required_words = $instamatic_Main_Settings['required_words'];
            } else {
                $required_words = '';
            }
            if (isset($instamatic_Main_Settings['banned_words'])) {
                $banned_words = $instamatic_Main_Settings['banned_words'];
            } else {
                $banned_words = '';
            }
            if (isset($instamatic_Main_Settings['skip_old'])) {
                $skip_old = $instamatic_Main_Settings['skip_old'];
            } else {
                $skip_old = '';
            }
            if (isset($instamatic_Main_Settings['skip_day'])) {
                $skip_day = $instamatic_Main_Settings['skip_day'];
            } else {
                $skip_day = '';
            }
            if (isset($instamatic_Main_Settings['skip_month'])) {
                $skip_month = $instamatic_Main_Settings['skip_month'];
            } else {
                $skip_month = '';
            }
            if (isset($instamatic_Main_Settings['skip_year'])) {
                $skip_year = $instamatic_Main_Settings['skip_year'];
            } else {
                $skip_year = '';
            }
            if (isset($instamatic_Main_Settings['custom_html2'])) {
                $custom_html2 = $instamatic_Main_Settings['custom_html2'];
            } else {
                $custom_html2 = '';
            }
            if (isset($instamatic_Main_Settings['custom_html'])) {
                $custom_html = $instamatic_Main_Settings['custom_html'];
            } else {
                $custom_html = '';
            }
            if (isset($instamatic_Main_Settings['skip_no_img'])) {
                $skip_no_img = $instamatic_Main_Settings['skip_no_img'];
            } else {
                $skip_no_img = '';
            }
            if (isset($instamatic_Main_Settings['gapiKey'])) {
                $gapiKey = $instamatic_Main_Settings['gapiKey'];
            } else {
                $gapiKey = '';
            }
            if (isset($instamatic_Main_Settings['links_hide_google2'])) {
                $links_hide_google2 = $instamatic_Main_Settings['links_hide_google2'];
            } else {
                $links_hide_google2 = '';
            }
            if (isset($instamatic_Main_Settings['links_hide_google'])) {
                $links_hide_google = $instamatic_Main_Settings['links_hide_google'];
            } else {
                $links_hide_google = '';
            }
            if (isset($instamatic_Main_Settings['strip_by_id'])) {
                $strip_by_id = $instamatic_Main_Settings['strip_by_id'];
            } else {
                $strip_by_id = '';
            }
            if (isset($instamatic_Main_Settings['strip_by_class'])) {
                $strip_by_class = $instamatic_Main_Settings['strip_by_class'];
            } else {
                $strip_by_class = '';
            }
            if (isset($instamatic_Main_Settings['app_id'])) {
                $app_id = $instamatic_Main_Settings['app_id'];
            } else {
                $app_id = '';
            }
            if (isset($instamatic_Main_Settings['app_secret'])) {
                $app_secret = $instamatic_Main_Settings['app_secret'];
            } else {
                $app_secret = '';
            }
            if (isset($instamatic_Main_Settings['two_code'])) {
                $two_code = $instamatic_Main_Settings['two_code'];
            } else {
                $two_code = '';
            }
            if (isset($instamatic_Main_Settings['skip_types'])) {
                $skip_types = $instamatic_Main_Settings['skip_types'];
            } else {
                $skip_types = '';
            }
            if (isset($instamatic_Main_Settings['resize_width'])) {
                $resize_width = $instamatic_Main_Settings['resize_width'];
            } else {
                $resize_width = '';
            }
            if (isset($instamatic_Main_Settings['resize_height'])) {
                $resize_height = $instamatic_Main_Settings['resize_height'];
            } else {
                $resize_height = '';
            }
            if (isset($instamatic_Main_Settings['no_local_image'])) {
                $no_local_image = $instamatic_Main_Settings['no_local_image'];
            } else {
                $no_local_image = '';
            }
            if (isset($instamatic_Main_Settings['copy_images'])) {
                $copy_images = $instamatic_Main_Settings['copy_images'];
            } else {
                $copy_images = '';
            }
            if (isset($_GET['settings-updated'])) {
            ?>
         <div id="message" class="updated">
            <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Settings saved.', 'instamatic-instagram-post-generator');?></strong></p>
         </div>
         <?php
            $get = get_option('coderevolution_settings_changed', 0);
            if($get == 1)
            {
                delete_option('coderevolution_settings_changed');
            ?>
         <div id="message" class="updated">
            <p class="cr_failed_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration failed!', 'instamatic-instagram-post-generator');?></strong></p>
         </div>
         <?php 
            }
            elseif($get == 2)
            {
                    delete_option('coderevolution_settings_changed');
            ?>
         <div id="message" class="updated">
            <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration successful!', 'instamatic-instagram-post-generator');?></strong></p>
         </div>
         <?php 
            }
            elseif($get != 0)
            {
                    delete_option('coderevolution_settings_changed');
            ?>
         <div id="message" class="updated">
            <p class="cr_failed_notif"><strong>&nbsp;<?php echo esc_html($get);?></strong></p>
         </div>
         <?php 
            }
                }
            $login_try = get_option('instamatic_login_try', false);
            if($login_try !== false)
            {
                delete_option('instamatic_login_try');
                if($login_try == 'Login successful.')
                {
                    ?>
                     <div id="message" class="updated">
                        <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Instagram Login Result: Login successful. The plugin will be able to publish posts to Instagram!', 'instamatic-instagram-post-generator');?></strong></p>
                     </div>
                     <?php 
                }
                else
                {
                    ?>
                     <div id="message" class="updated">
                        <p class="cr_failed_notif"><strong>&nbsp;<?php echo esc_html__('Instagram Login Result: ', 'instamatic-instagram-post-generator'). esc_html($login_try);?></strong></p>
                     </div>
                     <?php
                }
            }
            ?>
         <div>
            <div class="instamatic_class">
               <table class="widefat">
                  <tr>
                     <td>
                        <h1>
                           <span class="gs-sub-heading"><b>iMediamatic Automatic Post Generator Plugin - <?php echo esc_html__('Main Switch:', 'instamatic-instagram-post-generator');?></b>&nbsp;</span>
                           <span class="cr_07_font">v1.8&nbsp;</span>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Enable or disable this plugin. This acts like a main switch.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                        </h1>
                     </td>
                     <td>
                        <div class="slideThree">	
                           <input class="input-checkbox" type="checkbox" id="instamatic_enabled" name="instamatic_Main_Settings[instamatic_enabled]"<?php
                              if ($instamatic_enabled == 'on')
                                  echo ' checked ';
                              ?>>
                           <label for="instamatic_enabled"></label>
                        </div>
                     </td>
                  </tr>
               </table>
            </div>
            <div><?php if($instamatic_enabled != 'on'){echo '<div class="crf_bord cr_color_red cr_auto_update">' . esc_html__('This feature of the plugin is disabled! Please enable it from the above switch.', 'instamatic-instagram-post-generator') . '</div>';}?>
               <table class="widefat">
                  <tr>
                     <td colspan="2">
                        <?php
                           $plugin = plugin_basename(__FILE__);
                           $plugin_slug = explode('/', $plugin);
                           $plugin_slug = $plugin_slug[0]; 
                           $uoptions = get_option($plugin_slug . '_registration', array());
                           if(isset($uoptions['item_id']) && isset($uoptions['item_name']) && isset($uoptions['created_at']) && isset($uoptions['buyer']) && isset($uoptions['licence']) && isset($uoptions['supported_until']))
                           {
                           ?>
                        <h3><b><?php echo esc_html__("Plugin Registration Info - Automatic Updates Enabled:", 'instamatic-instagram-post-generator');?></b> </h3>
                        <ul>
                           <li><b><?php echo esc_html__("Item Name:", 'instamatic-instagram-post-generator');?></b> <?php echo esc_html($uoptions['item_name']);?></li>
                           <li>
                              <b><?php echo esc_html__("Item ID:", 'instamatic-instagram-post-generator');?></b> <?php echo esc_html($uoptions['item_id']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Created At:", 'instamatic-instagram-post-generator');?></b> <?php echo esc_html($uoptions['created_at']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Buyer Name:", 'instamatic-instagram-post-generator');?></b> <?php echo esc_html($uoptions['buyer']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("License Type:", 'instamatic-instagram-post-generator');?></b> <?php echo esc_html($uoptions['licence']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Supported Until:", 'instamatic-instagram-post-generator');?></b> <?php echo esc_html($uoptions['supported_until']);?>
                           </li>
                           <li>
                              <input type="submit" onclick="unsaved = false;" class="button button-primary" name="<?php echo esc_html($plugin_slug);?>_revoke_license" value="<?php echo esc_html__("Revoke License", 'instamatic-instagram-post-generator');?>">
                           </li>
                        </ul>
                        <?php
                           }
                           else
                           {
                           ?>
                        <div class="notice notice-error is-dismissible"><p><?php echo esc_html__("This is a trial version of the plugin. Automatic updates for this plugin are disabled. Please activate the plugin from below, so you can benefit of automatic updates for it!", 'instamatic-instagram-post-generator');?></p></div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo sprintf( wp_kses( __( 'Please input your Envato purchase code, to enable automatic updates in the plugin. To get your purchase code, please follow <a href="%s" target="_blank">this tutorial</a>. Info submitted to the registration server consists of: purchase code, site URL, site name, admin email. All these data will be used strictly for registration purposes.', 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' ) );
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Register Envato Purchase Code To Enable Automatic Updates:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td><input type="text" name="<?php echo esc_html($plugin_slug);?>_register_code" value="" placeholder="<?php echo esc_html__("Envato Purchase Code", 'instamatic-instagram-post-generator');?>"></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td><input type="submit" name="<?php echo esc_html($plugin_slug);?>_register" id="<?php echo esc_html($plugin_slug);?>_register" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Register Purchase Code", 'instamatic-instagram-post-generator');?>"/>
                        <?php
                           }
                           ?>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <hr/>
                     </td>
                     <td>
                        <hr/>
                     </td>
                  </tr>
               <tr><td colspan="2">
               <h3>
                  <ul>
                     <li><?php echo sprintf( wp_kses( __( 'Need help configuring this plugin? Please check out it\'s <a href="%s" target="_blank">video tutorial</a>.', 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.youtube.com/watch?v=cbgm_8FZQZg' ) );?>
                     </li>
                     <li><?php echo sprintf( wp_kses( __( 'Having issues with the plugin? Please be sure to check out our <a href="%s" target="_blank">knowledge-base</a> before you contact <a href="%s" target="_blank">our support</a>!', 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base' ), esc_url('//coderevolution.ro/support' ) );?></li>
                     <li><?php echo sprintf( wp_kses( __( 'Do you enjoy our plugin? Please give it a <a href="%s" target="_blank">rating</a>  on CodeCanyon, or check <a href="%s" target="_blank">our website</a>  for other cool plugins.', 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//codecanyon.net/downloads' ), esc_url( 'https://coderevolution.ro' ) );?></a></li>
                     <li><br/><br/><span class="cr_color_red"><?php echo esc_html__("Are you looking for a cool new theme that best fits this plugin?", 'instamatic-instagram-post-generator');?></span> <a onclick="revealRec()" class="cr_cursor_pointer"><?php echo esc_html__("Click here for our theme related recommendation", 'instamatic-instagram-post-generator');?></a>.
                        <br/><span id="diviIdrec"></span>
                     </li>
                  </ul>
               </h3>
               <hr/>
               <?php
                  if($instamatic_Main_Settings['app_id'] == '' || $instamatic_Main_Settings['app_secret'] == '')
                  {
                  ?>
               <div class="hideInfo">
                  <h2><b><span class="cr_color_red"><?php echo sprintf( wp_kses( __( 'Info: You have to create an Instagram account before filling the following details (if you do not have one). Please click <a href="%s" target="_blank">here</a> to create a new Instagram Account. <br/>Also, please note that after you inserted your credentials in the plugin, you must go to <a href="%s" target="_blank">instagram.com</a> and login. You will be asked if you logged in from a different device recently. Approve that it was you, otherwise this plugin will not function.', 'instamatic-instagram-post-generator'), array(  'br' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.instagram.com/accounts/emailsignup' ), esc_url( 'https://www.instagram.com' ) );?></span></b></h2>
               </div>
               <?php
                  }
                  ?>
               <table class="widefat">
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your Instagram User Name.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Instagram User Name:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="app_id" name="instamatic_Main_Settings[app_id]" value="<?php
                              echo esc_html($app_id);
                              ?>" placeholder="<?php echo esc_html__("Please insert your Instagram ID", 'instamatic-instagram-post-generator');?>" >
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your Instagram User Password. Your password is stored securely, in an encrypted form.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Instagram Password:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" id="app_secret" name="instamatic_Main_Settings[app_secret]" value="<?php
                              echo instamatic_encrypt_decrypt('decrypt', $app_secret);
                              ?>" placeholder="<?php echo esc_html__("Please insert your Instagram Password", 'instamatic-instagram-post-generator');?>" >
                           <input type="hidden" id="app_encrypt" name="instamatic_Main_Settings[app_encrypt]" value="yes">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td></td>
                     <td><input type="submit" name="btnSubmitApp" id="btnSubmitApp" class="button button-primary" onclick="unsaved = false;" value="Save User Info"/>&nbsp;&nbsp;&nbsp;
                     <input type="submit" name="btnCheckApp" id="btnCheckApp" class="button button-primary" onclick="unsaved = false;" value="Try Instagram Login"/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <hr/>
                     </td>
                     <td>
                        <hr/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your Instagram two factor verification code. This is usable only with the new login method from the plugin. This should be entered only if you are required to use a two factor verification code.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Instagram Two Factor Verification Code (Optional):", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="two_code" name="instamatic_Main_Settings[two_code]" value="<?php
                              echo esc_attr($two_code);
                              ?>" placeholder="<?php echo esc_html__("Please insert your Instagram Two Factor Code", 'instamatic-instagram-post-generator');?>" >
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td></td>
                     <td><input type="submit" name="verifyTwoFactor" id="verifyTwoFactor" class="button button-primary" onclick="unsaved = false;" value="Verify Two Factor Code"/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <hr/>
                     </td>
                     <td>
                        <hr/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <h3><?php echo esc_html__("After you entered the User Name and Password, you can start creating rules:", 'instamatic-instagram-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td><a name="newest" href="admin.php?page=instamatic_items_panel">- Instagram -> <?php echo esc_html__("Blog Posts", 'instamatic-instagram-post-generator');?> </a></td>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Posts will be generated from the latest entries in Instagram public groups or pages. Note that private Instagram profiles are not supported and no posts will be generated from them (Instagram restriction).", 'instamatic-instagram-post-generator');
                                 ?>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td><a name="user" href="admin.php?page=instamatic_Instagram_panel">- <?php echo esc_html__("Blog Posts", 'instamatic-instagram-post-generator');?> -> Instagram -</a></td>
                     <td>
                        (<?php echo esc_html__("using latest published posts from your blog", 'instamatic-instagram-post-generator');?>)
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Instagram posts will be generated from the latest published blog posts. Posts will be posted by the Instagram user entered.", 'instamatic-instagram-post-generator');
                                 ?>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <hr/>
                     </td>
                     <td>
                        <hr/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <h3><?php echo esc_html__("Plugin Options:", 'instamatic-instagram-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to get more info about imported posts? Note that this will slow down rule importing considerably.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Get More Information About Imported Posts:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="get_more" name="instamatic_Main_Settings[get_more]"<?php
                        if ($get_more == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose this option to import posts only once to this blog (also if the post was deleted after importing).", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Import Posts Only Once:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="one_import" name="instamatic_Main_Settings[one_import]"<?php
                        if ($one_import == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to strip links from the generated post content.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip Links From Generated Post Content:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="strip_links" name="instamatic_Main_Settings[strip_links]"<?php
                        if ($strip_links == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select a secret word that will be used when you run the plugin manually/by cron. See details about this below.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Secret Word Used For Manual/Cron Running:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="text" id="secret_word" name="instamatic_Main_Settings[secret_word]" value="<?php echo esc_html($secret_word);?>" placeholder="<?php echo esc_html__("Input a secret word", 'instamatic-instagram-post-generator');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div>
                           <br/><b><?php echo esc_html__("If you want to schedule the cron event manually in your server, you should schedule this address:", 'instamatic-instagram-post-generator');?> <span class="cr_red"><?php if($secret_word != '') { echo get_site_url() . '/?run_instamatic=' . urlencode($secret_word);} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'instamatic-instagram-post-generator'); }?></span><br/><?php echo esc_html__("Example:", 'instamatic-instagram-post-generator');?> <span class="cr_red"><?php if($secret_word != '') { echo '15,45****wget -q -O /dev/null ' . get_site_url() . '/?run_instamatic=' . urlencode($secret_word);} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'instamatic-instagram-post-generator'); }?></span></b>
                        </div>
                        <br/><br/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to show an extended information metabox under every plugin generated post.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show Extended Item Information Metabox in Post:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_metabox" name="instamatic_Main_Settings[enable_metabox]"<?php
                        if ($enable_metabox == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                    <td>
                       <div>
                          <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                             <div class="bws_hidden_help_text cr_min_260px">
                                <?php
                                   echo sprintf( wp_kses( __( "If you wish to use the official version of the Google Translator API for translation, you must enter first a Google API Key. Get one <a href='%s' target='_blank'>here</a>.  Please enable the 'Cloud Translation API' in <a href='%s' target='_blank'>Google Cloud Console</a>. Translation will work even without even without entering an API key here, but in this case, an unofficial Google Translate API will be used.", 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://console.cloud.google.com/apis/credentials' ), esc_url( 'https://console.cloud.google.com/marketplace/browse?q=translate' ) );
                                   ?>
                             </div>
                          </div>
                          <b><a href="https://console.cloud.google.com/apis/credentials" target="_blank"><?php echo esc_html__("Google Translator API Key (Optional)", 'instamatic-instagram-post-generator');?>:</a></b>
                       </div>
                    </td>
                    <td>
                       <div>
                          <input type="password" autocomplete="off" id="google_trans_auth" placeholder="<?php echo esc_html__("API Key (optional)", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[google_trans_auth]" value="<?php
                             echo esc_html($google_trans_auth);
                             ?>"/>
                       </div>
                    </td>
                 </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to enable logging for rules?", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Logging for Rules:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_logging" name="instamatic_Main_Settings[enable_logging]" onclick="mainChanged()"<?php
                        if ($enable_logging == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideLog">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to enable detailed logging for rules? Note that this will dramatically increase the size of the log this plugin generates.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Detailed Logging for Rules:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideLog">
                           <input type="checkbox" id="enable_detailed_logging" name="instamatic_Main_Settings[enable_detailed_logging]"<?php
                              if ($enable_detailed_logging == 'on')
                                  echo ' checked ';
                              ?>>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideLog">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to automatically clear logs after a period of time.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Automatically Clear Logs After:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideLog">
                           <select id="auto_clear_logs" name="instamatic_Main_Settings[auto_clear_logs]" >
                              <option value="No"<?php
                                 if ($auto_clear_logs == "No") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Disabled", 'instamatic-instagram-post-generator');?></option>
                              <option value="monthly"<?php
                                 if ($auto_clear_logs == "monthly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a month", 'instamatic-instagram-post-generator');?></option>
                              <option value="weekly"<?php
                                 if ($auto_clear_logs == "weekly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a week", 'instamatic-instagram-post-generator');?></option>
                              <option value="daily"<?php
                                 if ($auto_clear_logs == "daily") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a day", 'instamatic-instagram-post-generator');?></option>
                              <option value="twicedaily"<?php
                                 if ($auto_clear_logs == "twicedaily") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Twice a day", 'instamatic-instagram-post-generator');?></option>
                              <option value="hourly"<?php
                                 if ($auto_clear_logs == "hourly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once an hour", 'instamatic-instagram-post-generator');?></option>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to disable automatic loading of Instagram related scripts in your pages. If you are using this plugin to just automatically publish your posts, you can check this checkbox.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Disabled Loading of Instagram Related Scripts:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="disable_scripts" name="instamatic_Main_Settings[disable_scripts]"<?php
                        if ($disable_scripts == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the timeout (in seconds) for every rule running. I recommend that you leave this field at it's default value (3600).", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Timeout for Rule Running (seconds):", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="rule_timeout" step="1" min="0" placeholder="<?php echo esc_html__("Input rule timeout in seconds", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[rule_timeout]" value="<?php
                              echo esc_html($rule_timeout);
                              ?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Define a number of seconds the plugin should wait between the rule running. Use this to not decrease the use of your server's resources. Leave blank to disable.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Delay Between Rule Running:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="0" step="1" name="instamatic_Main_Settings[rule_delay]" value="<?php echo esc_html($rule_delay);?>" placeholder="<?php echo esc_html__("delay (s)", 'instamatic-instagram-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to receive a summary of the rule running in an email.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Send Rule Running Summary in Email:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="send_email" name="instamatic_Main_Settings[send_email]" onchange="mainChanged()"<?php
                        if ($send_email == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideMail">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the email adress where you want to send the report. You can input more email addresses, separated by commas.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Email Address:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideMail">
                           <input type="email" id="email_address" placeholder="<?php echo esc_html__("Input a valid email adress", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[email_address]" value="<?php
                              echo esc_html($email_address);
                              ?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Define a custom comma separated list of custom post types from your WordPress installation, that will be used for each Instagram post type. The order of specifying post types must be: image, video. This will overwrite the 'Item Type' settings field from importing rule settings. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Default WordPress Post Types For Instagram Post Types:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="instamatic_Main_Settings[default_types_fb]" value="<?php
                              echo esc_html($default_types_fb);
                              ?>" placeholder="<?php echo esc_html__("Please insert a list of custom post types", 'instamatic-instagram-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you want to use a custom string for the 'Post Source' meta data assigned to posts, please input it here. If you will leave this blank, the default 'Post Source' value will be assigned to posts.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom 'Post Source' Post Meta Data:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="post_source_custom" placeholder="<?php echo esc_html__("Input a custom post source string", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[post_source_custom]" value="<?php echo esc_html($post_source_custom);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you want to use a proxy to crawl webpages, input it's address here. Required format: IP Address/URL:port. You can input a comma separated list of proxies.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Web Proxy Address List:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="proxy_url" placeholder="<?php echo esc_html__("Input web proxy url", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[proxy_url]" value="<?php echo esc_html($proxy_url);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you want to use a proxy to crawl webpages, and it requires authentification, input it's authentification details here. Required format: username:password. You can input a comma separated list of users/passwords. If a proxy does not have a user/password, please leave it blank in the list. Example: user1:pass1,user2:pass2,,user4:pass4.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Web Proxy Authentification:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="proxy_auth" placeholder="<?php echo esc_html__("Input web proxy auth", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[proxy_auth]" value="<?php echo esc_html($proxy_auth);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the minimum word count for post titles. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Minimum Title Word Count (Skip Post Otherwise):", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="min_word_title" step="1" placeholder="<?php echo esc_html__("Input the minimum word count for the title", 'instamatic-instagram-post-generator');?>" min="0" name="instamatic_Main_Settings[min_word_title]" value="<?php
                              echo esc_html($min_word_title);
                              ?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the maximum word count for post titles. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Maximum Title Word Count (Skip Post Otherwise):", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="max_word_title" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the title", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[max_word_title]" value="<?php
                              echo esc_html($max_word_title);
                              ?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the minimum word count for post content. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Minimum Content Word Count (Skip Post Otherwise):", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="min_word_content" step="1" min="0" placeholder="<?php echo esc_html__("Input the minimum word count for the content", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[min_word_content]" value="<?php
                              echo esc_html($min_word_content);
                              ?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the maximum word count for post content. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Maximum Content Word Count (Skip Post Otherwise):", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="max_word_content" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the content", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[max_word_content]" value="<?php
                              echo esc_html($max_word_content);
                              ?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do not include posts that's title or content contains at least one of these words. Separate words by comma. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Banned Words List:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="1" name="instamatic_Main_Settings[banned_words]" placeholder="<?php echo esc_html__("Do not generate posts that contain at least one of these words", 'instamatic-instagram-post-generator');?>"><?php
                        echo esc_textarea($banned_words);
                        ?></textarea>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do not include posts that's title or content does not contain at least one of these words. Separate words by comma. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Required Words List:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="1" name="instamatic_Main_Settings[required_words]" placeholder="<?php echo esc_html__("Do not generate posts unless they contain all of these words", 'instamatic-instagram-post-generator');?>"><?php
                        echo esc_textarea($required_words);
                        ?></textarea>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Click this option if your want to set the featured image from the remote image location. This settings can save disk space, but beware that if the remote image gets deleted, your featured image will also be broken.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Do Not Copy Featured Image Locally:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="no_local_image" name="instamatic_Main_Settings[no_local_image]"<?php
                        if ($no_local_image == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Click this option if your want to save images found in post content locally. Note that this option may be heavy on your hosting free space.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Copy Images From Content Locally:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="copy_images" name="instamatic_Main_Settings[copy_images]"<?php
                        if ($copy_images == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Resize the image that was assigned to be the featured image to the width specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Width:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="instamatic_Main_Settings[resize_width]" value="<?php echo esc_html($resize_width);?>" placeholder="<?php echo esc_html__("Please insert the desired width for featured images", 'instamatic-instagram-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Resize the image that was assigned to be the featured image to the height specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Height:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="instamatic_Main_Settings[resize_height]" value="<?php echo esc_html($resize_height);?>" placeholder="<?php echo esc_html__("Please insert the desired height for featured images", 'instamatic-instagram-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Strip HTML elements from final content that have this IDs. You can insert more IDs, separeted by comma. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip HTML Elements from Final Content by ID:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="3" cols="70" name="instamatic_Main_Settings[strip_by_id]" placeholder="<?php echo esc_html__("Ids list", 'instamatic-instagram-post-generator');?>"><?php
                        echo esc_textarea($strip_by_id);
                        ?></textarea>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Strip HTML elements from final content that have this class. You can insert more classes, separeted by comma. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip HTML Elements from Final Content by Class:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="3" cols="70" name="instamatic_Main_Settings[strip_by_class]" placeholder="<?php echo esc_html__("Class list", 'instamatic-instagram-post-generator');?>"><?php
                        echo esc_textarea($strip_by_class);
                        ?></textarea>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your Bitly API generic access token. To register at Bitly, please visit <a href='%s' target='_blank'>this link</a>. To get a generic access token, please click the menu icon on the top right of the web (after you log in) -> click the '>' sign next to your account name -> click the 'Generic Access Token' menu entry -> enter your password in the 'Password' field and click 'Generate Token'. Copy the resulting token here. To lean more about this, please check <a href='%s' target='_blank'>this video</a>.", 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://bitly.com/a/sign_up?utm_content=site-free-button&utm_source=organic&utm_medium=website&utm_campaign=null&utm_cta=site-free-button' ), esc_url('//www.youtube.com/watch?v=vBfaNbS4xbs') );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Shorten Imported URLs To WordPress Using Bitly:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="links_hide_google" name="instamatic_Main_Settings[links_hide_google]" onclick="mainChanged()"<?php
                        if ($links_hide_google == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your Bitly API generic access token. To register at Bitly, please visit <a href='%s' target='_blank'>this link</a>. To get a generic access token, please click the menu icon on the top right of the web (after you log in) -> click the '>' sign next to your account name -> click the 'Generic Access Token' menu entry -> enter your password in the 'Password' field and click 'Generate Token'. Copy the resulting token here. To lean more about this, please check <a href='%s' target='_blank'>this video</a>.", 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://bitly.com/a/sign_up?utm_content=site-free-button&utm_source=organic&utm_medium=website&utm_campaign=null&utm_cta=site-free-button' ), esc_url('//www.youtube.com/watch?v=vBfaNbS4xbs') );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Shorten Exported URLs To Instagram Using Bitly:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="links_hide_google2" name="instamatic_Main_Settings[links_hide_google2]" onclick="mainChanged()"<?php
                        if ($links_hide_google2 == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideGoogl">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your Bitly API generic access token. To register at Bitly, please visit <a href='%s' target='_blank'>this link</a>. To get a generic access token, please click the menu icon on the top right of the web (after you log in) -> click the '>' sign next to your account name -> click the 'Generic Access Token' menu entry -> enter your password in the 'Password' field and click 'Generate Token'. Copy the resulting token here. To lean more about this, please check <a href='%s' target='_blank'>this video</a>.", 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://bitly.com/a/sign_up?utm_content=site-free-button&utm_source=organic&utm_medium=website&utm_campaign=null&utm_cta=site-free-button' ), esc_url('//www.youtube.com/watch?v=vBfaNbS4xbs') );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Bitly API key:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideGoogl">
                           <input type="password" name="instamatic_Main_Settings[gapiKey]" value="<?php echo esc_html($gapiKey);?>" placeholder="<?php echo esc_html__("Please insert your Bitly API key", 'instamatic-instagram-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to skip posts that do not have images.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Skip Posts That Do Not Have Images:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="skip_no_img" name="instamatic_Main_Settings[skip_no_img]"<?php
                        if ($skip_no_img == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Skip these Instagram post types when inserting blog posts. Valid values are: image and video. To disable this feature, leave this textfield blank.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Instagram Post Types to Skip:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="instamatic_Main_Settings[skip_types]" value="<?php
                              echo esc_html($skip_types);
                              ?>" placeholder="<?php echo esc_html__("Please insert the Instagram post types to skip", 'instamatic-instagram-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to skip posts that are older than a selected date.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Skip Posts Older Than a Selected Date:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="skip_old" name="instamatic_Main_Settings[skip_old]" onchange="mainChanged()"<?php
                        if ($skip_old == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class='hideOld'>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the date prior which you want to skip posts.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Select the Date for Old Posts:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class='hideOld'>
                           <?php echo esc_html__("Day:", 'instamatic-instagram-post-generator');?>
                           <select class="cr_width_80" name="instamatic_Main_Settings[skip_day]" >
                              <option value='01'<?php
                                 if ($skip_day == '01')
                                     echo ' selected';
                                 ?>>01</option>
                              <option value='02'<?php
                                 if ($skip_day == '02')
                                     echo ' selected';
                                 ?>>02</option>
                              <option value='03'<?php
                                 if ($skip_day == '03')
                                     echo ' selected';
                                 ?>>03</option>
                              <option value='04'<?php
                                 if ($skip_day == '04')
                                     echo ' selected';
                                 ?>>04</option>
                              <option value='05'<?php
                                 if ($skip_day == '05')
                                     echo ' selected';
                                 ?>>05</option>
                              <option value='06'<?php
                                 if ($skip_day == '06')
                                     echo ' selected';
                                 ?>>06</option>
                              <option value='07'<?php
                                 if ($skip_day == '07')
                                     echo ' selected';
                                 ?>>07</option>
                              <option value='08'<?php
                                 if ($skip_day == '08')
                                     echo ' selected';
                                 ?>>08</option>
                              <option value='09'<?php
                                 if ($skip_day == '09')
                                     echo ' selected';
                                 ?>>09</option>
                              <option value='10'<?php
                                 if ($skip_day == '10')
                                     echo ' selected';
                                 ?>>10</option>
                              <option value='11'<?php
                                 if ($skip_day == '11')
                                     echo ' selected';
                                 ?>>11</option>
                              <option value='12'<?php
                                 if ($skip_day == '12')
                                     echo ' selected';
                                 ?>>12</option>
                              <option value='13'<?php
                                 if ($skip_day == '13')
                                     echo ' selected';
                                 ?>>13</option>
                              <option value='14'<?php
                                 if ($skip_day == '14')
                                     echo ' selected';
                                 ?>>14</option>
                              <option value='15'<?php
                                 if ($skip_day == '15')
                                     echo ' selected';
                                 ?>>15</option>
                              <option value='16'<?php
                                 if ($skip_day == '16')
                                     echo ' selected';
                                 ?>>16</option>
                              <option value='17'<?php
                                 if ($skip_day == '17')
                                     echo ' selected';
                                 ?>>17</option>
                              <option value='18'<?php
                                 if ($skip_day == '18')
                                     echo ' selected';
                                 ?>>18</option>
                              <option value='19'<?php
                                 if ($skip_day == '19')
                                     echo ' selected';
                                 ?>>19</option>
                              <option value='20'<?php
                                 if ($skip_day == '20')
                                     echo ' selected';
                                 ?>>20</option>
                              <option value='21'<?php
                                 if ($skip_day == '21')
                                     echo ' selected';
                                 ?>>21</option>
                              <option value='22'<?php
                                 if ($skip_day == '22')
                                     echo ' selected';
                                 ?>>22</option>
                              <option value='23'<?php
                                 if ($skip_day == '23')
                                     echo ' selected';
                                 ?>>23</option>
                              <option value='24'<?php
                                 if ($skip_day == '24')
                                     echo ' selected';
                                 ?>>24</option>
                              <option value='25'<?php
                                 if ($skip_day == '25')
                                     echo ' selected';
                                 ?>>25</option>
                              <option value='26'<?php
                                 if ($skip_day == '26')
                                     echo ' selected';
                                 ?>>26</option>
                              <option value='27'<?php
                                 if ($skip_day == '27')
                                     echo ' selected';
                                 ?>>27</option>
                              <option value='28'<?php
                                 if ($skip_day == '28')
                                     echo ' selected';
                                 ?>>28</option>
                              <option value='29'<?php
                                 if ($skip_day == '29')
                                     echo ' selected';
                                 ?>>29</option>
                              <option value='30'<?php
                                 if ($skip_day == '30')
                                     echo ' selected';
                                 ?>>30</option>
                              <option value='31'<?php
                                 if ($skip_day == '31')
                                     echo ' selected';
                                 ?>>31</option>
                           </select>
                           <?php echo esc_html__("Month:", 'instamatic-instagram-post-generator');?>
                           <select class="cr_width_80" name="instamatic_Main_Settings[skip_month]" >
                              <option value='01'<?php
                                 if ($skip_month == '01')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("January", 'instamatic-instagram-post-generator');?></option>
                              <option value='02'<?php
                                 if ($skip_month == '02')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("February", 'instamatic-instagram-post-generator');?></option>
                              <option value='03'<?php
                                 if ($skip_month == '03')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("March", 'instamatic-instagram-post-generator');?></option>
                              <option value='04'<?php
                                 if ($skip_month == '04')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("April", 'instamatic-instagram-post-generator');?></option>
                              <option value='05'<?php
                                 if ($skip_month == '05')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("May", 'instamatic-instagram-post-generator');?></option>
                              <option value='06'<?php
                                 if ($skip_month == '06')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("June", 'instamatic-instagram-post-generator');?></option>
                              <option value='07'<?php
                                 if ($skip_month == '07')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("July", 'instamatic-instagram-post-generator');?></option>
                              <option value='08'<?php
                                 if ($skip_month == '08')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("August", 'instamatic-instagram-post-generator');?></option>
                              <option value='09'<?php
                                 if ($skip_month == '09')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("September", 'instamatic-instagram-post-generator');?></option>
                              <option value='10'<?php
                                 if ($skip_month == '10')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("October", 'instamatic-instagram-post-generator');?></option>
                              <option value='11'<?php
                                 if ($skip_month == '11')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("November", 'instamatic-instagram-post-generator');?></option>
                              <option value='12'<?php
                                 if ($skip_month == '12')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("December", 'instamatic-instagram-post-generator');?></option>
                           </select>
                           <?php echo esc_html__("Year:", 'instamatic-instagram-post-generator');?><input class="cr_width_70" value="<?php
                              echo esc_html($skip_year);
                              ?>" placeholder="<?php echo esc_html__("year", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[skip_year]" type="text" pattern="^\d{4}$">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to automatically translate generated content using Google Translate?", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Automatically Translate Content To:", 'instamatic-instagram-post-generator');?></b><br/><b><?php echo esc_html__("Info:", 'instamatic-instagram-post-generator');?></b> <?php echo esc_html__("for translation, the plugin also supports WPML.", 'instamatic-instagram-post-generator');?> <b><a href="https://wpml.org/?aid=238195&affiliate_key=ix3LsFyq0xKz" target="_blank"><?php echo esc_html__("Get WPML now!", 'instamatic-instagram-post-generator');?></a></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="translate" name="instamatic_Main_Settings[translate]" >
                           <?php
                              $i = 0;
                              foreach ($language_names as $lang) {
                                  echo '<option value="' . esc_html($language_codes[$i]) . '"';
                                  if ($translate == $language_codes[$i]) {
                                      echo ' selected';
                                  }
                                  echo '>' . esc_html($language_names[$i]) . '</option>';
                                  $i++;
                              }
                              ?>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the source language for the translation.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Translation Source Language:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="translate_source" name="instamatic_Main_Settings[translate_source]" >
                           <?php
                              $i = 0;
                              foreach ($language_names as $lang) {
                                  echo '<option value="' . esc_html($language_codes[$i]) . '"';
                                  if ($translate_source == $language_codes[$i]) {
                                      echo ' selected';
                                  }
                                  echo '>' . esc_html($language_names[$i]) . '</option>';
                                  $i++;
                              }
                              ?>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div id="bestspin">
                           <p><?php echo esc_html__("Don't have an 'The Best Spinner' account yet? Click here to get one:", 'instamatic-instagram-post-generator');?> <b><a href="https://paykstrt.com/10313/38910" target="_blank"><?php echo esc_html__("get a new account now!", 'instamatic-instagram-post-generator');?></a></b></p>
                        </div>
                        <div id="wordai">
                           <p><?php echo esc_html__("Don't have an 'WordAI' account yet? Click here to get one:", 'instamatic-instagram-post-generator');?> <b><a href="https://wordai.com/?ref=h17f4" target="_blank"><?php echo esc_html__("get a new account now!", 'instamatic-instagram-post-generator');?></a></b></p>
                        </div>
                        <div id="spinrewriter">
                           <p><?php echo esc_html__("Don't have an 'SpinRewriter' account yet? Click here to get one:", 'instamatic-instagram-post-generator');?> <b><a href="https://www.spinrewriter.com/?ref=24b18" target="_blank"><?php echo esc_html__("get a new account now!", 'instamatic-instagram-post-generator');?></a></b></p>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to randomize text by changing words of a text with synonyms using one of the listed methods? Note that this is an experimental feature and can in some instances drastically increase the rule running time!", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Spin Text Using Word Synonyms (for automatically generated posts only):", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <select id="spin_text" name="instamatic_Main_Settings[spin_text]" onchange="mainChanged()">
                     <option value="disabled"
                        <?php
                           if ($spin_text == 'disabled') {
                               echo ' selected';
                           }
                           ?>
                        ><?php echo esc_html__("Disabled", 'instamatic-instagram-post-generator');?></option>
                     <option value="best"
                        <?php
                           if ($spin_text == 'best') {
                               echo ' selected';
                           }
                           ?>
                        >The Best Spinner - <?php echo esc_html__("High Quality - Paid", 'instamatic-instagram-post-generator');?></option>
                     <option value="wordai"
                        <?php
                           if($spin_text == 'wordai')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        >Wordai - <?php echo esc_html__("High Quality - Paid", 'instamatic-instagram-post-generator');?></option>
                     <option value="spinrewriter"
                        <?php
                           if($spin_text == 'spinrewriter')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        >SpinRewriter - <?php echo esc_html__("High Quality - Paid", 'instamatic-instagram-post-generator');?></option>
                     <option value="builtin"
                        <?php
                           if ($spin_text == 'builtin') {
                               echo ' selected';
                           }
                           ?>
                        ><?php echo esc_html__("Built-in - Medium Quality - Free", 'instamatic-instagram-post-generator');?></option>
                     </select>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideBest">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your user name on premium spinner service.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Premium Spinner Service User Name/Email:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideBest">
                           <input type="text" name="instamatic_Main_Settings[best_user]" value="<?php
                              echo esc_html($best_user);
                              ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service user name", 'instamatic-instagram-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideBest">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your password for the selected premium spinner service.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Premium Spinner Service Password/API Key:", 'instamatic-instagram-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideBest">
                           <input type="password" autocomplete="off" name="instamatic_Main_Settings[best_password]" value="<?php
                              echo esc_html($best_password);
                              ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service password", 'instamatic-instagram-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("PhantomJS Settings:", 'instamatic-instagram-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to use phantomjs to generate the screenshot for the page, using the %%item_show_screenshot%% and %%item_screenshot_url%% shortcodes.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Use PhantomJs to Generate Screenshots (%%item_show_screenshot%%):", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="phantom_screen" name="instamatic_Main_Settings[phantom_screen]"<?php
                        if ($phantom_screen == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to use Puppeteer to generate the screenshot for the page, using the %%item_show_screenshot%% and %%item_screenshot_url%% shortcodes.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Use Puppeteer to Generate Screenshots (%%item_show_screenshot%%):", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="puppeteer_screen" name="instamatic_Main_Settings[puppeteer_screen]"<?php
                        if ($puppeteer_screen == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Set the path on your local server of the phantomjs executable. If you leave this field blank, the default 'phantomjs' call will be used. <a href='%s' target='_blank'>How to install PhantomJs?</a>", 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/" ));
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("PhantomJS Path On Server:", 'instamatic-instagram-post-generator');?></b>
<?php
                       if($phantom_path != '')
                       {
                           $phantom = instamatic_testPhantom();
                           if($phantom === 0)
                           {
                               echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS not found - please install it on your server or configure the path to it in plugin\'s \'Main Settings\'!', 'instamatic-instagram-post-generator') . '</b> <a href=\'//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/\' target=\'_blank\'>' . esc_html__('How to install PhantomJs?', 'instamatic-instagram-post-generator') . '</a></span>';
                           }
                           elseif($phantom === -1)
                           {
                               echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell_exec is not enabled on your server. Please enable it and retry using this feature of the plugin.', 'instamatic-instagram-post-generator') . '</b></span>';
                           }
                           elseif($phantom === -2)
                           {
                               echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell_exec is not allowed to run on your server (in disable_functions list in php.ini). Please enable it and retry using this feature of the plugin.', 'instamatic-instagram-post-generator') . '</b></span>';
                           }
                           elseif($phantom === 1)
                           {
                               echo '<br/><span class="cr_green12"><b>' . esc_html__('INFO: PhantomJS OK', 'instamatic-instagram-post-generator') . '</b></span>';
                           }
                       }
?>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="phantom_path" placeholder="<?php echo esc_html__("Path to phantomjs", 'instamatic-instagram-post-generator');?>" name="instamatic_Main_Settings[phantom_path]" value="<?php echo esc_html($phantom_path);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the width of the screenshot that will be generated for crawled pages. This will affect the content generated by the %%item_show_screenshot%% shortcode. The default is 600.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Page Screenshot Width:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="text" id="screenshot_width" name="instamatic_Main_Settings[screenshot_width]" value="<?php echo esc_html($screenshot_width);?>" placeholder="<?php echo esc_html__("600", 'instamatic-instagram-post-generator');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the height of the screenshot that will be generated for crawled pages. This will affect the content generated by the %%item_show_screenshot%% shortcode. The default is 450.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Page Screenshot Height:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <input type="text" id="screenshot_height" name="instamatic_Main_Settings[screenshot_height]" value="<?php echo esc_html($screenshot_height);?>" placeholder="<?php echo esc_html__("450", 'instamatic-instagram-post-generator');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <hr/>
                     </td>
                     <td>
                        <hr/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <h3><?php echo esc_html__("Random Sentence Generator Settings:", 'instamatic-instagram-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("First List of Possible Sentences (%%random_sentence%%):", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="8" cols="70" name="instamatic_Main_Settings[sentence_list]" placeholder="<?php echo esc_html__("Please insert the first list of sentences", 'instamatic-instagram-post-generator');?>"><?php
                        echo esc_textarea($sentence_list);
                        ?></textarea>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Second List of Possible Sentences (%%random_sentence2%%):", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="8" cols="70" name="instamatic_Main_Settings[sentence_list2]" placeholder="<?php echo esc_html__("Please insert the second list of sentences", 'instamatic-instagram-post-generator');?>"><?php
                        echo esc_textarea($sentence_list2);
                        ?></textarea>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert some variables you wish to be exchanged for different instances of one sentence. Please format this list as follows:<br/>
                                    Variablename => Variables (seperated by semicolon)<br/>Example:<br/>adjective => clever;interesting;smart;huge;astonishing;unbelievable;nice;adorable;beautiful;elegant;fancy;glamorous;magnificent;helpful;awesome<br/>", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("List of Possible Variables:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="8" cols="70" name="instamatic_Main_Settings[variable_list]" placeholder="<?php echo esc_html__("Please insert the list of variables", 'instamatic-instagram-post-generator');?>"><?php
                        echo esc_textarea($variable_list);
                        ?></textarea>
                     </div></td>
                  </tr>
                  <tr>
                     <td>
                        <hr/>
                     </td>
                     <td>
                        <hr/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <h3><?php echo esc_html__("Custom HTML Code/ Ad Code:", 'instamatic-instagram-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert a custom HTML code that will replace the %%custom_html%% variable. This can be anything, even an Ad code.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom HTML Code #1:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="3" cols="70" name="instamatic_Main_Settings[custom_html]" placeholder="<?php echo esc_html__("Custom HTML #1", 'instamatic-instagram-post-generator');?>"><?php
                        echo esc_textarea($custom_html);
                        ?></textarea>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert a custom HTML code that will replace the %%custom_html2%% variable. This can be anything, even an Ad code.", 'instamatic-instagram-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom HTML Code #2:", 'instamatic-instagram-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="3" cols="70" name="instamatic_Main_Settings[custom_html2]" placeholder="<?php echo esc_html__("Custom HTML #2", 'instamatic-instagram-post-generator');?>"><?php
                        echo esc_textarea($custom_html2);
                        ?></textarea>
                     </div>
                     </td>
                  </tr>
               </table>
               <hr/>
               <h3><?php echo esc_html__("Affiliate Keyword Replacer Tool Settings:", 'instamatic-instagram-post-generator');?></h3>
               <div class="table-responsive">
                  <table class="responsive table cr_main_table">
                     <thead>
                        <tr>
                           <th>
                              <?php echo esc_html__("ID", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This is the ID of the rule.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_max_width_40">
                              <?php echo esc_html__("Del", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to delete this rule?", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Search Keyword", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This keyword will be replaced with a link you define.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Replacement Keyword", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This keyword will replace the search keyword you define. Leave this field blank if you only want to add an URL to the specified keyword.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Link to Add", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Define the link you want to appear the defined keyword. Leave this field blank if you only want to replace the specified keyword without linking from it.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                        </tr>
                        <tr>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           echo instamatic_expand_keyword_rules();
                           ?>
                        <tr>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_short_td">-</td>
                           <td class="cr_shrt_td2"><span class="cr_gray20">X</span></td>
                           <td class="cr_rule_line"><input type="text" name="instamatic_keyword_list[keyword][]"  placeholder="<?php echo esc_html__("Please insert the keyword to be replaced", 'instamatic-instagram-post-generator');?>" value="" class="cr_width_100" /></td>
                           <td class="cr_rule_line"><input type="text" name="instamatic_keyword_list[replace][]"  placeholder="<?php echo esc_html__("Please insert the keyword to replace the search keyword", 'instamatic-instagram-post-generator');?>" value="" class="cr_width_100" /></td>
                           <td class="cr_rule_line"><input type="url" validator="url" name="instamatic_keyword_list[link][]" placeholder="<?php echo esc_html__("Please insert the link to be added to the keyword", 'instamatic-instagram-post-generator');?>" value="" class="cr_width_100" />
                        </tr>
                     </tbody>
                  </table>
               </div>
               </td></tr>
               </table>
            </div>
         </div>
   </div>
   <hr/>
   <div><p class="submit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'instamatic-instagram-post-generator');?>"/></p></div>
   </form>
   <p>
      <?php echo esc_html__("Available shortcode:", 'instamatic-instagram-post-generator');?> <strong>[instamatic-media]</strong> to include an Instagram media (photo or video). Usage: [instamatic-media v="Instagram post URL"]
   </p>
   <p>
      <?php echo esc_html__("Available shortcodes:", 'instamatic-instagram-post-generator');?> <strong>[instamatic-list-posts]</strong> <?php echo esc_html__("to include a list that contains only posts imported by this plugin, and", 'instamatic-instagram-post-generator');?> <strong>[instamatic-display-posts]</strong> <?php echo esc_html__("to include a WordPress like post listing. Usage:", 'instamatic-instagram-post-generator');?> [instamatic-display-posts type='any/post/page/...' title_color='#ffffff' excerpt_color='#ffffff' read_more_text="Read More" link_to_source='yes' order='ASC/DESC' orderby='title/ID/author/name/date/rand/comment_count' title_font_size='19px', excerpt_font_size='19px' posts_per_page=number_of_posts_to_show category='posts_category' ruleid='ID_of_instamatic_rule'].
      <br/><?php echo esc_html__("Example:", 'instamatic-instagram-post-generator');?> <b>[instamatic-list-posts type='any' order='ASC' orderby='date' posts_per_page=50 category= '' ruleid='0']</b>
      <br/><?php echo esc_html__("Example 2:", 'instamatic-instagram-post-generator');?> <b>[instamatic-display-posts include_excerpt='true' image_size='thumbnail' wrapper='div']</b>.
   </p>
</div>
<?php
   }
   if (isset($_POST['instamatic_keyword_list'])) {
       add_action('admin_init', 'instamatic_save_keyword_rules');
   }
   function instamatic_save_keyword_rules($data2)
   {
       $data2 = $_POST['instamatic_keyword_list'];
       $rules = array();
       if (isset($data2['keyword'][0])) {
           for ($i = 0; $i < sizeof($data2['keyword']); ++$i) {
               if (isset($data2['keyword'][$i]) && $data2['keyword'][$i] != '') {
                   $index         = trim(sanitize_text_field($data2['keyword'][$i]));
                   $rules[$index] = array(
                       trim(sanitize_text_field($data2['link'][$i])),
                       trim(sanitize_text_field($data2['replace'][$i]))
                   );
               }
           }
       }
       update_option('instamatic_keyword_list', $rules);
   }
   function instamatic_expand_keyword_rules()
   {
       $rules  = get_option('instamatic_keyword_list');
    if(!is_array($rules))
    {
       $rules = array();
    }
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
           foreach ($rules as $request => $value) {
               $output .= '<tr>
                           <td class="cr_short_td">' . esc_html($cont) . '</td>
                           <td class="cr_shrt_td2"><span class="wpinstamatic-delete">X</span></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the keyword to be replaced. This field is required', 'instamatic-instagram-post-generator') . '" name="instamatic_keyword_list[keyword][]" value="' . esc_html($request) . '" required class="cr_width_100"></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the replacement word', 'instamatic-instagram-post-generator') . '" name="instamatic_keyword_list[replace][]" value="' . esc_html($value[1]) . '" class="cr_width_100"></td>
                           <td class="cr_rule_line"><input type="url" validator="url" placeholder="' . esc_html__('Input the URL to be added', 'instamatic-instagram-post-generator') . '" name="instamatic_keyword_list[link][]" value="' . esc_html($value[0]) . '" class="cr_width_100"></td>
   					</tr>';
               $cont++;
           }
       }
       return $output;
   }
   ?>