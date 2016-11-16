<?php
/* Template Name: Focar */
?>
<?php get_header() ?>

<div class="col-xs-4 round_box" id="default_sidebar">
	
		<?php if(is_user_logged_in()) get_sidebar();  else echo "Crie uma conta para ver as funcionalidades escondidas nessa seção";  ?>
	
</div>

<div class="col-xs-4" id="content_column">
	<div class="round_boxDISABLED">	
		<?php do_action("projectimer_show_clock_simplist"); ?>
	</div>
	<div class="round_box" style="margin-top:10px;">	
		<?php if(is_user_logged_in()) do_action("projectimer_show_task_tab_panel"); else echo "Crie uma conta para ver as funcionalidades escondidas nessa seção"; ?>

	</div>
</div>

<div class="col-xs-4 round_box" id="activity_sidebar">
	
		<?php if(is_user_logged_in()) projectimer_display_recent_activities();  else echo "Crie uma conta para ver as funcionalidades escondidas nessa seção"; ?>
		<?php #do_action("projectimer_display_recent_activities"); ?>
	
	<?php #locate_template( array( 's-pomodoros.php' ), true ); ?>
</div>


<?php get_footer() ?>
