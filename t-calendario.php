<?php
/* Template Name: Pomo - Calendario */
?>
<?php get_header() ?>
<style type="text/css">
	ul.calendar li.day {
		overflow: hidden !important;
		border-radius: 10px;
	}
	ul.calendar li.empty {
		border-radius: 10px;
	}
	ul.weekdays li {
		border-radius: 10px  !important;
		text-align: center;
	}
	ul.calendar li.day .author-ranking {
		display: none;
		overflow-y:auto; 
		max-height: 80px;
		background: #FFF;
		/*border-bottom-left-radius: 5px;
		border-bottom-right-radius: 5px; */
	}

	ul.calendar li.day .author-ranking li {
		height: 15px;

	}
	ul.calendar li.day .day-footer li:hover {
		white-space: normal;
		height: inherit !important;
		
		/*background-color: #CAC5A7 !important;
		height: inherit !important;
		
		white-space: normal;
		
		display: block;*/
	}
	ul.calendar li.day .author-ranking span {
		overflow: hidden;
		white-space: nowrap;
		float:left;
	}
	ul.calendar li.day .author-ranking span.aut_pos {
		width: 10%;
	}
	ul.calendar li.day .author-ranking span.aut_nome {
		width: 30%;

	}
	ul.calendar li.day .author-ranking span.aut_barra {
		width: 40%;
		
	}
	ul.calendar li.day .author-ranking span.aut_total {
		width: 10%;
		float:right;
		padding-right: 5px;
	}

	
	ul.calendar li.day div.day-footer {
		overflow: hidden;
		height: 130px;
		width:100%;
	}
	ul.calendar li.day div.day-footer ul li {
		height: 6px;
		margin: 0;
	}
	ul.calendar li.day div.day-footer {
		border-top:1px dotted #333;
	}
	ul.calendar li.day div.day-footer:hover {
		overflow-y: auto !important;
	}

	ul.calendar li.day ul li {
		white-space: nowrap;
	}

	/*for a span above*/
	.show-hour {
		float: right;
		font-size: 10px;
	}
	/**/
	ul.weekdays li {
		background-color: #063 !important;
		color: #FFF !important;
	}
</style>
<script type="text/javascript">
	if(window.jQuery) {
		jQuery( document ).ready(function() {

			jQuery("ul.calendar li.day").find('.day-caption').mouseenter(function(){
				//jQuery(this).find('.author-ranking').show();
				//if(jQuery(this).find('.author-ranking').css('display') == 'none') {
					jQuery(this).parent().find('.author-ranking').css('display', "block");
				//}
				//console.log("mouseenter day caption");
			})
			jQuery("ul.calendar li.day").find('.author-ranking').mouseleave(function(){
				//jQuery(this).hide();
				jQuery(this).css('display', "none");
				//console.log("saiu author ranking");
			})
			jQuery("ul.calendar li.day").mouseleave(function(){
				//jQuery(this).find('.author-ranking').show();
				jQuery(this).find('.author-ranking').css('display', "none");
			})
			jQuery(".author-ranking").each(function(i) {
				if(jQuery(this).find("ul").length) {
					//Gold
					jQuery(this).find("li:nth-child(1)").find(".aut_barra div").css('background-color', "#FFD700");
					//Silver
					jQuery(this).find("li:nth-child(2)").find(".aut_barra div").css('background-color', "#A8A8A8");
					//Bronze
					jQuery(this).find("li:nth-child(3)").find(".aut_barra div").css('background-color', "#965A38");
				}
				//jQuery.each(".aut_barra").css('background-color', "#964");
			});
			
		});
		
		/*jQuery("ul.calendar li.day").find('.day-header').mouseover(function(){
			jQuery(this).next().css('display', "block");
		})
		jQuery("ul.calendar li.day").find('.author-ranking').mouseleave(function(){
			jQuery(this).css('display', "none");
		})
		jQuery("ul.calendar li.day").find('.author-ranking').focusout(function(){
			jQuery(this).css('display', "none");
		})
		jQuery("ul.calendar li.day").find('.day-header').mouseleave(function(){
			jQuery(this).find('.author-ranking').css('display', "none");
		})

		jQuery("ul.calendar li.day").find('.day-footer').mouseenter(function(){
			jQuery(this).parent().find('.author-ranking').css('display', "none");
		})
		*/
		/*todo: paiting the 3 firts bars colors to GOLD SILVER and BRONZE*/
		/*jQuery("ul.calendar li.day .author-ranking ul").each(function(i) {
			/*jQuery("li").each(function(i) { });*/
			/*console.log("ul:".i);
			jQuery("li").each(function(i) {
				console.log("li:".i);
			});*/
		//});
		/* For the effect of hide and show the ranking when mouses passes over day header */
		
		/*console.log("MAIOR GAMBIARRA PARA ESCONDER MESES");
		/*jQuery(".calendar-container").each(function(i) {
			console.log(";"+i);
			if(i>0) {
				jQuery(this).css("display", "none");
				jQuery(this).next().css("display", "none");
			}
		})jQuery('#tipo_calendario').change(function() {
		if($(this).val()==0) {
			window.location 
		} else {
			window.location += "?post_author="+$(this).val();
		}
	});
	*/
	}//if window.jQuery

</script>
<div class="content_nosidebar">
	<!--todo: chanve view to MENSAL and YEAR
	todo:put button show only my records
	todo:put on configuration optionS above
	h2>Calenario mensal</h2>
	<p>Visualizar <a>calendario anual</a></p-->
	<?php
	echo do_shortcode("[calendar-archive]");
	//echo do_shortcode("{events_calendar}");
	?>
</div><!-- #content -->
	
<?php get_footer() ?>
<? /*
	<div id="content" class="content_default">
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ) ?>

		<div class="page" id="blog-page">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


				<div class="post" id="post-<?php the_ID(); ?>">

					<div class="entry">

						<?php the_content( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

						<?php wp_link_pages( array( 'before' => __( '<p><strong>Pages:</strong> ', 'buddypress' ), 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php edit_post_link( __( 'Edit this entry.', 'buddypress' ), '<p>', '</p>'); ?>

					</div>

				</div>

			<?php endwhile; endif; ?>

		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer(); ?>
