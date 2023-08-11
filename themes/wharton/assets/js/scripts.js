/*! @Copyright MeanThemes 2014 - Wharton v1.1.7 */

jQuery.noConflict();
(function ($) {
	"use strict";

	$(window).load(function() {

		//
		// Adjust menu icon position based on header heigh
		//
		var headerHeight = $('header.header').outerHeight();
		var menuHeight = $('#menu-control').outerHeight();
		$('#menu-control').css( 'margin-top' , ((headerHeight-menuHeight)/2) - 1 );

		//
		// Get logo size and switch for retina if needed
		//
		var logo = $( '#logo' );
		var logoRetina = logo.attr('data-fullsrc');

		logo.attr( 'width' , logo.width() );
		logo.attr( 'height' , logo.height() );

		if( window.devicePixelRatio >= 1.5 ){
		   logo.attr( 'src' , logoRetina );
		}


		//
		// Adjust divide on pagination
		//
		var paginationHeight = $( '.pagination' ).outerHeight();

		$( '.pagination .older-posts' ).css( 'min-height' , paginationHeight );


				function makeInsert() {
						$('.mt-insert').each(function () {
							var insertImage = $('img' , this).height();

							var insertCaption = $( '.wp-caption-text' , this );
							var insertCaptionHeight = $( '.wp-caption-text' , this ).height();

							$(this).css( "min-height" , insertImage );


							// Check for caption and increase height
							if(insertCaption.length >= 1) {

								$(this).css( "min-height" , insertImage+insertCaptionHeight );
								$( '.wp-caption' , this ).css( "min-height" , insertImage+insertCaptionHeight );
								$(this).addClass('remove-abs');

							}

						});
				}
				makeInsert();

				//
				// Resize events
				//
				$(window).resize(function () {
					makeInsert();
				});




	});


	//
	// Doc ready scripts
	//

    $(document).ready(function() {

    	//
    	// Add a class so we know JavaScript is supported
    	//
    	$('html').addClass("js").removeClass("no-js");

    	//
    	// Get browser Width, height etc
    	//
    	var currWidth = $(window).width();
    	var breakpoint = 768;


        if ( (navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPad/i)) ) {
            $("body").addClass("ios");
        }

        if ( ie9 ) {
        	$('body').addClass('ie9');
        }

        //
        // Hide URL bar on mobile/tablet
        //
        if( currWidth < breakpoint ) {
        	window.addEventListener("load",function() {
        		setTimeout(function(){
        			window.scrollTo(0, 1);
        		}, 0);
        	});
        }




        //
        // Run menu
        //
        $('.site-navigation').addClass('animated-both').addClass('slideOutUp');

        // Get header height
        var topAdjust = $( 'header.header' ).outerHeight();
        $( '#menu-control' ).on( 'click' , function (e) {

        	e.preventDefault();

        	$("html, body").animate({ scrollTop: 0 }, 100);


		    $('.site-navigation').toggleClass('slideInDown').toggleClass('slideOutUp');
		    $('body').toggleClass('nav-active');
		    $('.ie9 .site-navigation').show();



		    if ( $(this).attr( 'class' ) === 'active' ) {

		    	$('header.header').removeClass('fixed');
		    	$('.ie9 .site-navigation').hide();

		    }

		    else {

			    setTimeout(function() {
			          $('header.header').addClass('fixed');
			    }, 350);

		    }

		     $('body.nav-active .site-navigation').css( 'top' , topAdjust+'px' );


        	$(this).toggleClass('active');

        });

        //
        // Adjust menu position when using standard desktop menu
        //
        if ( $( 'html' ).is('.d-menu') ) {
        	var headerHeight = $( 'header.header' ).outerHeight();
        	var logoHeight = $( 'header.header .logo' ).outerHeight();

        	if ( !$( 'html' ).is('.center-header') ) {
	        	if (headerHeight > 78) {

	    	    	$( 'header.header .sitenav-main a' ).css( 'line-height', logoHeight + 'px' );

	    	    }
    	    }

        }

        //
        // Grab Avatars
        //
        $('.author-avatar').each(function () {

        	var avatarSrc = $(' img', this).attr("src");
        	$(this).css("background-image" , "url(" + avatarSrc +")");

        });



        //
        // Truncate links
        //

        $('.widgets .tweet-text a').truncate({
			width: '150',
			after: '&hellip;',
			center: false,
			addtitle: true,
		});

        if ( $( 'body' ).is('.single-post') ) {
	        if( $('body').hasClass("mobile") ) {
	        	$('.comment-text a').truncate({
	        					width: '150',
	        					after: '&hellip;',
	        					center: false,
	        					addtitle: true,
	        				});
	        } else {
	        	$('.comment-text a').truncate({
	        					width: '500',
	        					after: '&hellip;',
	        					center: false,
	        					addtitle: true,
	        				});
	        }
        }

        //
        // Shortcodes (tabs and toggles)
        //

        // Tabs
        $(function () {
        	$(".mt-tabs").each( function () {
        	    var tabContainers = $('.tab-inner > div', this);

        	    $(' ul a',this).click(function (e) {
        		   e.preventDefault();
        	        tabContainers.hide().filter(this.hash).show();

        	        $(this).parent().parent().find('li').removeClass('tab-active');
        	        $(this).parent().addClass('tab-active');

        	        return false;
        	    }).filter(':first').click();
            });
        });


        // Toggles
        $(function () {
        	$(".toggle").each( function () {
        	    var toggleContainers = $('.toggle-inner', this).hide();
        	    var toggleActive = $('.toggle-title', this);



        	    var toggleData = $(this).attr('data-id');
        	   	if( toggleData === "open" ) {
        	   		$('.toggle-inner', this).show();
        	   		toggleActive.addClass('active');
        	   	}

        	   	toggleActive.on( 'click' , function (e) {

        	   		e.preventDefault();

        	   		toggleContainers.slideToggle();
        	   		toggleActive.toggleClass('active');

        	   	});

            });
        });


         //
         //  Roll comment form
         //
         $('#comments .inner').hide();


         $('#comments h5 a').toggle(function() {
         	$(this).parent().toggleClass('active');
           	$('#comments .inner').fadeToggle();
           	$('html,body').delay(500).animate({scrollTop:jQuery('#comments .inner').offset().top-113}, 500);

         }, function() {
           	$(this).parent().toggleClass('active');
           	$('#comments .inner').fadeToggle();
           	$('html,body').delay(500).animate({scrollTop:jQuery('#comments .inner').offset().top-113}, 500);
         });

         // check URL hash and open as well
         if( (window.location.hash === "#comments") || (window.location.hash === "#respond") ) {

         		$('#comments .inner').fadeIn();
         		$('html,body').delay(500).animate({scrollTop:jQuery('#comments .inner').offset().top-113}, 500);
         }

				$('.single-post .comments a').on( 'click' , function () {

						$('#comments .inner').fadeIn();
						$('html,body').delay(500).animate({scrollTop:jQuery('#comments .inner').offset().top-113}, 500);

				});


        //
        //  FitVids
        //
        $("article").fitVids();

        //
        // Grab captions
        //
        $('.gallery-item a img').each( function() {

        	var imageCaption = $(this).attr("title");

        	$(this).parent().attr("title" , imageCaption);

        });

        //
        // Remove style from captions
        //
        $('.wp-caption').each(function () {
            $(this).css('width','');
        });

        //
        // Resize events
        //
        $(window).resize(function () {


        });

    }); // end document.ready


})(jQuery);
