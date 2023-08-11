<?php
   function instamatic_instagram_panel()
   {
   if(ini_get('allow_url_fopen')) {
   }
   else
   {
   ?>
<h1><span class="cr_red"><?php echo esc_html__("Warning! allow_url_fopen not enabled in your php.ini. Posting to Instagram will not work until you do not enable it!", 'instamatic-instagram-post-generator'); echo sprintf( wp_kses( __( ' For more info, please check <a href="%s" target="_blank">this link</a>.', 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base/faq/how-to-enable-allow_url_fopen-on-your-server/' ) );?></span></h1>
<?php
phpinfo();
   }
   ?>
<form id="myForm" method="post" action="<?php if(is_multisite() && is_network_admin()){echo '../options.php';}else{echo 'options.php';}?>">
   <?php
      settings_fields('instamatic_option_group2');
      do_settings_sections('instamatic_option_group2');
      $instamatic_Instagram_Settings = get_option('instamatic_Instagram_Settings', false);
      if (isset($instamatic_Instagram_Settings['instamatic_posting'])) {
          $instamatic_posting = $instamatic_Instagram_Settings['instamatic_posting'];
      } else {
          $instamatic_posting = '';
      }
      if (isset($instamatic_Instagram_Settings['instagram_format'])) {
          $instagram_format = $instamatic_Instagram_Settings['instagram_format'];
      } else {
          $instagram_format = '';
      }
      if (isset($instamatic_Instagram_Settings['post_posts'])) {
          $post_posts = $instamatic_Instagram_Settings['post_posts'];
      } else {
          $post_posts = '';
      }
      if (isset($instamatic_Instagram_Settings['post_pages'])) {
          $post_pages = $instamatic_Instagram_Settings['post_pages'];
      } else {
          $post_pages = '';
      }
      if (isset($instamatic_Instagram_Settings['disabled_categories'])) {
          $disabled_categories = $instamatic_Instagram_Settings['disabled_categories'];
      } else {
          $disabled_categories = '';
      }
      if (isset($instamatic_Instagram_Settings['disable_tags'])) {
          $disable_tags = $instamatic_Instagram_Settings['disable_tags'];
      } else {
          $disable_tags = '';
      }
      if (isset($instamatic_Instagram_Settings['skip_img'])) {
          $skip_img = $instamatic_Instagram_Settings['skip_img'];
      } else {
          $skip_img = '';
      }
      if (isset($instamatic_Instagram_Settings['post_custom'])) {
          $post_custom = $instamatic_Instagram_Settings['post_custom'];
      } else {
          $post_custom = '';
      }
      if (isset($instamatic_Instagram_Settings['always_manual'])) {
          $always_manual = $instamatic_Instagram_Settings['always_manual'];
      } else {
          $always_manual = '';
      }
      if (isset($instamatic_Instagram_Settings['delay_post'])) {
          $delay_post = $instamatic_Instagram_Settings['delay_post'];
      } else {
          $delay_post = '';
      }
      if (isset($instamatic_Instagram_Settings['run_background'])) {
          $run_background = $instamatic_Instagram_Settings['run_background'];
      } else {
          $run_background = '';
      }
      $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
      if(isset($instamatic_Main_Settings['app_id']) && $instamatic_Main_Settings['app_id'] != '')
      {
      if(isset($instamatic_Main_Settings['app_secret']) && $instamatic_Main_Settings['app_secret'] != '')
      {
      }
      else
      {
      ?>
   <h1><?php echo esc_html__("You must add a Instagram Password before you can use this feature!", 'instamatic-instagram-post-generator');?></h1>
   <?php
      return;
      }
      }
      else
      {
      ?>
   <h1><?php echo esc_html__("You must add a Instagram User Name and Password before you can use this feature!", 'instamatic-instagram-post-generator');?></h1>
   <?php
      return;
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
      ?>
   <div>
      <div class="instamatic_class">
         <table class="widefat">
            <tr>
               <td>
                  <h1>
                     <span class="gs-sub-heading"><b>iMediamatic Automatic Post to Instagram - <?php echo esc_html__('Main Switch:', 'instamatic-instagram-post-generator');?></b>&nbsp;</span>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Enable or disable automatic posting to Instagram every time you publish a new post (manually or automatically). Please note that only jpg images can be submitted to Instagram. Also, these need to be with aspect ratios between 1.91:1 and 4:5.", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                  </h1>
               </td>
               <td>
                  <div class="slideThree">	
                     <input class="input-checkbox" type="checkbox" id="instamatic_posting" name="instamatic_Instagram_Settings[instamatic_posting]"<?php
                        if ($instamatic_posting == 'on')
                            echo ' checked ';
                        ?>>
                     <label for="instamatic_posting"></label>
                  </div>
               </td>
            </tr>
         </table>
      </div>
      <div><?php if($instamatic_posting != 'on'){echo '<div class="crf_bord cr_color_red cr_auto_update">' . esc_html__('This feature of the plugin is disabled! Please enable it from the above switch.', 'instamatic-instagram-post-generator') . '</div>';}?>
         <hr/>
         <table class="widefat">
            <tr>
               <td>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Do you want delay posting with this amount of seconds from post publish? This will create a single cron job for each post (cron is a requirement for this to function). If you leave this field blank, posts will be automatically published on post creation.", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Delay Posting By (Seconds):", 'instamatic-instagram-post-generator');?></b>
               </td>
               <td>
               <input type="number" min="0" step="1" id="delay_post" name="instamatic_Instagram_Settings[delay_post]" class="cr_450" value="<?php echo esc_html($delay_post);?>" placeholder="Delay posting by X seconds">
               </div>
               </td>
            </tr>
            <tr>
               <td>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("This option will allow you to select if you want to run posting in async mode. This means that each time you publish a post, the plugin will try to execute it's task in the background - it will no longer block new post posting, while it finishes it's job.", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Use Async Posting Method:", 'instamatic-instagram-post-generator');?></b>
               </td>
               <td>
               <input type="checkbox" id="run_background" name="instamatic_Instagram_Settings[run_background]"<?php
                  if ($run_background == 'on')
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
                              echo esc_html__("Choose the template of your Instagram posts. You can use the following shortcodes: %%featured_image%%, %%post_cats%%, %%post_tags%%, %%blog_title%%, %%smart_hashtags%%, %%author_name%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%post_title%%, %%post_title_hashtags%%, %%post_content%%, %%post_excerpt%%", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Instagram Post Message Template:", 'instamatic-instagram-post-generator');?></b>
                  </div>
               </td>
               <td>
                  <div>
                     <textarea rows="4" name="instamatic_Instagram_Settings[instagram_format]" placeholder="Please insert your Instagram post template"><?php
                        echo esc_textarea($instagram_format);
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
                              echo esc_html__("Do you want to disable automatically posting of WordPress 'posts' to Instagram?", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Disable Autoposting of 'Posts':", 'instamatic-instagram-post-generator');?></b>
               </td>
               <td>
               <input type="checkbox" id="post_posts" name="instamatic_Instagram_Settings[post_posts]"<?php
                  if ($post_posts == 'on')
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
                              echo esc_html__("Do you want to disable automatically posting of WordPress 'pages' to Instagram?", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Disable Autoposting of 'Pages':", 'instamatic-instagram-post-generator');?></b>
               </td>
               <td>
               <input type="checkbox" id="post_pages" name="instamatic_Instagram_Settings[post_pages]"<?php
                  if ($post_pages == 'on')
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
                              echo esc_html__("Do you want to disable automatically posting of WordPress 'custom post types' to Instagram?", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Disable Autoposting of 'Custom Post Types':", 'instamatic-instagram-post-generator');?></b>
               </td>
               <td>
               <input type="checkbox" id="post_custom" name="instamatic_Instagram_Settings[post_custom]"<?php
                  if ($post_custom == 'on')
                      echo ' checked ';
                  ?>>
               </div>
               </td>
            </tr>
            <tr><td>
            <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
            <?php
               echo esc_html__("Do you want to always allow the publishing of manual posts, regardless if they meet the requirements from this page?", 'instamatic-instagram-post-generator');
               ?>
            </div>
            </div>
            <b><?php echo esc_html__("Always Allow Publishing of Manual Posts:", 'instamatic-instagram-post-generator');?></b>
            </td><td>
            <input type="checkbox" id="always_manual" name="instamatic_Instagram_Settings[always_manual]"<?php
               if ($always_manual == 'on')
                   echo ' checked ';
               ?>>
            </div>
            </td></tr><tr><td>
            <tr>
               <td>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Do you want to disable automatically posting of WordPress 'posts' to Instagram?", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Disable Autoposting of Selected Categories:", 'instamatic-instagram-post-generator');?></b><br/>
                     <a onclick="toggleCats()" class="cr_pointer"><?php echo esc_html__("Show/Hide Categories List", 'instamatic-instagram-post-generator');?></a>
               </td>
               <td>
               <br/>
               <div id="hideCats" class="hideCats">
               <?php
                  $cat_args   = array(
                      'orderby' => 'name',
                      'hide_empty' => 0,
                      'order' => 'ASC'
                  );
                  $categories = get_categories($cat_args);
                  foreach ($categories as $category) {
                  ?>
               <div>
               <label>
               <input
                  <?php
                     if (isset($instamatic_Instagram_Settings['disabled_categories']) && !empty($instamatic_Instagram_Settings['disabled_categories'])) {
                         checked(true, in_array($category->term_id, $instamatic_Instagram_Settings['disabled_categories']));
                     }
                     ?>
                  type="checkbox" name="instamatic_Instagram_Settings[disabled_categories][]" value="<?php
                     echo esc_html($category->term_id);
                     ?>" /> 
               <span><?php
                  echo esc_html(sanitize_text_field($category->name));
                  ?></span>
               </label>
               </div>
               <?php
                  }
                  ?>
               </div>
               </div>
               </td>
            </tr>
            <tr>
               <td>
                  <div>
                     <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                        <div class="bws_hidden_help_text cr_min_260px">
                           <?php
                              echo esc_html__("Input the tags for which you want to disable posting. You can enter more tags, separated by comma. Ex: cars, vehicles, red, luxury. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Disable Autoposting of Selected Tags:", 'instamatic-instagram-post-generator');?></b>
                  </div>
               </td>
               <td>
                  <div>
                     <textarea rows="1" name="instamatic_Instagram_Settings[disable_tags]" placeholder="Please insert the tags for which you want to disable posting"><?php
                        echo esc_textarea($disable_tags);
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
                              echo esc_html__("Input the featured image URLs to not post to Instagram. You can also add multiple image URLs, separated by comma. Ex: URL1, URL2. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                              ?>
                        </div>
                     </div>
                     <b><?php echo esc_html__("Disable Autoposting of These Image URLs:", 'instamatic-instagram-post-generator');?></b>
                  </div>
               </td>
               <td>
                  <div>
                     <textarea rows="1" name="instamatic_Instagram_Settings[skip_img]" placeholder="Skip image URLs"><?php
                        echo esc_textarea($skip_img);
                        ?></textarea>
                  </div>
               </td>
            </tr>
         </table>
         <br/><br/>
         <div>
            <b><?php echo esc_html__("Help! Plugin configured and still no posts appearing on Instagram?", 'instamatic-instagram-post-generator');?></b>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__("In this case you can try the following: Check Your username and password. Make sure they are correct. Also, if your Instagram account has advanced security features enabled, after you enter your credentials in the plugin, to make posting work, you have to log in to Instagram from your local browser.  Instagram will great you with a security message similar with the image attached to this email. You have to click 'THIS WAS ME' (to approve the plugin to log in to Instagram from your server's IP address) - if you don't click this, posting from your server will be fully banned on Instagram.", 'instamatic-instagram-post-generator');
                     ?>
               </div>
            </div>
         </div>
         <a href="https://www.youtube.com/watch?v=5rbnu_uis7Y" target="_blank"><?php echo esc_html__("Nested Shortcodes also supported!", 'instamatic-instagram-post-generator');?></a>
      </div>
      <div>
         <p class="submit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'instamatic-instagram-post-generator');?>"/></p>
      </div>
</form>
</div>
<?php
   }
   ?>