<?php 
		
	$mp3Present = get_post_meta($post->ID, 'single_format_audio', true);
	
	if ( $mp3Present ) { ?>
	
	<div class="post-audio">
	
		<script>
			jQuery(document).ready(function(){
				if(jQuery().jPlayer) {
					jQuery('#jquery_jplayer_<?php the_ID(); ?>').jPlayer( { 
						ready : function () { 
								jQuery(this).jPlayer("setMedia", {
									mp3: "<?php echo get_post_meta($post->ID, 'single_format_audio', true); ?>",
									end: ""
							});
						},
						size: {
						    width: "100%",
						},
						swfPath: "<?php echo get_template_directory_uri(); ?>/assets/js/plugins",
						cssSelectorAncestor: "#jp_container_<?php the_ID(); ?>",
						supplied: "mp3,  all"
					});
				}
				jQuery("#jp_container_<?php the_ID(); ?> .jp-interface").css("display", "block");
			});
		</script>
			
		<div id="jp_container_<?php the_ID(); ?>" class="jp-audio fullwidth">
			<div id="jquery_jplayer_<?php the_ID(); ?>" class="jp-jplayer">
			</div>
			<div class="jp-interface" style="display: none;">
				<ul class="jp-controls">
					<li><a href="javascript:;" class="jp-play" tabindex="1" title="Play"><span>Play</span></a></li>
					<li><a href="javascript:;" class="jp-pause" tabindex="1" title="Pause"><span>Pause</span></a></li>
				</ul>
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
			</div>
		</div>
</div>
<?php } ?>