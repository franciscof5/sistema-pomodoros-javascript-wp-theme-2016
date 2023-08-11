jQuery( function() {

		// Search toggle top.
		jQuery( '.search-toggle-top' ).on( 'click', function( event ) {
			var that    = jQuery( this ),
				wrapper = jQuery( '#search-box-top' );

			that.toggleClass( 'active' );
			wrapper.toggleClass( 'hide' );

			if ( that.is( '.active' ) || jQuery( '.search-toggle-top' )[0] === event.target ) {
				wrapper.find( '.s' ).focus();
			}
		} );

		// Search toggle.
		jQuery( '.search-toggle' ).on( 'click', function( event ) {
			var that    = jQuery( this ),
				wrapper = jQuery( '#search-box' );

			that.toggleClass( 'active' );
			wrapper.toggleClass( 'hide' );

			if ( that.is( '.active' ) || jQuery( '.search-toggle' )[0] === event.target ) {
				wrapper.find( '.s' ).focus();
			}
		} );

		// Enable menu toggle for small screens.
		( function() {
			var nav = jQuery( '.main-navigation' ), button, menu;
			if ( ! nav ) {
				return;
			}

			button = nav.find( '.menu-toggle' );
			if ( ! button ) {
				return;
			}

			// Hide button if menu is missing or empty.
			menu = nav.find( '.nav-menu' );
			if ( ! menu || ! menu.children().length ) {
				button.hide();
				return;
			}

			jQuery( '.menu-toggle' ).on( 'click', function() {
				nav.toggleClass( 'toggled-on' );
			} );
		} )();

		// Enable info bar right menu toggle for small screens.
		( function() {
			var nav = jQuery( '.right-section' ), button, menu;
			if ( ! nav ) {
				return;
			}

			button = nav.find( '.info-bar-menu-toggle-right' );
			if ( ! button ) {
				return;
			}

			// Hide button if menu is missing or empty.
			menu = nav.find( '.nav-menu-right' );
			if ( ! menu || ! menu.children().length ) {
				button.hide();
				return;
			}

			jQuery( '.info-bar-menu-toggle-right' ).on( 'click', function() {
				nav.toggleClass( 'toggled-on-right' );
			} );
		} )();

		// Enable info bar Left menu toggle for small screens.
		( function() {
			var nav = jQuery( '.left-section' ), button, menu;
			if ( ! nav ) {
				return;
			}

			button = nav.find( '.info-bar-menu-toggle-left' );
			if ( ! button ) {
				return;
			}

			// Hide button if menu is missing or empty.
			menu = nav.find( '.nav-menu-left' );
			if ( ! menu || ! menu.children().length ) {
				button.hide();
				return;
			}

			jQuery( '.info-bar-menu-toggle-left' ).on( 'click', function() {
				nav.toggleClass( 'toggled-on-left' );
			} );
		} )();
} ); 

jQuery(document).ready(function(){

	// hide #back-top first
	jQuery(".back-to-top").hide();
	
	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 1000) {
				jQuery('.back-to-top').fadeIn();
			} else {
				jQuery('.back-to-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		jQuery('.back-to-top a').click(function () {
			jQuery('body,html,header').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});
