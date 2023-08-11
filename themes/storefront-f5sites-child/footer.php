<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */
#Startups to Ocean
#We see our startups, IT products and services, as turtles that have broken out their eggs toward the ocean.
?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php 
	add_filter( 'storefront_credit_link', '__return_false' ); 
	do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to storefront_footer action
			 *
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit         - 20
			 */
			do_action( 'storefront_footer' ); ?>

		</div><!-- .col-full -->
		<p> <a href="http://www.f5sites.com/?lang=en_US" alt="See in english">USA & World (english)</a> | <a href="http://www.f5sites.com/?lang=pt_BR" alt="Site em português do Brasil">Brasil (português)</a> </p>
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
