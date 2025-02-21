			
			<!-- </div>  -->
		
		<?php do_action( 'bp_after_container' ) ?>

		<?php do_action( 'bp_before_footer' ) ?>

			<div class="footer-paginas">
				<?php if ( is_user_logged_in() ) { ?>
				<div class="row contem-paginas">
					<!-- <div class="col"><a href="<?php bloginfo('url'); ?>">Início</a></div> -->
					<div class="col"><a href="<?php bloginfo('url'); ?>/focar">Focar</a></div>
					<div class="col"><a href="<?php bloginfo('url'); ?>/ranking">Ranking</a></div>
					<div class="col"><a href="<?php bloginfo('url'); ?>/users">Amigos</a></div>
					<div class="col"><a href="<?php bloginfo('url'); ?>/calendar">Calendário</a></div>
					<div class="col"><a href="<?php bloginfo('url'); ?>/users/<?php $current_user = wp_get_current_user(); echo $current_user->user_login?>">Stats</a></div>
				</div>
				<?php } ?>
				<div class="row justify-content-between footer-white-link">
					<div class="col">
						<p>
							<a href="https://www.franciscomatelli.com.br">Francisco Matelli</a>
							| <a href="https://www.f5sites.com.br">F5 Sites</a>
						</p>
					</div>
					<?php
					/*<br /> Hosted by <a href="https://www.f5sites.com/pomodoros">F5 Sites</a>*/
					?>
					<div class="col">
						<p style="text-align: right;"><a href="<?php bloginfo('url'); ?>/done/pomodoros-2"><?php _e("Project Pomodoros", "sis-foca-js"); ?></a> | <a href="https://angel.co/projects/68620-pomodoros-com-br">AngelList</a> | <a href="http://carreirasolo.org/novas/site-usa-tecnica-dos-pomodoros-para-agilizar-produtividade#.W_PWZ6uQxpg">CarreiraSolo</a></p>
					</div>
				</div>
				<!-- <div class="row">
					<p><?php printf( __( '%s is proudly powered by <a href="http://www.wordpress.org">WordPress</a>, <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), bloginfo('name') ); ?> | Fork us <a href="https://github.com/franciscof5/sistema-focalizador-javascript">on GitHub</a></p>
				</div> -->
		</div> <!-- contem-tudo -->
	
	</div>
				<!--a class="github-fork-ribbon right-bottom" href="http://url.to-your.repo" title="Fork me on GitHub">Fork me on GitHub</a-->
					
<?php do_action( 'bp_after_footer' ) ?>

<?php wp_footer(); ?>

<script>
	jQuery( document ).ready(function() {
		jQuery( ".abrir_settings" ).click(function() {
			jQuery( "#settingsbox" ).toggle("slow");
		});
		jQuery( window ).click(function() {
			//NOT MOUSE OVER LOGINLOGBOX
			if(jQuery( "#loginlogbox" ).is(":visible") && !jQuery( "#loginlogbox" ).is(":animated") && !jQuery( "#loginlogbox" ).is(":hover"))
			jQuery( "#loginlogbox" ).hide("fast");

			if(jQuery( "#settingsbox" ).is(":visible") && !jQuery( "#settingsbox" ).is(":animated") && !jQuery( "#settingsbox" ).is(":hover"))
			jQuery( "#settingsbox" ).hide("fast");
		});
		jQuery("[data-toggle=popover]").popover();
	});
</script>

<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  const firebaseConfig = {
    apiKey: "AIzaSyABZjPkdjVzf9u94HLKyQoYa24SKcSOl6o",
    authDomain: "pomodoros-com-br.firebaseapp.com",
    databaseURL: "https://pomodoros-com-br.firebaseio.com",
    projectId: "pomodoros-com-br",
    storageBucket: "pomodoros-com-br.appspot.com",
    messagingSenderId: "52781640120",
    appId: "1:52781640120:web:237e1b0da33b36ca10074d"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
</script>

</body>
</html>