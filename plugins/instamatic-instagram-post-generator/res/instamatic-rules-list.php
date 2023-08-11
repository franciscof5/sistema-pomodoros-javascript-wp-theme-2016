<?php
   function instamatic_items_panel()
   {
   $GLOBALS['wp_object_cache']->delete('instamatic_rules_list', 'options');
   $all_rules = get_option('instamatic_rules_list', array());
   $rules_count = count($all_rules);
   $rules_per_page = get_option('instamatic_posts_per_page', 12);
   $max_pages = ceil($rules_count/$rules_per_page);
   if($max_pages == 0)
   {
       $max_pages = 1;
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
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
   <div>
      <form id="myForm" method="post" action="<?php echo (instamatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>">
         <?php
            wp_nonce_field('instamatic_save_rules', '_instamaticr_nonce');
            
            
            if (array_key_exists('settings-updated', $_GET)) {
            ?>
         <div>
            <p class="cr_saved_notif"><strong><?php echo esc_html__("Settings saved.", 'instamatic-instagram-post-generator');?></strong></p>
         </div>
         <?php
            }
            ?>
         <div>
            <div class="hideMain">
               <hr/>
               <div class="table-responsive">
                  <table id="mainRules" class="responsive table cr_main_table">
                     <thead>
                        <tr>
                           <th>
                              <?php echo esc_html__("ID", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This is the ID of the rule. ", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Query Type", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the type of your query. WARNING! The photos on Instagram are owned by the users. In a case like this you would have to get permission from the owners of the photo, the people who posted them, because they might be the ones that could file a lawsuit. I strongly suggest asking the actual owner/photographers for permission first.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Query Parameter", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo sprintf( wp_kses( __( "For the 'Media from user' query type, get simply input the username that you want to get content from, ex: sfatfarma, for this user: %s. For the location query type, get the location ID by navigating to your desired location <a href='%s' target='_blank'>here</a> and copying the numeric ID parameter from the URL.", 'instamatic-instagram-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.instagram.com/sfatfarma/' ), esc_url( 'https://www.instagram.com/explore/locations/' ) );
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Schedule", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       $unlocker = get_option('instamatic_minute_running_unlocked', false);
                                       if($unlocker == '1')
                                       {
                                           echo esc_html__("Select the interval in minutes after which you want this rule to run. Defined in minutes.", 'instamatic-instagram-post-generator');
                                       }
                                       else
                                       {
                                           echo esc_html__("Select the interval in hours after which you want this rule to run. Defined in hours.", 'instamatic-instagram-post-generator');
                                       }
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Max # Posts", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the maximum number of posts that this rule can create at once. 0-100 interval allowed.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Post Status", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the status that you want for the automatically generated posts to have.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Item Type", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the type (post/page) for your automatically generated item.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Post Author", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Select the author that you want to assign for the automatically generated posts.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("More Options", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Shows advanced settings for this rule.", 'instamatic-instagram-post-generator');
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
                           <th class="cr_max_55">
                              <?php echo esc_html__("Active", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to enable this rule? You can deactivate any rule (you don't have to delete them to deactivate them).", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                              <br/>
                              <input type="checkbox" onchange="thisonChangeHandler(this)" id="exclusion">
                           </th>
                           <th class="cr_max_42">
                              <?php echo esc_html__("Info", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("The number of items (posts, pages) this rule has generated so far.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_actions">
                              <?php echo esc_html__("Actions", 'instamatic-instagram-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to run this rule now? Note that only one instance of a rule is allowed at once.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                        </tr>
                        
                     </thead>
                     <tbody>
                        <?php
                           echo instamatic_expand_rules_manual();
                           if(array_key_exists('instamatic_page', $_GET))
                           {
                           $current_page = $_GET['instamatic_page'];
                           }
                           else
                           {
                           $current_page = '';
                           }
                           if($current_page == '' || (is_numeric($current_page) && $current_page == $max_pages))
                           {
                           ?>
                        
                        <tr>
                           <td class="cr_short_td">-</td>
                           <td class="cr_min_150 cr_width_150">
                              <select id="rule_type" name="instamatic_rules_list[rule_type][]" class="cr_width_150">
                                 <option selected value="user"><?php echo esc_html__("Media from User", 'instamatic-instagram-post-generator');?></option>
                                 <option value="url"><?php echo esc_html__("Media by URL", 'instamatic-instagram-post-generator');?></option>
                                 <option value="tag"><?php echo esc_html__("Latest Media by Tag", 'instamatic-instagram-post-generator');?></option>
                                 <option value="toptag"><?php echo esc_html__("Top Media by Tag", 'instamatic-instagram-post-generator');?></option>
                                 <option value="loc"><?php echo esc_html__("Latest Media by Location ID", 'instamatic-instagram-post-generator');?></option>
                                 <option value="toploc"><?php echo esc_html__("Top Media by Location ID", 'instamatic-instagram-post-generator');?></option>
                              </select>
                           </td>
                           <td class="cr_select_option"><input type="text" name="instamatic_rules_list[textids][]"  placeholder="Please input your query" value="" class="cr_width_full"/></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="1" name="instamatic_rules_list[schedule][]" max="8765812" class="cr_width_60" placeholder="Select the rule schedule interval" value="24"/></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" max="100" name="instamatic_rules_list[max][]" placeholder="Select the max # of generated posts" value="1" class="cr_width_60"/></td>
                           <td class="cr_status">
                              <select id="submit_status" name="instamatic_rules_list[submit_status][]" class="cr_width_70">
                                 <option value="pending"><?php echo esc_html__("Pending -> Moderate", 'instamatic-instagram-post-generator');?></option>
                                 <option value="draft"><?php echo esc_html__("Draft -> Moderate", 'instamatic-instagram-post-generator');?></option>
                                 <option value="publish" selected><?php echo esc_html__("Published", 'instamatic-instagram-post-generator');?></option>
                                 <option value="private"><?php echo esc_html__("Private", 'instamatic-instagram-post-generator');?></option>
                                 <option value="trash"><?php echo esc_html__("Trash", 'instamatic-instagram-post-generator');?></option>
                              </select>
                           </td>
                           <td class="cr_comm_td"><select id="default_type" name="instamatic_rules_list[default_type][]" class="cr_width_auto">
                              <?php
                                 $is_first = true;
                                 foreach ( get_post_types( '', 'names' ) as $post_type ) {
                                    echo '<option value="' . esc_attr($post_type) . '"';
                                    if($is_first === true)
                                    {
                                        echo ' selected';
                                        $is_first = false;
                                    }
                                    echo '>' . esc_html($post_type) . '</option>';
                                 }
                                 ?>
                              </select>  
                           </td>
                           <td class="cr_author"><select id="post_author" name="instamatic_rules_list[post_author][]" class="cr_width_auto cr_max_width_150">
                              <?php
                                 $blogusers = get_users( [ 'role__in' => [ 'contributor', 'author', 'editor', 'administrator' ] ] );
                                 foreach ($blogusers as $user) {
                                     echo '<option value="' . esc_html($user->ID) . '"';
                                     echo '>' . esc_html($user->display_name) . '</option>';
                                 }
                                 ?>
                              </select>  
                           </td>
                           <td class="cr_width_70">
                              <input type="button" id="mybtnfzr" value="Settings">
                              <div id="mymodalfzr" class="codemodalfzr">
                                 <div class="codemodalfzr-content">
                                    <div class="codemodalfzr-header">
                                       <span id="instamatic_close" class="codeclosefzr">&times;</span>
                                       <h2><span class="cr_color_white"><?php echo esc_html__("New Rule", 'instamatic-instagram-post-generator');?></span> <?php echo esc_html__("Advanced Settings", 'instamatic-instagram-post-generator');?></h2>
                                    </div>
                                    <div class="codemodalfzr-body">
                                       <div class="table-responsive">
                                          <table class="responsive table cr_main_table_nowr">
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the title of the generated posts for user rules. You can use the following shortcodes: %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_description%%, %%item_content%%, %%item_cat%%, %%item_tags%%", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generated Post Title:", 'instamatic-instagram-post-generator');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <input type="text" name="instamatic_rules_list[post_title][]" value="%%item_title%%" placeholder="Please insert your desired post title. Example: %%item_title%%" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Set the content of the generated posts for user rules. You can use the following shortcodes: %%likes_count%%, %%location_id%%, %%location_name%%, %%comments_count%%, %%author%%, %%author_link%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_description%%, %%item_content%%, %%item_content_plain_text%%, %%item_url%%, %%item_cat%%, %%item_tags%%, %%item_read_more_button%%, %%item_show_all_media%%, %%author_username%%, %%item_show_image%%, %%item_show_video%%, %%item_show_media%%, %%item_image_URL%%, %%post_video_embed%%, %%post_media_embed%%, %%post_image_embed%%, %%item_screenshot_url%%, %%item_show_screenshot%%", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generated Post Content:", 'instamatic-instagram-post-generator');?></b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                                                </td>
                                                <td>
                                                <textarea rows="2" cols="70" name="instamatic_rules_list[post_content][]" placeholder="Please insert your desired post content. Example:%%item_show_media%%<br/>%%item_content%%" class="cr_width_full">%%item_content%%<br/>%%post_video_embed%%</textarea>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("If your template supports 'Post Formats', than you can select one here. If not, leave this at it's default value.", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Generated Post Format:", 'instamatic-instagram-post-generator');?></b>   
                                                </td>
                                                <td class="cr_min_width_200">
                                                <select id="post_format" name="instamatic_rules_list[post_format][]" class="cr_width_full">
                                                <option value="post-format-standard"  selected><?php echo esc_html__("Standard", 'instamatic-instagram-post-generator');?></option>
                                                <option value="post-format-aside"><?php echo esc_html__("Aside", 'instamatic-instagram-post-generator');?></option>
                                                <option value="post-format-gallery"><?php echo esc_html__("Gallery", 'instamatic-instagram-post-generator');?></option>
                                                <option value="post-format-link"><?php echo esc_html__("Link", 'instamatic-instagram-post-generator');?></option>
                                                <option value="post-format-image"><?php echo esc_html__("Image", 'instamatic-instagram-post-generator');?></option>
                                                <option value="post-format-quote"><?php echo esc_html__("Quote", 'instamatic-instagram-post-generator');?></option>
                                                <option value="post-format-status"><?php echo esc_html__("Status", 'instamatic-instagram-post-generator');?></option>
                                                <option value="post-format-video"><?php echo esc_html__("Video", 'instamatic-instagram-post-generator');?></option>
                                                <option value="post-format-audio"><?php echo esc_html__("Audio", 'instamatic-instagram-post-generator');?></option>
                                                <option value="post-format-chat"><?php echo esc_html__("Chat", 'instamatic-instagram-post-generator');?></option>
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
                                                               echo esc_html__("Do you want to set generated post's date from Instagram post's date?", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Use Instagram Post's Date:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="post_date" name="instamatic_rules_list[post_date][]">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td class="cr_min_width_200">
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the post category that you want for the automatically generated posts to have.", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Additional Post Category:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <select multiple id="default_category" name="instamatic_rules_list[default_category][]" class="cr_width_full">
                                                <option value="instamatic_no_category_12345678" selected><?php echo esc_html__("Do Not Add a Category", 'instamatic-instagram-post-generator');?></option>
                                                <?php
                                                   $cat_args   = array(
                                                       'orderby' => 'name',
                                                       'hide_empty' => 0,
                                                       'order' => 'ASC'
                                                   );
                                                   $categories = get_categories($cat_args);
                                                   foreach ($categories as $category) {
                                                   ?>
                                                <option value="<?php
                                                   echo esc_html($category->term_id);
                                                   ?>"><?php
                                                   echo esc_html(sanitize_text_field($category->name));
                                                   ?></option>
                                                <?php
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
                                                               echo esc_html__("Do you want to automatically add post categories from the Instagram items?", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Auto Add Categories:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <select id="auto_categories" name="instamatic_rules_list[auto_categories][]" class="cr_width_full">
                                                <option value="0" selected><?php echo esc_html__("Disabled", 'instamatic-instagram-post-generator');?></option>
                                                <option value="4"><?php echo esc_html__("User Name", 'instamatic-instagram-post-generator');?></option>
                                                <option value="1"><?php echo esc_html__("HashTags", 'instamatic-instagram-post-generator');?></option>
                                                <option value="2"><?php echo esc_html__("Content", 'instamatic-instagram-post-generator');?></option>
                                                <option value="3"><?php echo esc_html__("Both", 'instamatic-instagram-post-generator');?></option></select>  
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the auto created categories parent category id. If you leave this field blank, automatically created categories will be a root category (no parent).", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Auto Created Categories Parent Category ID:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="number" min="0" step="1" id="parent_category_id" name="instamatic_rules_list[parent_category_id][]" value="" placeholder="Parent category id" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("This feature will try to remove the WordPress's default post category. This may fail in case no additional categories are added, because WordPress requires at least one post category for every post.", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Remove WP Default Post Category:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="remove_default" name="instamatic_rules_list[remove_default][]" checked>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to automatically add post tags from the Instagram items?", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Auto Add Tags:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <select id="auto_tags" name="instamatic_rules_list[auto_tags][]" class="cr_width_full">
                                                <option value="0" selected><?php echo esc_html__("Disabled", 'instamatic-instagram-post-generator');?></option>
                                                <option value="4"><?php echo esc_html__("User Name", 'instamatic-instagram-post-generator');?></option>
                                                <option value="1"><?php echo esc_html__("HashTags", 'instamatic-instagram-post-generator');?></option>
                                                <option value="2"><?php echo esc_html__("Content", 'instamatic-instagram-post-generator');?></option>
                                                <option value="3"><?php echo esc_html__("Both", 'instamatic-instagram-post-generator');?></option></select>      
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the post tags that you want for the automatically generated posts to have.", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Additional Post Tags:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="instamatic_rules_list[default_tags][]" value="" placeholder="Please insert your additional post tags here" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to enable comments for the generated posts?", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Enable Comments For Posts:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_comments" name="instamatic_rules_list[enable_comments][]" checked>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to enable pingbacks/trackbacks for the generated posts?", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Enable Pingback/Trackback:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="enable_pingback" name="instamatic_rules_list[enable_pingback][]" checked>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to set featured image for generated post (to the first image that was found in the post)?", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Auto Get Featured Image:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="featured_image" name="instamatic_rules_list[featured_image][]" checked>
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                      <div class="bws_hidden_help_text cr_min_260px">
                                                         <?php
                                                            echo esc_html__("Insert a comma separated list of links to valid images that will be set randomly for the featured image for the posts that do not have a valid image attached or if you disabled automatical featured image generation. You can also use image numeric IDs from images found in the Media Gallery. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator');
                                                            ?>
                                                      </div>
                                                   </div>
                                                   <b><?php echo esc_html__("Default Featured Image List:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                   <input class="cr_width_60p" type="text" name="instamatic_rules_list[image_url][]" placeholder="Please insert the link to a valid image" id="cr_input_box"  value=""/>
                                                   <input class="cr_width_33p instamatic_image_button" type="button" value=">>>"/>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("This works only if you configured phantomjs usage, from the Main Settings of the plugin. Choose if you want to use phantomjs to generate the screenshot for the page you are crawling and attach it to the generated post, regardless if you use the %%item_show_screenshot%% and %%item_screenshot_url%% shortcodes.", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Attach Screenshot to All Generated Posts", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="attach_screen" name="instamatic_rules_list[attach_screen][]">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text" class="cr_min_360">
                                                            <?php
                                                               echo esc_html__("Do you want to automatically generate post comments from item's comments feed?", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Import Comments:", 'instamatic-instagram-post-generator');?></b>
                                                   </div>
                                                </td>
                                                <td>
                                                   <div>
                                                      <select id="auto_generate_comments" name="instamatic_rules_list[auto_generate_comments][]" class="cr_width_full">
                                                         <option value="0" selected><?php echo esc_html__("Do Not Import Comments", 'instamatic-instagram-post-generator');?></option>
                                                         <?php
                                                            for ($i = 1; $i <= 50; $i++) {
                                                                echo '<option value="' . esc_attr($i) . '">' . esc_html($i) . '</option>';
                                                            }
                                                            ?>
                                                         <option value="-1"><?php echo esc_html__("Random Number", 'instamatic-instagram-post-generator');?></option>
                                                      </select>
                                                   </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text" class="cr_min_360">
                                                            <?php
                                                               echo esc_html__("If you wish to get private posts, you should check this value.", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("LogIn to Instagram:", 'instamatic-instagram-post-generator');?></b>
                                                   </div>
                                                </td>
                                                <td>
                                                   <div>
                                                      <input type="checkbox" id="enable_login" name="instamatic_rules_list[enable_login][]" checked> 
                                                   </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the user agent to use when accessing Instagram. This should be the same as the user agent you use to log in to your Instagram account from your computer.", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("User Agent String:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="instamatic_rules_list[user_agent][]" value="" placeholder="Add your user agent" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Select the post default title (if Instagram post has no usable description).", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Default Post Title:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="text" name="instamatic_rules_list[default_title][]" value="" placeholder="Please insert your default title here" class="cr_width_full">
                                                </div>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td>
                                                   <div>
                                                      <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                                         <div class="bws_hidden_help_text cr_min_260px">
                                                            <?php
                                                               echo esc_html__("Do you want to strip emojis from the generated post content?", 'instamatic-instagram-post-generator');
                                                               ?>
                                                         </div>
                                                      </div>
                                                      <b><?php echo esc_html__("Remove Emojis from Content:", 'instamatic-instagram-post-generator');?></b>
                                                </td>
                                                <td>
                                                <input type="checkbox" id="strip_emojis" name="instamatic_rules_list[strip_emojis][]">   
                                                </div>
                                                </td>
                                             </tr>
                                          </table>
                                       </div>
                                    </div>
                                    <div class="codemodalfzr-footer">
                                       <br/>
                                       <h3 class="cr_inline">iMediamatic Automatic Post Generator</h3>
                                       <span id="instamatic_ok" class="codeokfzr cr_inline">OK&nbsp;</span>
                                       <br/><br/>
                                    </div>
                                 </div>
                              </div>
                           </td>
                           <td class="cr_shrt_td2"><span class="cr_gray20">X</span></td>
                           <td class="cr_short_td"><input type="checkbox" name="instamatic_rules_list[active][]" value="1" checked />
                              <input type="hidden" name="instamatic_rules_list[last_run][]" value="1988-01-27 00:00:00"/>
                           </td>
                           <td class="cr_short_td">
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("No info.", 'instamatic-instagram-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </td>
                           <td class="cr_center">
                              <div>
                                 <img src="<?php
                                    echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/running.gif');
                                    ?>" alt="Running" class="cr_running">
                                 <div class="codemainfzr cr_gray_back">
                                    <select id="actions" class="actions" name="actions" disabled>
                                       <option value="select" disabled selected><?php echo esc_html__("Select an Action", 'instamatic-instagram-post-generator');?></option>
                                       <option value="run" onclick=""><?php echo esc_html__("Run This Rule Now", 'instamatic-instagram-post-generator');?></option>
                                       <option value="trash" onclick=""><?php echo esc_html__("Move All Posts To Trash", 'instamatic-instagram-post-generator');?></option>
                                       <option value="duplicate" onclick=""><?php echo esc_html__("Duplicate This Rule", 'instamatic-instagram-post-generator');?></option>
                                       <option value="delete" onclick=""><?php echo esc_html__("Permanently Delete All Posts", 'instamatic-instagram-post-generator');?></option>
                                    </select>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <hr/>
         <?php
            $next_url = (instamatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(stristr($next_url, 'instamatic_page=') === false)
            {
                if(stristr($next_url, '?') === false)
                {
                    if($max_pages == 1)
                    {
                        $next_url .= '?instamatic_page=1';
                    }
                    else
                    {
                        $next_url .= '?instamatic_page=2';
                    }
                }
                else
                {
                    if($max_pages == 1)
                    {
                        $next_url .= '&instamatic_page=1';
                    }
                    else
                    {
                        $next_url .= '&instamatic_page=2';
                    }
                }
            }
            else
            {
                if(array_key_exists('instamatic_page', $_GET))
                {
                    $curent_page = $_GET["instamatic_page"];
                }
                else
                {
                    $curent_page = '';
                }
                if(is_numeric($curent_page))
                {
                    $next_page = $curent_page + 1;
                    if($next_page > $max_pages)
                    {
                        $next_page = $max_pages;
                    }
                    if($next_page <= 0)
                    {
                        $next_page = 1;
                    }
                    $next_url = str_replace('instamatic_page=' . $curent_page, 'instamatic_page=' . $next_page, $next_url);
                }
                else
                {
                    if(stristr($next_url, '?') === false)
                    {
                        if($max_pages == 1)
                        {
                            $next_url .= '?instamatic_page=1';
                        }
                        else
                        {
                            $next_url .= '?instamatic_page=2';
                        }
                    }
                    else
                    {
                        if($max_pages == 1)
                        {
                            $next_url .= '&instamatic_page=1';
                        }
                        else
                        {
                            $next_url .= '&instamatic_page=2';
                        }
                    }
                }
            }
            $prev_url = (instamatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(stristr($prev_url, 'instamatic_page=') === false)
            {
                if(stristr($prev_url, '?') === false)
                {
                    $prev_url .= '?instamatic_page=1';
                }
                else
                {
                    $prev_url .= '&instamatic_page=1';
                }
            }
            else
            {
                if(array_key_exists('instamatic_page', $_GET))
                {
                    $curent_page = $_GET["instamatic_page"];
                }
                else
                {
                    $curent_page = '';
                }
                if(is_numeric($curent_page))
                {
                    $go_to = $curent_page - 1;
                    if($go_to <= 0)
                    {
                        $go_to = 1;
                    }
                    if($go_to > $max_pages)
                    {
                        $go_to = $max_pages;
                    }
                    $prev_url = str_replace('instamatic_page=' . $curent_page, 'instamatic_page=' . $go_to, $prev_url);
                }
                else
                {
                    if(stristr($prev_url, '?') === false)
                    {
                        $prev_url .= '?instamatic_page=1';
                    }
                    else
                    {
                        $prev_url .= '&instamatic_page=1';
                    }
                }
            }
            $first_url = (instamatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(stristr($first_url, 'instamatic_page=') === false)
            {
                if(stristr($first_url, '?') === false)
                {
                    $first_url .= '?instamatic_page=1';
                }
                else
                {
                    $first_url .= '&instamatic_page=1';
                }
            }
            else
            {
                if(array_key_exists('instamatic_page', $_GET))
                {
                    $curent_page = $_GET["instamatic_page"];
                }
                else
                {
                    $curent_page = '';
                }
                if(is_numeric($curent_page))
                {
                    $first_url = str_replace('instamatic_page=' . $curent_page, 'instamatic_page=1', $first_url);
                }
                else
                {
                    if(stristr($first_url, '?') === false)
                    {
                        $first_url .= '?instamatic_page=1';
                    }
                    else
                    {
                        $first_url .= '&instamatic_page=1';
                    }
                }
            }
            $last_url = (instamatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(stristr($last_url, 'instamatic_page=') === false)
            {
                if(stristr($last_url, '?') === false)
                {
                    $last_url .= '?instamatic_page=' . $max_pages;
                }
                else
                {
                    $last_url .= '&instamatic_page=' . $max_pages;
                }
            }
            else
            {
                if(array_key_exists('instamatic_page', $_GET))
                {
                    $curent_page = $_GET["instamatic_page"];
                }
                else
                {
                    $curent_page = '';
                }
                if(is_numeric($curent_page))
                {
                    $last_url = str_replace('instamatic_page=' . $curent_page, 'instamatic_page=' . $max_pages, $last_url);
                }
                else
                {
                    if(stristr($last_url, '?') === false)
                    {
                        $last_url .= '?instamatic_page=' . $max_pages;
                    }
                    else
                    {
                        $last_url .= '&instamatic_page=' . $max_pages;
                    }
                }
            }
            if(array_key_exists('instamatic_page', $_GET))
            {
                $this_page = $_GET["instamatic_page"];
            }
            else
            {
                $this_page = '1';
            }
            echo '<center><a href="' . esc_url($first_url) . '">' . esc_html__('First Page', 'instamatic-instagram-post-generator') . '</a>&nbsp;&nbsp;&nbsp;<a href="' . esc_url($prev_url) . '">' . esc_html__('Previous Page', 'instamatic-instagram-post-generator') . '</a>&nbsp;&nbsp;' . esc_html__('Page', 'instamatic-instagram-post-generator') . ' ' . esc_html($this_page) . ' ' . esc_html__('of', 'instamatic-instagram-post-generator') . ' ' . esc_html($max_pages) . '&nbsp;-&nbsp;' . esc_html__("Rules Per Page:", 'instamatic-instagram-post-generator') . '&nbsp;&nbsp;<input class="cr_50" type="number" min="2" step="1" max="999" name="posts_per_page" value="' . esc_attr($rules_per_page). '" required/>&nbsp;&nbsp;&nbsp;<a href="' . esc_url($next_url) . '">' . esc_html__('Next Page', 'instamatic-instagram-post-generator') . '</a>&nbsp;&nbsp;&nbsp;<a href="' . esc_url($last_url) . '">' . esc_html__('Last Page', 'instamatic-instagram-post-generator') . '</a></center>
            <center></center>
            <center>Info: You can add new rules only on the last page.</center>';
            ?>      
         <div>
            <p class="submit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'instamatic-instagram-post-generator');?>"/></p>
         </div>
         <div>
            <a href="https://www.youtube.com/watch?v=5rbnu_uis7Y" target="_blank"><?php echo esc_html__("Nested Shortcodes also supported!", 'instamatic-instagram-post-generator');?></a><br/><?php echo esc_html__("Confused about rule running status icons?", 'instamatic-instagram-post-generator');?> <a href="http://coderevolution.ro/knowledge-base/faq/how-to-interpret-the-rule-running-visual-indicators-red-x-yellow-diamond-green-tick-from-inside-plugins/" target="_blank"><?php echo esc_html__("More info", 'instamatic-instagram-post-generator');?></a><br/>
            <div class="cr_none" id="midas_icons">
               <table>
                  <tr>
                     <td><img id="run_img" src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/running.gif');?>" alt="Running" title="status"></td>
                     <td><?php echo esc_html__("In Progress", 'instamatic-instagram-post-generator');?> - <b><?php echo esc_html__("Importing is Running", 'instamatic-instagram-post-generator');?></b></td>
                  </tr>
                  <tr>
                     <td><img id="ok_img" src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/ok.gif');?>" alt="OK"  title="status"></td>
                     <td><?php echo esc_html__("Success", 'instamatic-instagram-post-generator');?> - <b><?php echo esc_html__("New Posts Created", 'instamatic-instagram-post-generator');?></b></td>
                  </tr>
                  <tr>
                     <td><img id="fail_img" src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/failed.gif');?>" alt="Faield" title="status"></td>
                     <td><?php echo esc_html__("Failed", 'instamatic-instagram-post-generator');?> - <b><?php echo esc_html__("An Error Occurred.", 'instamatic-instagram-post-generator');?> <b><?php echo esc_html__("Please check 'Activity and Logging' plugin menu for details.", 'instamatic-instagram-post-generator');?></b></td>
                  </tr>
                  <tr>
                     <td><img id="nochange_img" src="<?php echo esc_url(plugin_dir_url(dirname(__FILE__)) . 'images/nochange.gif');?>" alt="NoChange" title="status"></td>
                     <td><?php echo esc_html__("No Change - No New Posts Created", 'instamatic-instagram-post-generator');?> - <b><?php echo esc_html__("Possible reasons:", 'instamatic-instagram-post-generator');?></b></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td>
                        <ul>
                           <li>&#9658; <?php echo esc_html__("Already all posts are published that match your search and posts will be posted when new content will be available", 'instamatic-instagram-post-generator');?></li>
                           <li>&#9658; <?php echo esc_html__("Some restrictions you defined in the plugin's 'Main Settings'", 'instamatic-instagram-post-generator');?> <i>(<?php echo esc_html__("example: 'Minimum Content Word Count', 'Maximum Content Word Count', 'Minimum Title Word Count', 'Maximum Title Word Count', 'Banned Words List', 'Reuired Words List', 'Skip Posts Without Images'", 'instamatic-instagram-post-generator');?>)</i> <?php echo esc_html__("prevent posting of new posts.", 'instamatic-instagram-post-generator');?></li>
                        </ul>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
      </form>
   </div>
</div>
<?php
   }
   
   if (array_key_exists('instamatic_rules_list', $_POST)) {
       add_action('admin_init', 'instamatic_save_rules_manual');
   }
   function instamatic_save_rules_manual($data2)
   {
       $init_rules_per_page = get_option('instamatic_posts_per_page', 12);
       $rules_per_page = get_option('instamatic_posts_per_page', 12);
       if(array_key_exists('posts_per_page', $_POST))
       {
           update_option('instamatic_posts_per_page', $_POST['posts_per_page']);
       }
       check_admin_referer( 'instamatic_save_rules', '_instamaticr_nonce' );
       $data2 = $_POST['instamatic_rules_list'];
       $GLOBALS['wp_object_cache']->delete('instamatic_rules_list', 'options');
       $rules = get_option('instamatic_rules_list', array());
       $initial_count = count($rules);
       $add = false;
       $scad = false;
       if(array_key_exists("instamatic_page", $_GET) && is_numeric($_GET["instamatic_page"]))
       {
           $curent_page = $_GET["instamatic_page"];
       }
       else
       {
           $curent_page = 1;
       }
       $offset = ($curent_page - 1) * $rules_per_page;
       $cont = 0;
       $cat_cont = $offset;
       if(isset($data2['textids'][0]))
       {
           for ($i = 0; $i < sizeof($data2['textids']); ++$i) {
               $bundle = array();
               if (isset($data2['schedule'][$i]) && $data2['schedule'][$i] != '' && $data2['textids'][$i] != '') 
               {
                   $bundle[] = trim(sanitize_text_field($data2['textids'][$i]));
                   $bundle[] = trim(sanitize_text_field($data2['schedule'][$i]));
                   if (isset($data2['active'][$i])) 
                   {
                       $bundle[] = trim(sanitize_text_field($data2['active'][$i]));
                   }
                   else 
                   {
                       $bundle[] = '0';
                   }
                   $bundle[]     = trim(sanitize_text_field($data2['last_run'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['max'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['submit_status'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['default_type'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['post_author'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['default_tags'][$i]));
                   if($i == sizeof($data2['textids']) - 1)
                   {
                       if(isset($data2['default_category']))
                       {
                           $bundle[]     = $data2['default_category'];
                       }
                       else
                       {
                           if(!isset($data2['default_category' . $cat_cont]))
                           {
                               $cat_cont++;
                           }
                           if(!isset($data2['default_category' . $cat_cont]))
                           {
                               $bundle[]     = array('instamatic_no_category_12345678');
                           }
                           else
                           {
                               $bundle[]     = $data2['default_category' . $cat_cont];
                           }
                       }
                   }
                   else
                   {
                       if(!isset($data2['default_category' . $cat_cont]))
                       {
                           $cat_cont++;
                       }
                       if(!isset($data2['default_category' . $cat_cont]))
                       {
                           $bundle[]     = array('instamatic_no_category_12345678');
                       }
                       else
                       {
                           $bundle[]     = $data2['default_category' . $cat_cont];
                       }
                   }
                   $bundle[]     = trim(sanitize_text_field($data2['auto_categories'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['auto_tags'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['enable_comments'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['featured_image'][$i]));
                   $bundle[]     = trim($data2['image_url'][$i]);
                   $bundle[]     = $data2['post_title'][$i];
                   $bundle[]     = $data2['post_content'][$i];
                   $bundle[]     = trim(sanitize_text_field($data2['enable_pingback'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['post_format'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['rule_type'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['auto_generate_comments'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['default_title'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['strip_emojis'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['post_date'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['remove_default'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['parent_category_id'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['attach_screen'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['enable_login'][$i]));
                   $bundle[]     = trim(sanitize_text_field($data2['user_agent'][$i]));
                   $rules[$offset + $cont] = $bundle;
                   $cont++;
                   $cat_cont++;
               }
           }
           while($cont < $init_rules_per_page)
           {
               if(isset($rules[$offset + $cont]))
               {
                   $rules[$offset + $cont] = false;
               }
               $cont = $cont + 1;
           }
           $rules = array_values(array_filter($rules));
       }
       $final_count = count($rules);
       if($final_count > $initial_count)
       {
           $add = true;
       }
       elseif($final_count < $initial_count)
       {
           $scad = true;
       }
       update_option('instamatic_rules_list', $rules, false);
       if(count($rules) % $rules_per_page === 1 && $add === true)
       {
           $rules_count = count($rules);
           $max_pages = ceil($rules_count/$rules_per_page);
           if($max_pages == 0)
           {
               $max_pages = 1;
           }
           $last_url = (instamatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
           if(stristr($last_url, 'instamatic_page=') === false)
           {
               if(stristr($last_url, '?') === false)
               {
                   $last_url .= '?instamatic_page=' . $max_pages;
               }
               else
               {
                   $last_url .= '&instamatic_page=' . $max_pages;
               }
           }
           else
           {
               if(array_key_exists('instamatic_page', $_GET))
               {
                   $curent_page = $_GET["instamatic_page"];
               }
               else
               {
                   $curent_page = '';
               }
               if(is_numeric($curent_page))
               {
                   $last_url = str_replace('instamatic_page=' . $curent_page, 'instamatic_page=' . $max_pages, $last_url);
               }
               else
               {
                   if(stristr($last_url, '?') === false)
                   {
                       $last_url .= '?instamatic_page=' . $max_pages;
                   }
                   else
                   {
                       $last_url .= '&instamatic_page=' . $max_pages;
                   }
               }
           }
           instamatic_redirect($last_url);
       }
       elseif(count($rules) != 0 && count($rules) % $rules_per_page === 0 && $scad === true)
       {
           $rules_count = count($rules);
           $max_pages = ceil($rules_count/$rules_per_page);
           if($max_pages == 0)
           {
               $max_pages = 1;
           }
           $last_url = (instamatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
           if(stristr($last_url, 'instamatic_page=') === false)
           {
               if(stristr($last_url, '?') === false)
               {
                   $last_url .= '?instamatic_page=' . $max_pages;
               }
               else
               {
                   $last_url .= '&instamatic_page=' . $max_pages;
               }
           }
           else
           {
               if(array_key_exists('instamatic_page', $_GET))
               {
                   $curent_page = $_GET["instamatic_page"];
               }
               else
               {
                   $curent_page = '';
               }
               if(is_numeric($curent_page))
               {
                   $last_url = str_replace('instamatic_page=' . $curent_page, 'instamatic_page=' . $max_pages, $last_url);
               }
               else
               {
                   if(stristr($last_url, '?') === false)
                   {
                       $last_url .= '?instamatic_page=' . $max_pages;
                   }
                   else
                   {
                       $last_url .= '&instamatic_page=' . $max_pages;
                   }
               }
           }
           instamatic_redirect($last_url);
       }
   }
   function instamatic_expand_rules_manual()
   {
       $cat_args   = array(
                   "orderby" => "name",
                   "hide_empty" => 0,
                   "order" => "ASC"
       );
       $categories = get_categories($cat_args);
               
       if (!get_option('instamatic_running_list')) {
           $running = array();
       } else {
           $running = get_option('instamatic_running_list');
       }
       $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
       $GLOBALS['wp_object_cache']->delete('instamatic_rules_list', 'options');
       $rules  = get_option('instamatic_rules_list');
    if(!is_array($rules))
    {
       $rules = array();
    }
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
           $posted_items = array();
           
           $post_list = array();
           $postsPerPage = 50000;
           $paged = 0;
           do
           {
               $postOffset = $paged * $postsPerPage;
               $query = array(
                   'post_status' => array(
                       'publish',
                       'draft',
                       'pending',
                       'trash',
                       'private',
                       'future'
                   ),
                   'post_type' => array(
                       'any'
                   ),
                   'numberposts' => $postsPerPage,
                   'meta_key' => 'instamatic_parent_rule',
                   'fields' => 'ids',
                   'offset'  => $postOffset
               );
               $got_me = get_posts($query);
               $post_list = array_merge($post_list, $got_me);
               $paged++;
           }while(!empty($got_me));
           
           wp_suspend_cache_addition(true);
           foreach ($post_list as $post) {
               $rule_id = get_post_meta($post, 'instamatic_parent_rule', true);
               if ($rule_id != '') {
                   $posted_items[] = $rule_id;
               }
           }
           wp_suspend_cache_addition(false);
           $counted_vals = array_count_values($posted_items);
           if(array_key_exists("instamatic_page", $_GET) && is_numeric($_GET["instamatic_page"]))
           {
               $curent_page = $_GET["instamatic_page"];
           }
           else
           {
               $curent_page = 1;
           }
           $unlocker = get_option('instamatic_minute_running_unlocked', false);
           $rules_per_page = get_option('instamatic_posts_per_page', 12);
           foreach ($rules as $request => $bundle[]) {
               if(($cont < ($curent_page - 1) * $rules_per_page) || ($cont >= $curent_page * $rules_per_page))
               {
                   $cont++;
                   continue;
               }
               if (isset($counted_vals[$cont])) {
                   $generated_posts = $counted_vals[$cont];
               } else {
                   $generated_posts = 0;
               }
               $bundle_values          = array_values($bundle);
               $myValues               = $bundle_values[$cont];
               $array_my_values        = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
               $textids                = $array_my_values[0];
               $schedule               = $array_my_values[1];
               $active                 = $array_my_values[2];
               $last_run               = $array_my_values[3];
               $max                    = $array_my_values[4];
               $status                 = $array_my_values[5];
               $def_type               = $array_my_values[6];
               $post_user_name         = $array_my_values[7];
               $default_tags           = $array_my_values[8];
               $default_category       = $array_my_values[9];
               $auto_categories        = $array_my_values[10];
               $auto_tags              = $array_my_values[11];
               $enable_comments        = $array_my_values[12];
               $featured_image         = $array_my_values[13];
               $image_url              = $array_my_values[14];
               $post_title             = $array_my_values[15];
               $post_content           = $array_my_values[16];
               $enable_pingback        = $array_my_values[17];
               $post_format            = $array_my_values[18];
               $rule_type              = $array_my_values[19];
               $auto_generate_comments = $array_my_values[20];
               $default_title          = $array_my_values[21];
               $strip_emojis           = $array_my_values[22];
               $post_date              = $array_my_values[23];
               $remove_default         = $array_my_values[24];
               $parent_category_id     = $array_my_values[25];
               $attach_screen          = $array_my_values[26];
               $enable_login           = $array_my_values[27];
               $user_agent             = $array_my_values[28];
               wp_add_inline_script('instamatic-footer-script', 'createAdmin(' . esc_html($cont) . ');', 'after');
               $output .= '<tr>
                           <td class="cr_short_td">' . esc_html($cont) . '</td>
                           <td class="cr_min_150 cr_width_150"><select id="rule_type" name="instamatic_rules_list[rule_type][]" class="cr_width_150">
                                     <option value="user"';
               if ($rule_type == 'user') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Media from User", 'instamatic-instagram-post-generator') . '</option>
                                     <option value="url"';
               if ($rule_type == 'url') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Media by URL", 'instamatic-instagram-post-generator') . '</option>
                                     <option value="tag"';
               if ($rule_type == 'tag') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Latest Media by Tag", 'instamatic-instagram-post-generator') . '</option>
                                     <option value="toptag"';
               if ($rule_type == 'toptag') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Top Media by Tag", 'instamatic-instagram-post-generator') . '</option>
                                     <option value="loc"';
               if ($rule_type == 'loc') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Latest Media by Location ID", 'instamatic-instagram-post-generator') . '</option>
                                     <option value="toploc"';
               if ($rule_type == 'toploc') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Top Media by Location ID", 'instamatic-instagram-post-generator') . '</option>
                       </select></td>
   						<td class="cr_select_option"><input type="text" placeholder="The field URL/ID is required" name="instamatic_rules_list[textids][]" value="' . esc_attr($textids) . '" class="cr_width_full" required></td>
   						<td class="cr_comm_td"><input type="number" step="1" min="1" placeholder="# h" name="instamatic_rules_list[schedule][]" max="8765812" value="' . esc_attr($schedule) . '" class="cr_width_60" required></td>
                           <td class="cr_comm_td"><input type="number" step="1" min="0" placeholder="# max" max="100" name="instamatic_rules_list[max][]" value="' . esc_attr($max) . '"  class="cr_width_60" required></td>
                           <td class="cr_status"><select id="submit_status" name="instamatic_rules_list[submit_status][]" class="cr_width_70">
                                     <option value="pending"';
               if ($status == 'pending') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Pending -> Moderate", 'instamatic-instagram-post-generator') . '</option>
                                     <option value="draft"';
               if ($status == 'draft') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Draft -> Moderate", 'instamatic-instagram-post-generator') . '</option>
                                     <option value="publish"';
               if ($status == 'publish') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Published", 'instamatic-instagram-post-generator') . '</option>
                                     <option value="private"';
               if ($status == 'private') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Private", 'instamatic-instagram-post-generator') . '</option>
                                     <option value="trash"';
               if ($status == 'trash') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Trash", 'instamatic-instagram-post-generator') . '</option>
                       </select>  </td>
                       <td class="cr_comm_td"><select id="default_type" name="instamatic_rules_list[default_type][]" class="cr_width_auto">';
               foreach ( get_post_types( '', 'names' ) as $post_type ) {
                  $output .= '<option value="' . esc_attr($post_type) . '"';
                  if ($def_type == $post_type) {
                       $output .= ' selected';
                   }
                  $output .= '>' . esc_html($post_type) . '</option>';
               }
                       $output .= '</select>  </td>
                       <td class="cr_author"><select id="post_author" name="instamatic_rules_list[post_author][]" class="cr_width_auto cr_max_width_150">';
               $blogusers = get_users( [ 'role__in' => [ 'contributor', 'author', 'editor', 'administrator' ] ] );
               foreach ($blogusers as $user) {
                   $output .= '<option value="' . esc_html($user->ID) . '"';
                   if ($post_user_name == $user->ID) {
                       $output .= " selected";
                   }
                   $output .= '>' . esc_html($user->display_name) . '</option>';
               }
               $output .= '</select>  </td>
                       <td class="cr_width_70">
                       <input type="button" id="mybtnfzr' . esc_html($cont) . '" value="Settings">
                       <div id="mymodalfzr' . esc_html($cont) . '" class="codemodalfzr">
     <div class="codemodalfzr-content">
       <div class="codemodalfzr-header">
         <span id="instamatic_close' . esc_html($cont) . '" class="codeclosefzr">&times;</span>
         <h2>' . esc_html__('Rule', 'instamatic-instagram-post-generator') . ' <span class="cr_color_white">ID ' . esc_html($cont) . '</span> ' . esc_html__('Advanced Settings', 'instamatic-instagram-post-generator') . '</h2>
       </div>
       <div class="codemodalfzr-body">
       <div class="table-responsive">
         <table class="responsive table cr_main_table_nowr">
       <tr><td class="cr_min_width_200">
       <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the title of the generated posts for user rules. You can use the following shortcodes:  %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_description%%, %%item_content%%, %%item_cat%%, %%item_tags%%", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Generated Post Title", 'instamatic-instagram-post-generator') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       
                       </td><td>
                       <input type="text" name="instamatic_rules_list[post_title][]" value="' . esc_attr(htmlspecialchars($post_title)) . '" placeholder="Please insert your desired post title. Example: %%item_title%%" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Set the content of the generated posts for user rules. You can use the following shortcodes: %%likes_count%%, %%location_id%%, %%location_name%%, %%comments_count%%, %%author%%, %%author_link%%, %%custom_html%%, %%custom_html2%%, %%random_sentence%%, %%random_sentence2%%, %%item_title%%, %%item_description%%, %%item_content%%, %%item_content_plain_text%%, %%item_url%%, %%item_cat%%, %%item_tags%%, %%item_read_more_button%%, %%item_show_all_media%%, %%author_username%%, %%item_show_image%%, %%item_show_video%%, %%item_show_media%%, %%item_image_URL%%, %%post_video_embed%%, %%post_media_embed%%, %%post_image_embed%%, %%item_screenshot_url%%, %%item_show_screenshot%%", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Generated Post Content", 'instamatic-instagram-post-generator') . ':</b>&nbsp;<b><a href="https://coderevolution.ro/knowledge-base/faq/post-template-reference-advanced-usage/" target="_blank">&#9432;</a></b>
                       
                       </td><td>
                       <textarea rows="2" cols="70" name="instamatic_rules_list[post_content][]" placeholder="Please insert your desired post content. Example:%%item_content%%" class="cr_width_full">' . htmlspecialchars($post_content) . '</textarea>
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__('If your template supports "Post Formats", than you can select one here. If not, leave this at it\'s default value.', 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Generated Post Format", 'instamatic-instagram-post-generator') . ':</b>   
                       </td><td>
                       <select id="post_format" name="instamatic_rules_list[post_format][]" class="cr_width_full">
                       <option value="post-format-standard"';
               if ($post_format == 'post-format-standard') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Standard", 'instamatic-instagram-post-generator') . '</option>
                       <option value="post-format-aside"';
               if ($post_format == 'post-format-aside') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Aside", 'instamatic-instagram-post-generator') . '</option>
                       <option value="post-format-gallery"';
               if ($post_format == 'post-format-gallery') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Gallery", 'instamatic-instagram-post-generator') . '</option>
                       <option value="post-format-link"';
               if ($post_format == 'post-format-link') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Link", 'instamatic-instagram-post-generator') . '</option>
                       <option value="post-format-image"';
               if ($post_format == 'post-format-image') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Image", 'instamatic-instagram-post-generator') . '</option>
                       <option value="post-format-quote"';
               if ($post_format == 'post-format-quote') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Quote", 'instamatic-instagram-post-generator') . '</option>
                       <option value="post-format-status"';
               if ($post_format == 'post-format-status') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Status", 'instamatic-instagram-post-generator') . '</option>
                       <option value="post-format-video"';
               if ($post_format == 'post-format-video') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Video", 'instamatic-instagram-post-generator') . '</option>
                       <option value="post-format-audio"';
               if ($post_format == 'post-format-audio') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Audio", 'instamatic-instagram-post-generator') . '</option>
                       <option value="post-format-chat"';
               if ($post_format == 'post-format-chat') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Chat", 'instamatic-instagram-post-generator') . '</option>
                   </select>     
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to set generated post\'s date from Instagram post\'s date?", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Use Instagram Post's Date", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="post_date" name="instamatic_rules_list[post_date][]"';
               if ($post_date == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td class="cr_min_width_200">
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the post category that you want for the automatically generated posts to have.", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Additional Post Category", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <select multiple class="cr_width_full" id="default_category" name="instamatic_rules_list[default_category' . esc_html($cont) . '][]">
                       <option value="instamatic_no_category_12345678"';
                       if(!is_array($default_category))
                       {
                           $default_category = array($default_category);
                       }
                       foreach($default_category as $dc)
                       {
                           if ("instamatic_no_category_12345678" == $dc) {
                               $output .= ' selected';
                               break;
                           }
                       }
                       $output .= '>' . esc_html__("Do Not Add a Category", 'instamatic-instagram-post-generator') . '</option>';
               
               foreach ($categories as $category) {
                   $output .= '<option value="' . esc_attr($category->term_id) . '"';
                   foreach($default_category as $dc)
                   {
                       if ($category->term_id == $dc) {
                           $output .= ' selected';
                           break;
                       }
                   }
                   $output .= '>' . sanitize_text_field($category->name) . '</option>';
               }
               $output .= '</select>      
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to automatically add post categories from the feed items?", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Auto Add Categories", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <select id="auto_categories" name="instamatic_rules_list[auto_categories][]" class="cr_width_full">
                       <option value="0"';
               if ($auto_categories == '0') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Disabled", 'instamatic-instagram-post-generator') . '</option><option value="4"';
               if ($auto_categories == '4') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("User Name", 'instamatic-instagram-post-generator') . '</option><option value="1"';
               if ($auto_categories == '1') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("HashTags", 'instamatic-instagram-post-generator') . '</option><option value="2"';
               if ($auto_categories == '2') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Content", 'instamatic-instagram-post-generator') . '</option><option value="3"';
               if ($auto_categories == '3') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Both", 'instamatic-instagram-post-generator') . '</option></select>
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the auto created categories parent category id. If you leave this field blank, automatically created categories will be a root category (no parent).", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Auto Created Categories Parent Category ID", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="number" min="0" step="1" id="parent_category_id" name="instamatic_rules_list[parent_category_id][]" value="' . esc_attr($parent_category_id) . '" placeholder="Parent category id" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This feature will try to remove the WordPress\'s default post category. This may fail in case no additional categories are added, because WordPress requires at least one post category for every post.", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Remove WP Default Post Category", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="remove_default" name="instamatic_rules_list[remove_default][]"';
           if($remove_default == '1')
           {
               $output .= ' checked';
           }
           $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to automatically add post tags from the feed items?", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Auto Add Tags", 'instamatic-instagram-post-generator') . ':</b>
                       </td><td>
                       <select id="auto_tags" name="instamatic_rules_list[auto_tags][]" class="cr_width_full">
                       <option value="0"';
               if ($auto_tags == '0') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Disabled", 'instamatic-instagram-post-generator') . '</option><option value="4"';
               if ($auto_tags == '4') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("User Name", 'instamatic-instagram-post-generator') . '</option><option value="1"';
               if ($auto_tags == '1') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("HashTags", 'instamatic-instagram-post-generator') . '</option><option value="2"';
               if ($auto_tags == '2') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Content", 'instamatic-instagram-post-generator') . '</option><option value="3"';
               if ($auto_tags == '3') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Both", 'instamatic-instagram-post-generator') . '</option></select>
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the post tags that you want for the automatically generated posts to have.", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Additional Post Tags", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input class="cr_width_full" type="text" name="instamatic_rules_list[default_tags][]" value="' . esc_attr($default_tags) . '" placeholder="Please insert your additional post tags here" >
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to enable comments for the generated posts?", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Enable Comments For Posts", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_comments" name="instamatic_rules_list[enable_comments][]"';
               if ($enable_comments == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to enable pingbacks and trackbacks for the generated posts?", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Enable Pingback/Trackback", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_pingback" name="instamatic_rules_list[enable_pingback][]"';
               if ($enable_pingback == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to set featured image for generated post (to the first image that was found in the post)?", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Auto Get Featured Image", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="featured_image" name="instamatic_rules_list[featured_image][]"';
               if ($featured_image == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>
           </td></tr><tr><td>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Insert a comma separated list of links to valid images that will be set randomly for the featured image for the posts that do not have a valid image attached or if you disabled automatical featured image generation. You can also use image numeric IDs from images found in the Media Gallery. To disable this feature, leave this field blank.", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Default Featured Image List", 'instamatic-instagram-post-generator') . ':</b>
                       </td><td>
                       <input class="cr_width_full" type="text" name="instamatic_rules_list[image_url][]" placeholder="Please insert the link to a valid image" value="' . esc_attr($image_url) . '"/>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("This works only if you configured phantomjs usage, from the Main Settings of the plugin. Choose if you want to use phantomjs to generate the screenshot for the page you are crawling and attach it to the generated post, regardless if you use the %%item_show_screenshot%% and %%item_screenshot_url%% shortcodes.", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Attach Screenshot to All Generated Posts", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="attach_screen" name="instamatic_rules_list[attach_screen][]"';
               if ($attach_screen == '1') {
                   $output .= ' checked';
               }
               $output .= '>
                           
           </div>            
           </td></tr><tr><td>
           <div class="hideComm">
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text" class="cr_min_360">' . esc_html__('Do you want to automatically generate post comments from item\'s comments feed?', 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Import Comments", 'instamatic-instagram-post-generator') . ':</b>
                       </div>
                       </td><td>
                       <div class="hideComm">
                       <select id="auto_generate_comments" name="instamatic_rules_list[auto_generate_comments][]" class="cr_width_full">
                       <option value="0"';
               if ($auto_generate_comments == '0') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Do Not Import Comments", 'instamatic-instagram-post-generator') . '</option>';
               for ($i = 1; $i <= 50; $i++) {
                   $output .= '<option value="' . esc_attr($i) . '"';
                   if ($auto_generate_comments == $i) {
                       $output .= ' selected';
                   }
                   $output .= '>' . esc_html($i) . '</option>';
               }
               $output .= '<option value="-1"';
               if ($auto_generate_comments == '-1') {
                   $output .= ' selected';
               }
               $output .= '>' . esc_html__("Random Number", 'instamatic-instagram-post-generator') . '</option>';
               $output .= '</select>
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("If you wish to get private posts, you should check this value.", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("LogIn to Instagram", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="enable_login" name="instamatic_rules_list[enable_login][]"';
               if ($enable_login == '1') {
                   $output .= ' checked';
               }
               $output .= '>   
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the user agent to use when accessing Instagram. This should be the same as the user agent you use to log in to your Instagram account from your computer.", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("User Agent String", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="text" name="instamatic_rules_list[user_agent][]" value="'. esc_attr($user_agent) . '" placeholder="Add your user agent" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Select the post default title (if Instagram post has no usable description).", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Default Post Title", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="text" name="instamatic_rules_list[default_title][]" value="'. esc_attr($default_title) . '" placeholder="Please insert your default title here" class="cr_width_full">
                           
           </div>
           </td></tr><tr><td>
           <div>
           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                           <div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Do you want to strip emojis from the generated post content?", 'instamatic-instagram-post-generator') . '
                           </div>
                       </div>
                       <b>' . esc_html__("Remove Emojis from Content", 'instamatic-instagram-post-generator') . ':</b>
                       
                       </td><td>
                       <input type="checkbox" id="strip_emojis" name="instamatic_rules_list[strip_emojis][]"';
               if ($strip_emojis == '1') {
                   $output .= ' checked';
               }
               $output .= '>   
           </div>
           </td></tr></table></div> 
       </div>
       <div class="codemodalfzr-footer">
         <br/>
         <h3 class="cr_inline">iMediamatic Automatic Post Generator</h3><span id="instamatic_ok' . esc_html($cont) . '" class="codeokfzr cr_inline">OK&nbsp;</span>
         <br/><br/>
       </div>
     </div>
   
   </div>      
                       </td>
   						<td class="cr_shrt_td2"><span class="wpinstamatic-delete">X</span></td>
                           <td class="cr_short_td"><input type="checkbox" name="instamatic_rules_list[active][]" class="activateDeactivateClass" value="1"';
               if (isset($active) && $active === '1') {
                   $output .= ' checked';
               }
               $output .= '/>
                           <input type="hidden" name="instamatic_rules_list[last_run][]" value="' . esc_attr($last_run) . '"/></td>
                           <td class="cr_shrt_td2"><div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">';if(isset($instamatic_Main_Settings['secret_word']) && $instamatic_Main_Settings['secret_word'] != ''){$output .= sprintf( wp_kses( __( 'Secret Word For Direct Run:', 'instamatic-instagram-post-generator'), array(  'br' => array( ) ) ) ) . '<br/><b>?run_instamatic=' . urlencode($instamatic_Main_Settings['secret_word']) . '_' . esc_html($cont) . '</b><br/>';}$output .= sprintf( wp_kses( __( 'Shortcode for this rule<br/>(to cross-post from this plugin in other plugins):', 'instamatic-instagram-post-generator'), array(  'br' => array( ) ) ) ) . '<br/><b>%%instamatic_0_' . esc_html($cont) . '%%</b><br/>' . esc_html__('Posts Generated:', 'instamatic-instagram-post-generator') . ' ' . esc_html($generated_posts) . '<br/>';
               if ($generated_posts != 0) {
                   if (isset($instamatic_Main_Settings['post_source_custom']) && $instamatic_Main_Settings['post_source_custom'] != '') {
                       $output .= '<a href="' . get_admin_url() . 'edit.php?coderevolution_post_source=' . str_replace(' ', '-', $instamatic_Main_Settings['post_source_custom']) . '&post_type=' . esc_html($def_type) . '" target="_blank">' . esc_html__('View Generated Posts', 'instamatic-instagram-post-generator') . '</a><br/>';
                   }
                   else
                   {
                       $output .= '<a href="' . get_admin_url() . 'edit.php?coderevolution_post_source=Instamatic_' . esc_html($cont) . '&post_type=' . esc_html($def_type) . '" target="_blank">' . esc_html__('View Generated Posts', 'instamatic-instagram-post-generator') . '</a><br/>';
                   }
               }
               $output .= esc_html__('Last Run: ', 'instamatic-instagram-post-generator');
               if ($last_run == '1988-01-27 00:00:00') {
                   $output .= 'Never';
               } else {
                   $output .= $last_run;
               }
               $output .= '<br/>' . esc_html__('Next Run: ', 'instamatic-instagram-post-generator');
               if($unlocker == '1')
               {
                   $nextrun = instamatic_add_minute($last_run, $schedule);
               }
               else
               {
                   $nextrun = instamatic_add_hour($last_run, $schedule);
               }
               $now = instamatic_get_date_now();
               if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) {
                   $output .= esc_html__('WP-CRON Disabled. Rules will not automatically run!', 'instamatic-instagram-post-generator');
               }
               else
               {
                   if (isset($active) && $active === '1') {
                       if($unlocker == '1')
                       {
                           $instamatic_hour_diff = (int)instamatic_minute_diff($now, $nextrun);
                       }
                       else
                       {
                           $instamatic_hour_diff = (int)instamatic_hour_diff($now, $nextrun);
                       }
                       if ($instamatic_hour_diff >= 0) {
                           if($unlocker == '1')
                           {
                               $append = 'Now.';
                           }
                           else
                           {
                               $append = 'Now.';
                           }
                           $cron   = _get_cron_array();
                           if ($cron != FALSE) {
                               $date_format = _x('Y-m-d H:i:s', 'Date Time Format1', 'instamatic-instagram-post-generator');
                               foreach ($cron as $timestamp => $cronhooks) {
                                   foreach ((array) $cronhooks as $hook => $events) {
                                       if ($hook == 'instamaticaction') {
                                           foreach ((array) $events as $key => $event) {
                                               $append = date_i18n($date_format, $timestamp);
                                           }
                                       }
                                   }
                               }
                           }
                           $output .= $append;
                       } else {
                           $output .= $nextrun;
                       }
                   } else {
                       $output .= esc_html__('Rule Disabled', 'instamatic-instagram-post-generator');
                   }
               }
               $output .= '<br/>' . esc_html__('Local Time: ', 'instamatic-instagram-post-generator') . $now;
               $output .= '</div>
                       </div></td>
                           <td class="cr_center">
                           <div>
                           <img id="run_img' . esc_html($cont) . '" src="' . plugin_dir_url(dirname(__FILE__)) . 'images/running.gif' . '" alt="Running" class="cr_status_icon';
               if (!empty($running)) {
                   if (!in_array($cont, $running)) {
                       $output .= ' cr_hidden';
                   }
                   else
                   {
                       $f = fopen(get_temp_dir() . 'instamatic_' . $cont, 'w');
                       if($f !== false)
                       {
                           if (!flock($f, LOCK_EX | LOCK_NB)) {
                           }
                           else
                           {
                               $output .= ' cr_hidden';
                               flock($f, LOCK_UN);
                               if (($xxkey = array_search($cont, $running)) !== false) {
                                   unset($running[$xxkey]);
                                   update_option('instamatic_running_list', $running);
                               }
                           }
                       }
                   }
               } else {
                   $output .= ' cr_hidden';
               }
               $output .= '" title="status">
                           <div class="codemainfzr">
                           <select id="actions" class="actions" name="actions" onchange="actionsChangedManual(' . esc_html($cont) . ', this.value);" onfocus="this.selectedIndex = 0;">
                               <option value="select" disabled selected>' . esc_html__("Select an Action", 'instamatic-instagram-post-generator') . '</option>
                               <option value="run">' . esc_html__("Run This Rule Now", 'instamatic-instagram-post-generator') . '</option>
                               <option value="trash">' . esc_html__("Move All Posts To Trash", 'instamatic-instagram-post-generator') . '</option>
                               <option value="duplicate">' . esc_html__("Duplicate This Rule", 'instamatic-instagram-post-generator') . '</option>
                               <option value="delete">' . esc_html__("Permanently Delete All Posts", 'instamatic-instagram-post-generator') . '</option>
                           </select>
                           </div>
                           </div>
                           </td>
   					</tr>	
   					';
               $cont = $cont + 1;
           }
       }
       return $output;
   }
   ?>