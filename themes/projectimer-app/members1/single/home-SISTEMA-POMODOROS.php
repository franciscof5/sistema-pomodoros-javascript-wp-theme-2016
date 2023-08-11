<?php

/**
 * BuddyPress - Users Home
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

get_header( 'buddypress' ); ?>

	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_member_home_content' ); ?>
			<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
				<ul>
					<?php 
					#http://buddypress.org/support/topic/how-to-remove-and-add-items-in-bp_get_displayed_user_nav/
					bp_get_displayed_user_nav(); ?>
				</ul>
			</div>

			<div id="item-header" role="complementary">
				<?php locate_template( array( 'members/single/member-header.php' ), true ); ?>
			</div><!-- #item-header -->
			<div>
				<?php
				//all_posts = $wpdb->query('SELECT * FROM `wp_posts` WHERE `post_author` = '.$user_id.' GROUP BY DATE (`post_date`)');
				//$all_posts = query_posts('author=1');
				//$all_posts = $wpdb->query('SELECT `ID` FROM `wp_posts` WHERE `post_author` = '.$user_id.'');
				$all_posts = $wpdb->get_results('SELECT `ID` FROM `wp_posts` WHERE `post_author` = '.bp_displayed_user_id().'');
				//Tem que ser separado por causa do inarray
				$all_tags_slugs = array();
				$all_tags_counts = array();
				foreach ($all_posts as $value) {
					//var_dump($value->ID)." [ ] ";
					$tags = wp_get_post_tags($value->ID);
					$term_slug = $tags[0]->slug;
					//var_dump(!in_array($term_slug, $all_tags));
					if(!in_array($term_slug, $all_tags_slugs)) {
						$all_tags_slugs[]=$term_slug;
						$all_tags_counts[]=$tags[0]->count;
					}
					//
					//$term = get_term_by('slug', "tag", $term_slug);
					// Fetch the count
					//echo $term->count;
					//var_dump($tags[0]->slug);
					/*
					slug
					name
					
					foreach ($tags as $value) {
						echo "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>{$tag->name}</a>";
					}*/
				} ?>
				<h3>Projetos (<?php echo count($all_tags); ?>)</h3>
				
				<ul>
				<?php foreach ($all_tags_slugs as $key => $value) {
					echo "<li><a href=".get_bloginfo("url")."/projeto/$value>{$value}:{$all_tags_counts[$key]}</a></li>";
				} ?>
				</ul>
				
				<?php
				//var_dump($all_tags);
				//die;

				/*$html = '<div class="post_tags">';
				foreach ( $tags as $tag ) {
					$tag_link = get_tag_link( $tag->term_id );
							
					$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
					$html .= "{$tag->name}</a>";
				}
				$html .= '</div>';*/
				?>
			</div>
			<div>
				<?php
				$usuario_alvo = bp_displayed_user_id();
				$GLOBALS["alvo"] = $usuario_alvo;
				get_template_part("part", "gauges"); 
				?>
			</div>
			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
					<ul>
						<?php do_action( 'bp_member_options_nav' ); ?>
					</ul>
				</div>
			</div><!-- #item-nav -->

			<div id="item-body">

				<?php do_action( 'bp_before_member_body' );

				if ( bp_is_user_activity() || !bp_current_component() ) :
					locate_template( array( 'members/single/activity.php'  ), true );

				 elseif ( bp_is_user_blogs() ) :
					locate_template( array( 'members/single/blogs.php'     ), true );

				elseif ( bp_is_user_friends() ) :
					locate_template( array( 'members/single/friends.php'   ), true );

				elseif ( bp_is_user_groups() ) :
					locate_template( array( 'members/single/groups.php'    ), true );

				elseif ( bp_is_user_messages() ) :
					locate_template( array( 'members/single/messages.php'  ), true );

				elseif ( bp_is_user_profile() ) :
					locate_template( array( 'members/single/profile.php'   ), true );

				elseif ( bp_is_user_forums() ) :
					locate_template( array( 'members/single/forums.php'    ), true );

				elseif ( bp_is_user_settings() ) :
					locate_template( array( 'members/single/settings.php'  ), true );

				// If nothing sticks, load a generic template
				else :
					locate_template( array( 'members/single/plugins.php'   ), true );

				endif;

				do_action( 'bp_after_member_body' ); ?>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_home_content' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

<?php get_sidebar( 'buddypress' ); ?>
<?php get_footer( 'buddypress' ); ?>
