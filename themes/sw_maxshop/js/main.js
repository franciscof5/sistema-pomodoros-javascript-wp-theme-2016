(function($) {
	"use strict";
	/* Add Click On Ipad */
	$(window).resize(function(){
		var $width = $(this).width();
		if( $width < 1199 ){
			$( '.primary-menu .nav .dropdown-toggle'  ).each(function(){
				$(this).attr('data-toggle', 'dropdown');
			});
		}
	});
    jQuery('.phone-icon-search').click(function(){
        jQuery('.top-search').toggle("slide");
    });
	
	$('ul.orderby.order-dropdown li ul').hide(); 
	$("ul.order-dropdown > li").each( function(){
		$(this).hover( function() {
			$(this).find( '> ul' ).stop().fadeIn("fast");
		}, function() {
				$(this).find( '> ul' ).stop().fadeOut("fast");
		});
	});
	
	
	/*Product listing select box*/
	jQuery('.catalog-ordering .orderby .current-li a').html(jQuery('.catalog-ordering .orderby ul li.current a').html());
	jQuery('.catalog-ordering .sort-count .current-li a').html(jQuery('.catalog-ordering .sort-count ul li.current a').html());

var mobileHover = function () {
    $('*').on('touchstart', function () {
        $(this).trigger('hover');
    }).on('touchend', function () {
        $(this).trigger('hover');
    });
};

mobileHover();

    jQuery('.product-categories')
        .find('li:gt(4)') 
        .hide()
        .end()
        .each(function(){
            if($(this).children('li').length > 4){ 
                $(this).append(
                    $('<li><a>See more   +</a></li>')
                        .addClass('showMore')
                        .click(function(){
                            if($(this).siblings(':hidden').length > 0){
                                $(this).html('<a>See less   -</a>').siblings(':hidden').show(400);
                            }else{
                                $(this).html('<a>See more   +</a>').show().siblings('li:gt(4)').hide(400);
                            }
                        })
                );
            }
        });
    
		/* brand view more */
		$('.bran2-layout-slider').each(function(){
			var this_target = $(this).find( 'ul.bran2' );
			var brand_number = $(this).data( 'number' ) - 1;
			var brand_target = $(this).find( '.block-title > a' );
			$(this).find('li:gt(' + brand_number +')') 
        .hide()
        .end();        
			if( this_target.children('li').length > brand_number ){ 
				brand_target.click(function(){
					if(this_target.children('li').siblings(':hidden').length > 0){
							this_target.children('li').siblings(':hidden').show(400);
					}
				});
			}
			var el = $(this);
			setTimeout(function(){
				el.removeClass("loading");
			}, 1000);
		});


		/*Form search iP*/
    $('a.phone-icon-menu').click(function(){
      $('.navbar-inner.navbar-inverse').toggle( "slide" );
			$('.navbar-inner.navbar-inverse').find( '.menu-responsive-wrapper' ).toggleClass( 'collapse' );
			$(this).toggleClass('active');
    });
		
	$('.ya-tooltip').tooltip();

	$('.accordion-heading').each(function(){
		var $this = $(this), $body = $this.siblings('.accordion-body');
		if (!$body.hasClass('in')){
			$this.find('.accordion-toggle').addClass('collapsed');
		}
	});
	


	$(document).on('click.twice', '.open [data-toggle="dropdown"]', function(e){
		var $this = $(this), href = $this.attr('href');
		e.preventDefault();
		window.location.href = href;
		return false;
	});

    $('#cpanel').collapse();

    $('#cpanel-reset').on('click', function(e) {

    	if (document.cookie && document.cookie != '') {
    		var split = document.cookie.split(';');
    		for (var i = 0; i < split.length; i++) {
    			var name_value = split[i].split("=");
    			name_value[0] = name_value[0].replace(/^ /, '');

    			if (name_value[0].indexOf(cpanel_name)===0) {
    				$.cookie(name_value[0], 1, { path: '/', expires: -1 });
    			}
    		}
    	}

    	location.reload();
    });

	$('#cpanel-form').on('submit', function(e){
		var $this = $(this), data = $this.data(), values = $this.serializeArray();

		var checkbox = $this.find('input:checkbox');
		$.each(checkbox, function() {

			if( !$(this).is(':checked') ) {
				name = $(this).attr('name');
				name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

				$.cookie( name , 0, { path: '/', expires: 7 });
			}

		})

		$.each(values, function(){
			var $nvp = this;
			var name = $nvp.name;
			var value = $nvp.value;

			if ( !(name.indexOf(cpanel_name + '[')===0) ) return ;


			name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

			$.cookie( name , value, { path: '/', expires: 7 });

		});

		location.reload();

		return false;

	});

	$('a[href="#cpanel-form"]').on( 'click', function(e) {
		var parent = $('#cpanel-form'), right = parent.css('right'), width = parent.width();

		if ( parseFloat(right) < -10 ) {
			parent.animate({
				right: '0px',
			}, "slow");
		} else {
			parent.animate({
				right: '-' + width ,
			}, "slow");
		}

		if ( $(this).hasClass('active') ) {
			$(this).removeClass('active');
		} else $(this).addClass('active');

		e.preventDefault();
	});

/*currency Selectbox*/
	$('.currency_switcher li a').click(function(){
		$current = $(this).attr('data-currencycode');
		jQuery('.currency_w > li > a').html($current);
	});
	
	$(document).ready(function(){
		/* Quickview */
		$('.fancybox').fancybox({
			'width'     : 800,
			'height'   : 600,
			'autoSize' : false,
			helpers:  {
				title:  null
			},
			afterShow: function() {
				$( '.quickview-container .product-images' ).each(function(){
					var $id = this.id;
					var $rtl = $('body').hasClass( 'rtl' );
					var $img_slider = $( '#' + $id + ' .product-responsive');
					var $thumb_slider = $( '#' + $id + ' .product-responsive-thumbnail' )
					$img_slider.slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						fade: true,
						arrows: false,
						rtl: $rtl,
						asNavFor: $thumb_slider
					});
					$thumb_slider.slick({
						slidesToShow: 3,
						slidesToScroll: 1,
						asNavFor: $img_slider,
						arrows: true,
						focusOnSelect: true,
						rtl: $rtl,
						responsive: [				
							{
							  breakpoint: 360,
							  settings: {
								slidesToShow: 2    
							  }
							}
						  ]
					});

					var el = $(this);
					setTimeout(function(){
						el.removeClass("loading");
					}, 1000);
				});
			}
		});
		/* Slider Image */
		$( '.product-images' ).each(function(){
			var $id 			= this.id;
			var $rtl 			= $(this).data('rtl');
			var $vertical		= $(this).data('vertical');
			var $img_slider 	= $( '#' + $id + ' .product-responsive');
			var $thumb_slider 	= $( '#' + $id + ' .product-responsive-thumbnail' );
			$img_slider.slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				fade: true,
				arrows: false,
				rtl: $rtl,
				asNavFor: $thumb_slider
			});
			$thumb_slider.slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				asNavFor: $img_slider,
				arrows: true,
				focusOnSelect: true,
				rtl: $rtl,
				vertical: $vertical,
				verticalSwiping: $vertical,
				responsive: [				
					{
					  breakpoint: 360,
					  settings: {
						slidesToShow: 2    
					  }
					}
				  ]
			});

			var el = $(this);
			setTimeout(function(){
				el.removeClass("loading");
			}, 1000);
		});
	});

	jQuery(document).ready(function(){
		var currency_show = jQuery('ul.currency_switcher li a.active').html();
		jQuery('.currency_to_show').html(currency_show);	
	}); 

	jQuery(function($){
	$("#ya-totop").hide();
	$(function () {
		var wh = $(window).height();
		var whtml = $(document).height();
		$(window).scroll(function () {
			if ($(this).scrollTop() > whtml/10) {
					$('#ya-totop').fadeIn();
				} else {
					$('#ya-totop').fadeOut();
				}
			});
		$('#ya-totop').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
			});
	});
	}); 

	/*currency Selectbox*/
	$('.currency_switcher li a').on('click', function(){
		var $current = $(this).attr('data-currencycode');
		jQuery('.currency_w > li > a').html($current);
	});
	/*language*/
	var $current ='';
	$('#lang_sel ul > li > ul li a').on('click',function(){
		$current = $(this).html();
		 $('#lang_sel ul > li > a.lang_sel_sel').html($current);
		 $a = $.cookie('lang_select_maxshop', $current, { expires: 1, path: '/'}); 
		});
	if( $.cookie('lang_select_maxshop') && $.cookie('lang_select_maxshop').length > 0 ) {
		$('#lang_sel ul > li > a.lang_sel_sel').html($.cookie('lang_select_maxshop'));
	}

	$('#lang_sel ul > li.icl-ar').click(function(){
		$('#lang_sel ul > li.icl-en').removeClass( 'active' );
		$(this).addClass( 'active' );
		$.cookie( 'sportbikes_lang_en' , 1, { path: '/', expires: 1 });
	});
	$('#lang_sel ul > li.icl-en').click(function(){
		$('#lang_sel ul > li.icl-ar').removeClass( 'active' );
		$(this).addClass( 'active' );
		$.cookie( 'sportbikes_lang_en' , 0, { path: '/', expires: -1 });
	});

	var Sportbikes_Lang = $.cookie( 'sportbikes_lang_en' );
	if( Sportbikes_Lang == null ){
		$('#lang_sel ul > li.icl-en').addClass( 'active' );
		$('#lang_sel ul > li.icl-ar').removeClass( 'active' );
	}else{
		$('#lang_sel ul > li.icl-en').removeClass( 'active' );
		$('#lang_sel ul > li.icl-ar').addClass( 'active' );
	}

	
	$('#lang_sel ul > li > a').click(function(){
		$('#lang_sel ul > li ul').slideToggle(); 
	});
	var $current ='';
	$('#lang_sel ul > li > ul li a').on('click',function(){
		$current = $(this).html();
		$('#lang_sel ul > li > a.lang_sel_sel').html($current);
		var $a = $.cookie('lang_select_maxshop', $current, { expires: 1, path: '/'});	
	});
	if( $.cookie('lang_select_maxshop') && $.cookie('lang_select_maxshop').length > 0 ) {
		$('#lang_sel ul > li > a.lang_sel_sel').html($.cookie('lang_select_maxshop'));
	}
	jQuery(document).ready(function(){
		jQuery('.wpcf7-form-control-wrap').hover(function(){
			$(this).find('.wpcf7-not-valid-tip').css('display', 'none');
		});
	});


	$('.wpb_map_wraper').click(function () {
		$('.wpb_map_wraper iframe').css("pointer-events", "auto");
	});

	$( ".wpb_map_wraper" ).mouseleave(function() {
		$('.wpb_map_wraper iframe').css("pointer-events", "none"); 
	});
	$('.listing-tab-shortcode .nav-tabs a').on('hover', function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
	/* Fix 2.1.0 */
	
	/* Header 4 */
	$('.phone-icon-category').on( 'click', function(){
		$( '.header-style4 .vertical_megamenu-header' ).toggle( 'slide' );
	});

	/* Header 4 */
	$('.phone-icon-category').on( 'click', function(){
		$( '.header-style6 .vertical_megamenu-header' ).toggle( 'slide' );
	});

	/* Header 4 */
	$('.phone-icon-category').on( 'click', function(){
		$( '.header-style8 .vertical_megamenu-header' ).toggle( 'slide' );
	});

	/*Search*/
	$(".sidebar-top-header .icon-search").click(function(){
		$(".sidebar-top-header .top-search").fadeToggle();
	});

	/*Heading toggle*/
	$(".sw-woo-tab .resp-tab .top-tab-listing .navbar-toggle").click(function(){
		$(".sw-woo-tab .resp-tab .top-tab-listing .nav-tabs").fadeToggle();
	});

	/*Heading chilcat*/
	$(".sw-woo-container-slider .category-wrap-cat .navbar-toggle").click(function(){
		$(".sw-woo-container-slider .category-wrap-cat .cat-list").fadeToggle();
	});
	
	/*
	** js mobile
	*/
	$('.single-product.mobile-layout .social-share .title-share').on('click', function(){
		$('.single-product.mobile-layout .social-share').toggleClass("open");
	});
	$('.single-post.mobile-layout .social-share .title-share').on('click', function(){
		$('.single-post.mobile-layout .social-share').toggleClass("open");
	});

	$('.single-post.mobile-layout .social-share.open .title-share').on('click', function(){
		$('.single-post.mobile-layout .social-share').removeClass("open");
	});
	
	$('.products-nav .filter-product').on('click', function(){
		$('.products-wrapper .filter-mobile').toggleClass("open");
		$('.products-wrapper').toggleClass('show-modal');
	});
	
	$('.products-nav .filter-product').on('click', function(){
		if( $( ".products-wrapper .products-nav .filter-product" ).not( ".filter-mobile" ) ){
			$('.products-wrapper').removeClass('show-modal');
		}	
	});
	
	$('.mobile-layout .vertical_megamenu .resmenu-container .navbar-toggle').on('click', function(){
		$('.mobile-layout .body-wrapper .container').toggleClass('open');
	});
	
	$('.mobile-layout .header-top-mobile .header-menu-categories .show_menu').on('click', function(){
		$('.mobile-layout .body-wrapper .container').toggleClass('open');
	});
	
	$('.footer-mstyle1 .footer-menu .footer-search a').on('click', function(){
		$('.top-form.top-search').toggleClass("open");
	});
	
	$('.footer-mstyle1 .footer-menu .footer-more a').on('click', function(){
		$('.menu-item-hidden').toggleClass("open");
	});
	
	$('.mobile-layout .back-history').on('click', function(){
		window.history.back();
	});

  $( window ).load(function() {
		/* Change Layout */
		$('.view-list').on('click',function(){
			$('.view-grid').removeClass('sel');
			$('.view-list').addClass('sel');
			jQuery("ul.products-loop").fadeOut(300, function() {
				jQuery(this).addClass("list").fadeIn(300).removeClass( 'grid' );
			});
		});
		
		$('.view-grid').on('click',function(){
			$( '.view-list' ).removeClass('sel');
			$( '.view-grid' ).addClass('sel');
			$("ul.products-loop").fadeOut(300, function() {
				$(this).removeClass("list").fadeIn(300).addClass( 'grid' );
			});
		});       
  });
		
}(jQuery));