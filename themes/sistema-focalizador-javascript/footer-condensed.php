			
			</div>
		</div> <!-- #wrapper #2D2D2D-->
		
		<?php do_action( 'bp_after_container' ) ?>

		<?php do_action( 'bp_before_footer' ) ?>

		
		<div  class="white-link">
				<div class="col-xs-6">
					<p><?php _e("Developed by", "sis-foca-js"); ?> <a href="https://www.franciscomat.com">Francisco Mat</a>
					<?php /*, Fork us <a href="https://github.com/franciscof5/sistema-focalizador-javascript">on GitHub</a> */ ?>
					</p>
				</div>
				<?php
				/*<br /> Hosted by <a href="https://www.f5sites.com/pomodoros">F5 Sites</a>*/
				?>
				<div class="col-xs-6">
					<p style="text-align: right;"><a href="<?php bloginfo('url'); ?>/tag/pomodoros-2"><?php _e("Project Pomodoros", "sis-foca-js"); ?></a> | <?php _e("on", "sis-foca-js"); ?> <a href="https://angel.co/projects/68620-pomodoros-com-br">AngelList</a> | <a href="http://carreirasolo.org/novas/site-usa-tecnica-dos-pomodoros-para-agilizar-produtividade#.W_PWZ6uQxpg">CarreiraSolo</a></p>
				</div>
			</div>
<!--a class="github-fork-ribbon right-bottom" href="http://url.to-your.repo" title="Fork me on GitHub">Fork me on GitHub</a-->
	
<?php do_action( 'bp_after_footer' ) ?>

<?php wp_footer(); ?>
<?php 
/*
<!--div id="footer-info">
				    <p id="assinatura">Desenvolvido por F5 Sites <br /> <a href="http://www.f5sites.com">www.f5sites.com</a></p>
				    <?php /*<p><?php printf( __( '%s is proudly powered by <a href="http://mu.wordpress.org">WordPress MU</a>, <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), bloginfo('name') ); ?> and <a href="http://www.avenueb2.com">Avenue B2</a></p>
				</div-->

/*
					<!--div class="col-sm-3">
						<h3>Páginas</h3>
						<ul>
							<li><a href="<?php bloginfo('url'); ?>">Início</a></li>
							<?php if ( is_user_logged_in() ) { ?> 
								<li><a href="<?php bloginfo('url'); ?>/focar">Focar</a></li>
								<li><a href="<?php bloginfo('url'); ?>/colegas/<?php  $current_user = wp_get_current_user(); echo $current_user->display_name  ?>">Produtividade</a></li>
							<?php } ?>
							<li><a href="<?php bloginfo('url'); ?>/colegas">Amigos</a></li>
							<li><a href="<?php bloginfo('url'); ?>/mural">Mural</a></li>
							<li><a href="<?php bloginfo('url'); ?>/ranking">Ranking</a></li>
							<li><a href="<?php bloginfo('url'); ?>/calendar">Calendário</a></li>
						</ul>
						<?php //wp_list_pages("title_li=&include=8,3096,381,4814"); ?>
					</div-->
					*/ ?>
</body>
</html>