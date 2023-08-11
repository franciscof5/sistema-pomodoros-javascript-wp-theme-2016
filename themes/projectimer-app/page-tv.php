<div class="row sidebar_inverted" style="padding: 4px 10px;">
	<div class="col-xs-2">
		<a href="<?php echo get_bloginfo('url'); ?>"><h4> &nbsp; <span class="glyphicon glyphicon-expand" aria-hidden="true"></span> FOCA TV</h4></a>
	</div>
	<div class="col-xs-2" style="line-height: 40px;">
		<!--br /-->
		<span class="glyphicon glyphicon-th" aria-hidden="true"></span> <?php echo get_bloginfo('name'); ?><br />
		<?php //echo get_bloginfo('description'); ?>
	</div>
	<div class="col-xs-2" style="line-height: 40px;">
		<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> <?php echo current_time( 'j \d\e F \d\e Y' ); ?>
	</div>
	<div class="col-xs-2" style="line-height: 40px;">
		<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Itapetininga, Brasil 
	</div>
	
	<div class="col-xs-2">
		<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> Trabalhando hoje: 2/7<br />
		<span class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></span> Meta do dia: 23/56
	</div>
	<div class="col-xs-2">
		<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Líder do dia: Jonas<br />
		<span class="glyphicon glyphicon-gift" aria-hidden="true"></span> Prêmio: Cable Holder
	</div>
</div>

<div class="row">
	<div class="col-sm-9">
		<div class="row">
			<div class="col-xs-4 ">
				<?php
				#dynamic_sidebar( 'tv-colunm-1' );
				the_widget("BP_Core_Members_Widget", "Team's Members");
				?>
			</div>

			<div class="col-xs-4">
				<h3>Ciclos Hoje</h3>
				<?php
				echo do_shortcode('[wp_charts title="mypie" type="pie" align="alignright" margin="5px 20px" data="10,32,50,25,5"]');
				//dynamic_sidebar( 'tv-colunm-2' );
				#echo do_shortcode('[bc_activity]');
				?>
			</div>

			<div class="col-xs-4">
				<h3>Semana</h3>
				<?php
				echo do_shortcode('[wp_charts width="100%" title="barchart" type="bar" align="alignleft" margin="5px 20px" datasets="40,32,50,35 next 20,25,45,42 next 40,43, 61,50 next 33,15,40,22" labels="one,two,three,four"]');
				#do_action('cp_pointsWidget');
				#echo do_shortcode('[bc_blogs]');
				#dynamic_sidebar( 'tv-colunm-3' );
				?>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-4 ">
				<h3>Comunicados</h3>
				
				<?php 
				//[https://www.youtube.com/watch?v=AV_GQ_J9Af0]
				//echo do_shortcode('[https://www.youtube.com/watch?v=AV_GQ_J9Af0]');
	
				
				dynamic_sidebar( 'tv-colunm-4' );
				
				?>
			</div>
			<div class="col-xs-4 ">
				<h3>Metas dinâmicas</h3>
				<?php
				//dynamic_sidebar( 'tv-colunm-4' );
				echo do_shortcode('[wp_charts width="100%" title="Metas" type="radar" align="alignleft" margin="5px 20px" datasets="20,22,40,25,55 next 15,20,30,40,35" labels="one,two,three,four,five" colors="#CEBC17,#CE4264"]');
				?>
			</div>

			<div class="col-xs-4">
				<h3>Burndown</h3>
				<?php
				echo do_shortcode('[wp_charts title="Burndown" width="100% title="linechart" type="line" align="alignright" margin="5px 20px" datasets="40,43,61,50 next 33,15,40,22" labels="one,two,three,four"]');
				?>
			</div>
			
		</div>
	</div>
	<div class="col-sm-3">
		<?php do_action("projectimer_display_recent_activities"); ?>
	</div>
</div>
<style type="text/css">
	.navbar, #footer {
		display: none;
	}
</style>