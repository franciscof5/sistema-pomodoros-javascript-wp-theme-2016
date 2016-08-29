
<?php 
$basename = basename($_SERVER['REQUEST_URI'],'/');
if($basename=="calendar" or $basename=="calendario" or $basename=="ranking" or $basename=="focus") {
	if (!is_user_logged_in()) {
		//TODO: create page for non authorized access
		wp_redirect( home_url() ); exit;
	}
}
get_header() ?>

<?php
$basename = basename($_SERVER['REQUEST_URI'],'/');
if($basename=="calendar" or $basename=="calendario") { ?>
	<div class="content_nosidebar">
		<?php echo do_shortcode("[calendar-archive]"); ?>
	</div>
<?php } elseif ($basename=="ranking") { ?>
	<style type="text/css">
		.ta-custom li {
			height: 68px;
			border: 1px solid #CCC;
			border-radius: 10px;
			margin: 5px 0 5px 0;
		}
		.ta-custom:nth-child(1) { border: 0;}
		
		.ta-custom img {
			border-radius: 10px;
		}
		.ta-custom div:nth-child(2) {
			margin: -22px 0 0 80px;
		}
		.ta-custom h3 {
			margin-top: 30px;
			width: 80%;
			white-space: nowrap;
			overflow: hidden;
		}

		.ta-custom li:nth-child(odd) {
			background: #EEE;
		}
		.ta-custom span {
			float: right;
			font-size: 22px;
			margin: 15px;
			color: #006633;
			font-family: "Lilita One", cursive;
		}
	</style>
	<script type="text/javascript">

	jQuery( document ).ready(function($) {
		largura = jQuery(".top-authors-widget").width();
		primeiro = jQuery("li:nth-child(1)").find('span').text();
		jQuery( "li" ).each(function(i) {
			//alert( jQuery(this).find('span').text() );
			//jQuery( this ).width( jQuery(this).find('span').text() );/
			//
			qtddpomo = parseInt(jQuery(this).find('span').text());
			//res = 25 + ((((qtddpomo/primeiro)/4)*3)*100);
			//res = 50 + ((((qtddpomo/primeiro)/2)*1)*100);
			res = 40 + ((((qtddpomo/primeiro)/10)*6)*100);
			jQuery( this ).width( (res) + "%" );
			jQuery( this ).css('backgroundColor', "CCC");
			//if(i>0) {
			//	jQuery( this ).before( '<span style="float: left;font-family: Lilita One, cursive;width: 30px;font-size: 20px;line-height: 30px;text-align: center;background: #009933;color: #FFF;border-radius: 50px;padding: 0;margin: 20px 10px;">'+i+"</span" );
			//}
		});
	});
	</script>
	<div class="content_nosidebar">
		<?php
		//register_widget( 'Top_Authors' );
		$instance = array();
		$instance['title'] = 'Os mais produtivos de todos os tempos';
		$instance['count'] = 200;
		#$instance['template'] = '<li><a href="%linktoposts%">%gravatar% %firstname% %lastname% </a> number of posts: %nrofposts%</li>';
		$instance['template'] = '<li><div>%gravatar_64%</div> <div> <span> %nrofposts% </span> <h3><a href="%linktoposts%">%firstname% %lastname%</h3></a>  <p>Pomodoros completados</p>  </div> </li>';
		$args;
		the_widget( 'Top_Authors_Widget', $instance, $args );
		
		//Title: Os mais produtivos de todos os tempos:
		//Number: 99
		//Exclude: admin, 0posts
		//Template: <li><div>%gravatar%</div> <div> <span> %nrofposts% </span> <h3><a href="%linktoposts%">%firstname% %lastname%</h3></a>  <p>Pomodoros completados</p>  </div> </li>
		//Slug:
		//do_shortcode("[top_authors]");
		?>
	</div>
<?php } elseif($basename=="my-teams") { ?>
	<p>asdasd</p>
<?php } elseif ($basename=="focus") { 
		echo "FOCAR!"; ?>
		<?php //projectimer_show_clock_simplist(); ?>
	  	<?php //projectimer_show_task_form(); ?>
<?php } else {
echo "Error 404, nothing found, nada encontrado";	
} ?>
	
<?php get_footer() ?>