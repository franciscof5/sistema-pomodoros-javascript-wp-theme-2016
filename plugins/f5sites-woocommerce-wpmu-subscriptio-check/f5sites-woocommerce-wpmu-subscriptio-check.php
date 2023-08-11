<?php
/**
 * Plugin Name: WooCommerce WPMU Subscriptio Check
 * Plugin URI: https://www.f5sites.com/woocommerce-wpmu-subscriptio-check
 * Description: Integrates WooCommerce Subscriptio (the cheaper one) with WPMU, checking and associating a SUBSCRIPTION (wp post object) when creating a new WPMU site in network, for fastening and automated subsite creation by front-end user. Compatible with another F5 Sites WP Plugin -> Shared WordPress Posts And Taxonomies + Uploads Folder
 * Version: 0.1
 * Author: Francisco Matelli Matulovic
 * Author URI: https://www.franciscomat.com
 * License: Apache 2.0
 */

add_filter('add_signup_meta', 'append_extra_field_as_meta');
add_action('wpmu_new_blog', 'process_extra_field_on_blog_signup', 10, 6);
function append_extra_field_as_meta($meta) {
	if(isset($_REQUEST['subscription_id'])) {
		$meta['subscription_id'] = $_REQUEST['subscription_id'];
	}
	if(isset($_REQUEST['teamType'])) {
		$meta['teamType'] = $_REQUEST['teamType'];
	}
	return $meta;
}
function process_extra_field_on_blog_signup($blog_id, $user_id, $domain, $path, $site_id, $meta) {
	update_blog_option($blog_id, 'subscription_id', $meta['subscription_id']);
	update_blog_option($blog_id, 'teamType', $meta['teamType']);
	if(function_exists("set_shared_database_schema")) {
		set_shared_database_schema();
	}
	update_post_meta(  $meta['subscription_id'], 'blog_id', $blog_id );
	//var_dump(get_post_meta($meta['subscription_id'], "blog_id", true));
}

add_action( 'signup_blogform', 'aditionSiteCreateOptions', 10, 2 );
//
function aditionSiteCreateOptions() {
	echo "<h2>Assinatura de Planos</h2>";
	//".get_term_link( $_SERVER['SERVER_NAME'], 'product_cat' )."
	echo "<p>Abaixo estão listadas suas assinaturas, para criar um time você precisa associar uma assinatura, <a href='/loja'>visite nossa loja de assinaturas</a>. Se você não escolher nenhuma assinatura seu time ficará aberto, mas você poderá aplicar uma assinatura a qualquer momento, verifique os termos de uso.</p>";
	listSubscriptios(0);
	teamTypeSelect(0);
}
function listSubscriptios($subsID) {
	//switch_to_blog(1);
	$args = array(
		"post_type"=>"subscription",
		"author" => get_current_user_id(),
		//"meta_key"=>"price",
		//"orderby"=>"meta_value",
		//"orderby"=>"title",
		//"sort"=>"ASC"
		);
	$subsp = get_posts($args);
	
	echo '<input type="radio" name="subscription_id" autocomplete="off" checked="checked" value="0"> Focalizador - Time Aberto<br/>';
	//var_dump($subsp);
	foreach ($subsp as $sub) {		
		if(has_term( $_SERVER['SERVER_NAME'], 'product_cat', $sub->product_id)) {
			//
			$product_name = get_post_meta($sub->ID, "product_name", true);
			$blog_ass = "";
			$disabled = "";
			$blog_associed_id = get_post_meta($sub->ID, "blog_id", true);
			
			if($blog_associed_id) {
				//$blog_details = get_blog_details($blog_associed_id);

  				//echo 'Blog '.$blog_details->blog_id.' is called '.$blog_details->blogname.'.';
				//echo $blog_associed_id;
				//$blog_ass = "(".$blog_details->blogname.")";
				//$blog_ass = get_blog_option( $blog_associed_id, 'blogname' );
				$blog_ass = "(in use by $blog_associed_id)";
				//$blog_associed_id=0;
				//restore_current_blog();
				$disabled = " disabled='disabled' ";
			}
			echo '<input type="radio" name="subscription_id" id="'.$product_name.'" autocomplete="off" value="'.$sub->ID.'" '.$disabled.'> '.$product_name.' (<a href="/plugins/woocommerce/my-account/view-subscription/'.$sub->ID.'">#'.$sub->ID.'</a>) '.$blog_ass.'<br/>';

		}
	}
	//restore_current_blog();
}

function teamTypeSelect($defaultValue) {
	?>
	<h2>Type of team</h2>
	<p>You can choose the type of your team to compete in ranking, it does not affect the cost.</p>
	<?php
	$teamTypesArray = array("Small Office", "Freelancer", "Startup", "Corporation", "Educational Institute", "Study Group"); 
	//
	echo '<select name="teamType">';
	foreach ($teamTypesArray as $type) {
		if($type==$defaultValue)
			echo '<option value="'.$type.'" selected="selected">'.$type."</option>";
		else
			echo '<option value="'.$type.'">'.$type."</option>";
	}
	echo '</select>';
	?>
	<br />
	&nbsp;
	<br />
<?php }

/*
checkSubscriptios
//for downgrade and upgrade
function subscriptioReplacement($siteID) {
	echo $siteID;
}

function listSubscriptionsClonedFromSubscriptio() {
	if (!empty($subscriptions)): ?>
	    <table class="shop_table shop_table_responsive subscriptio_subscription_list my_account_orders">

	        <thead>
	            <tr>
	                <th class="subscriptio_list_id"><?php _e('ID', 'subscriptio'); ?></th>
	                <th class="subscriptio_list_status"><?php _e('Status', 'subscriptio'); ?></th>
	                <th class="subscriptio_list_product"><?php _e('Products', 'subscriptio'); ?></th>
	                <th class="subscriptio_list_recurring"><?php _e('Recurring', 'subscriptio'); ?></th>
	                <th class="subscriptio_list_actions">&nbsp;</th>
	            </tr>
	        </thead>

	        <tbody>

	        <?php foreach ($subscriptions as $subscription):?>

	            <tr class="subscriptio_subscription_list_subscription">
	                <td data-title="<?php _e('ID', 'subscriptio'); ?>" class="subscriptio_list_id"><?php echo '<a href="' . $subscription->get_frontend_link('view-subscription') . '">' . $subscription->get_subscription_number() . '</a>'; ?></td>
	                <td data-title="<?php _e('Status', 'subscriptio'); ?>" class="subscriptio_list_status"><?php echo $subscription->get_formatted_status(true); ?></td>
	                <td data-title="<?php _e('Products', 'subscriptio'); ?>" class="subscriptio_list_product">
	                    <?php foreach (Subscriptio_Subscription::get_subscription_items($subscription->id) as $item): ?>
	                        <?php if (!$item['deleted']): ?>
	                            <?php RightPress_Helper::print_frontend_link_to_post($item['product_id'], $item['name'], '', ($item['quantity'] > 1 ? 'x ' . $item['quantity'] : '')); ?>
	                        <?php else: ?>
	                            <?php echo $item['name']; ?>
	                        <?php endif; ?>

	                         <?php
	                        /* var_dump(wc_get_order_item_meta($subscription->id, '<span id="15">itemURL</span>'));
	                         var_dump($item_meta = $item['meta']['item_meta']);
	                         var_dump($item_meta = $item['meta']['item_meta']["itemURL"]);
	                         var_dump($item_meta = $item['meta']['item_meta']['<span id="15">itemURL</span>']);*
	                        foreach($subscription->get_items() as $item) :             
	                            #var_dump($item);
	                            $current_s_item_meta = $subscription->show_variable_item_meta($item);
	                            var_dump($current_s_item_meta);
	                            //var_dump($current_s_item_meta."==".$_GET["product_item_meta"]);
	                       
	                        //die;
	                        endforeach;
	             ?>


	                        <?php echo '<br>'; ?>
	                    <?php endforeach; ?>
	                </td>
	                <td data-title="<?php _e('Recurring', 'subscriptio'); ?>" class="subscriptio_list_recurring"><?php echo $subscription->get_formatted_recurring_amount(); ?></td>
	                <td class="order-actions subscriptio_list_actions">
	                    <?php foreach ($subscription->get_frontend_actions() as $action_key => $action): ?>
	                        <a href="<?php echo $action['url']; ?>" class="button subscriptio_button_<?php echo sanitize_html_class($action_key); ?>"><?php echo $action['title']; ?></a>
	                    <?php endforeach; ?>
	                </td>
	            </tr>

	        <?php endforeach; ?>

	        </tbody>

	    </table>
	<?php else: ?>

	    <p><?php _e('You have no subscriptions.', 'subscriptio'); ?></p>

	<?php endif; ?>
<?php }
//https://stackoverflow.com/questions/42403821/detecting-if-the-current-user-has-an-active-subscription
function has_active_subscription( $user_id=null ) {

    // if the user_id is not set in function argument we get the current user ID
    if( null == $user_id )
        $user_id = get_current_user_id();

    // Get all active subscrptions for a user ID
    $active_subscriptions = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $user_id,
        'post_type'   => 'shop_subscription', // Subscription post type
        'post_status' => 'wc-active', // Active subscription

    ) );
    // if
    if(!empty($active_subscriptions)) echo 'true';
    else echo 'false';
}*/
?>