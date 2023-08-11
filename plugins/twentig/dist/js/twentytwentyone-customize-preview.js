/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function( api, $ ) {

	api( 'twentig_menu_text_transform', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( '.primary-navigation, .menu-button-container .button' ).css( { 'text-transform': to } );
			} else {
				$( '.primary-navigation, .menu-button-container .button' ).css( { 'text-transform': 'none' } );
			}
		} );
	} );

	function twentigLoadGoogleFont( context, to ) {
		if ( to ) {
			var font, style, el, styleID, fontVariations;
			font = to.split(',')[0];
			font = font.replace(/'/g, '');
			font = font.replace( / /g, '+' );
			fontVariations = 'body' === context ? 'ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400' : 'wght@100;200;300;400;500;600;700;800;900';
			styleID = 'twentig-customizer-font-' + context;
			style = '<link rel="stylesheet" type="text/css" id="' + styleID + '" href="https://fonts.googleapis.com/css2?family=' + font + ':' + fontVariations + '&display=swap">';
			el = $( '#' + styleID );
				
			if ( el.length ) {
				el.replaceWith( style );
			} else {
				$( 'head' ).append( style );
			}
		}
	}

	$.each( [ 'body', 'heading', 'logo' ], function( index, setting ) {
		api( 'twentig_' + setting + '_font', function( value ) {
			var onChange = function( to ) {
				twentigLoadGoogleFont( setting, to );
			};
			onChange( value.get() );
			value.bind( onChange );
		} );
	} );

	var style = $( '#twentig-customizer-live-css' );
	if ( ! style.length ) {
		style = $( 'head' ).append( '<style type="text/css" id="twentig-customizer-live-css" />' ).find( '#twentig-customizer-live-css' );
	}

	api.bind( 'preview-ready', function() {	
		api.preview.bind( 'update-customizer-live-css', function( css ) {
			style.text( css );
		} );				
	} );

})( wp.customize, jQuery );
