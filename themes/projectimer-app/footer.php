		
		<!--div class="push"></div-->
		<!--/div> <!-- #wrapper #2D2D2D-->

		<?php do_action( 'bp_after_container' ) ?>

		<?php do_action( 'bp_before_footer' ) ?>
		</div>
		<div id="footer">
				<div class="row">
					<div class="col-xs-4">
						<ul>
							<li><?php _e("Developed by", "projectimer-theme"); ?></li>
							<li><a href="http://www.franciscomat.com">Francisco Mat</a></li>
							<li>Hosted by</li>
							<li><a href="http://www.f5sites.com">F5 Sites</a></li>
						</ul>
					</div>
					<div class="col-xs-4">
						<ul>
							<li>Sales</li>
							<li><span id="sales_phone">click to see</span> </li>
							<li>Support</li>
							<li><span id="support_phone">click to see</span></li>
						</ul>
					</div>
					<div class="col-xs-4">
						<p><?php echo do_shortcode("[join-this-site]"); ?></p>
						<p><span id="user_device">detecting device...</span></p>
						<p><span id="user_location">finding location...</span></p>
					</div>
				</div>
				<div class="row" style="text-align: right;padding-top: -40px;">
					<a href="/"><?php echo $_SERVER['HTTP_HOST']; //_e("Projectimer main site", "projectimer-theme"); ?></a>
				</div>
				<!--div id="footer-info">
				    <p id="assinatura">Desenvolvido por F5 Sites <br /> <a href="http://www.f5sites.com">www.f5sites.com</a></p>
				    <?php /*<p><?php printf( __( '%s is proudly powered by <a href="http://mu.wordpress.org">WordPress MU</a>, <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), bloginfo('name') ); ?> and <a href="http://www.avenueb2.com">Avenue B2</a></p>*/ ?>
				</div-->
				<?php do_action( 'bp_footer' ) ?>
		</div>

		<?php do_action( 'bp_after_footer' ) ?>

		<?php wp_footer(); ?>

	</body>

</html>
