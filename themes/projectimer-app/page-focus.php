
	<!--div id="loading-message"><p>.</p><p class="dots">..</p></div-->
	<?php
	/*$members_args = array(
		'user_id'         => 0,
		'type'            => $type,
		'per_page'        => $max_members,
		'max'             => $max_members,
		'populate_extras' => true,
		'search_terms'    => false,
	);
	echo $user_id = bp_displayed_user_id();
	echo $member_type = bp_get_current_member_type();
	var_dump(bp_has_members(  ) );die;
	onclick="javascript:colunsHeightAlwaysTheSame();"
	*/?>

	
	
	
	<div id="default_sidebar" class="col-xs-2 sidebar_inverted">
		<button data-toggle="collapse" data-target="#default_sidebar_in" class="collapse_button collapse_left" ><span class="glyphicon glyphicon-resize-horizontal"></span></button>
		<div id="default_sidebar_in" class="width collapse in">
			<?php the_widget("BP_Core_Members_Widget", "Team's Members"); ?>
		</div>
	</div>

	<div id="content_column" class="col-xs-5">
		<?php do_action("projectimer_show_clock_simplist"); ?>
		<?php do_action("projectimer_display_task_tabs"); ?>
	</div>

	

	<div id="activity_sidebar" class="col-xs-5 sidebar_inverted">
		<button data-toggle="collapse" data-target="#activity_sidebar_in" class="collapse_button collapse_righ" ><span class="glyphicon glyphicon-resize-horizontal"></span></button>
		<div id="activity_sidebar_in" class="width collapse in">
			<?php do_action("projectimer_display_recent_activities"); ?>
		</div>
	</div>
