(function( $ ) {
    "use strict";
    
    //
    // Kill body animations
    //
    $('html > body').css('-webkit-animation-delay' , 0)
    .css('-moz-animation-delay' , 0)
    .css('-o-animation-delay' , 0)
    .css('-ms-animation-delay' , 0)
    .css('animation-delay' , 0);
 	 	
 	//
 	// Colours
 	//
 	wp.customize( 'color_main', function( value ) {
 	    value.bind( function( to ) {
 	        $( 'body' ).css( 'color', to );
 	    } );
 	});
 	
 	wp.customize( 'color_link', function( value ) {
 	    value.bind( function( to ) {
 	        $( '.post p a, a.more-link:hover' ).css( 'color', to );
 	    } );
 	});
 	
 	
 	wp.customize( 'color_link_hover', function( value ) {
 	    value.bind( function( to ) {
 	        $( 'a:hover' ).css( 'color', to );
 	    } );
 	});
 	
 	
 	wp.customize( 'color_footer_widget_link', function( value ) {
 	    value.bind( function( to ) {
 	        $( '.footer-widgets .widget a' ).css( 'color', to );
 	    } );
 	});
 	
 	wp.customize( 'color_footer_widget_link_hover', function( value ) {
 	    value.bind( function( to ) {
 	        $( '.footer-widgets .widget a:hover' ).css( 'color', to );
 	    } );
 	});
 	
 	
 	wp.customize( 'color_meta', function( value ) {
 	    value.bind( function( to ) {
 	        $( 'ul.meta, ul.meta a, .post-tags.tag, .post-tags.tag a' ).css( 'color', to );
 	    } );
 	});
 	
 	wp.customize( 'color_meta_link_hover', function( value ) {
 	    value.bind( function( to ) {
 	        $( 'ul.meta a:hover, .post-tags.tag a:hover' ).css( 'color', to );
 	    } );
 	});
 	
 	
 	
    wp.customize( 'color_archive_title_link', function( value ) {
        value.bind( function( to ) {
            $( '.main-archive h2 a' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'color_archive_title_link_hover', function( value ) {
        value.bind( function( to ) {
            $( '.main-archive h2 a:hover' ).css( 'color', to );
        } );
    });
    
    
    
    wp.customize( 'color_headings', function( value ) {
        value.bind( function( to ) {
            $( 'h1, h2, h3, h4, h5, h6' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'color_blog_title', function( value ) {
        value.bind( function( to ) {
            $( '.blog-title a' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'color_blog_title_hover', function( value ) {
        value.bind( function( to ) {
            $( '.blog-title a:hover' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'color_blog_tagline', function( value ) {
        value.bind( function( to ) {
            $( '.blog-tagline' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'color_nav_link', function( value ) {
        value.bind( function( to ) {
            $( '.site-navigation a, .site-navigation h4, .sitenav-main a' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'color_nav_link_hover', function( value ) {
        value.bind( function( to ) {
            $( '.site-navigation ul li.sfHover a, .site-navigation ul li a:hover, .site-navigation li.current_page_item a, .site-navigation li.current-menu-item a, .site-navigation li.current_page_ancestor a, .site-navigation li.current_page_parent a, nav.sitenav main li.current-post-ancestor a, .site-navigation li.current-page-ancestor a, .site-navigation a:hover,.site-navigation ul li.sfHover a,.site-navigation ul li a:hover, .site-navigation li.current_page_item a,.site-navigation li.current-menu-item a,.site-navigation li.current_page_ancestor a, .site-navigation li.current_page_parent a,.site-navigation li.current-post-ancestor a, .site-navigation li.current-page-ancestor a,.site-navigation a:hover,.sitenav-main ul li.sfHover a,.sitenav-main ul li a:hover, .sitenav-main li.current_page_item a,.sitenav-main li.current-menu-item a,.sitenav-main li.current_page_ancestor a, .sitenav-main li.current_page_parent a,.sitenav-main li.current-post-ancestor a, .sitenav-main li.current-page-ancestor a,.sitenav-main a:hover' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'color_amp', function( value ) {
        value.bind( function( to ) {
            $( 'h1 .amp' ).css( 'color', to );
        } );
    });  
    
   wp.customize( 'color_single_lead', function( value ) {
       value.bind( function( to ) {
           $( '.lead h1, .lead .meta.top, .lead .meta.top a' ).css( 'color', to );
       } );
   });  
   
   wp.customize( 'color_single_lead_hover', function( value ) {
       value.bind( function( to ) {
           $( '.lead .meta.top a:hover' ).css( 'color', to );
       } );
   });  
   
   wp.customize( 'color_amp', function( value ) {
       value.bind( function( to ) {
           $( 'h1 .amp' ).css( 'color', to );
       } );
   });  
   
   wp.customize( 'color_menu_control', function( value ) {
       value.bind( function( to ) {
        	$( '#menu-control' ).css( 'color', to );
        	$( '#menu-control:after, #menu-control:before' ).css( 'border-color', to );
       } );
   });  
   
   
   wp.customize( 'color_link_format', function( value ) {
       value.bind( function( to ) {
        	$( '.format-link h3.link a' ).css( 'color', to );
       } );
   });  
   
   wp.customize( 'color_link_format_hover', function( value ) {
       value.bind( function( to ) {
        	$( '.format-link h3.link a:hover' ).css( 'color', to );
       } );
   });  
   
   wp.customize( 'color_link_comment_title', function( value ) {
       value.bind( function( to ) {
        	$( '#respond-title a' ).css( 'color', to );
       } );
   }); 
   
   wp.customize( 'color_link_pagination_hover', function( value ) {
       value.bind( function( to ) {
        	$( '.pagination a:hover' ).css( 'color', to );
       } );
   }); 
   
   
   wp.customize( 'color_link_pagination', function( value ) {
       value.bind( function( to ) {
        	$( '.pagination a' ).css( 'color', to );
       } );
   }); 
  
    
    //
    // Background Colours
    //
    wp.customize( 'bg_color_flex_caption', function( value ) {
        value.bind( function( to ) {
            $( '.flex-caption' ).css( 'background-color', to );
        } );
    });   		
    		
	wp.customize( 'bg_color_archive_post_image', function( value ) {
	    value.bind( function( to ) {
	        $( '.post-image' ).css( 'background-color', to );
	    } );
	});      		
    
    wp.customize( 'bg_color_comment_title', function( value ) {
        value.bind( function( to ) {
            $( '#respond-title a' ).css( 'background-color', to );
        } );
    });  
    
    wp.customize( 'bg_color_flexslider', function( value ) {
        value.bind( function( to ) {
            $( 'a.flex-next, a.flex-prev' ).css( 'background-color', to );
        } );
    });  
    
    wp.customize( 'bg_color_format_link', function( value ) {
        value.bind( function( to ) {
            $( '.format-link h3.link a' ).css( 'background-color', to );
        } );
    });  
    
    wp.customize( 'bg_color_slab', function( value ) {
        value.bind( function( to ) {
            $( '.slab' ).css( 'background-color', to );
        } );
    });     
    
    wp.customize( 'bg_color_sitenav', function( value ) {
        value.bind( function( to ) {
            $( '.site-navigation' ).css( 'background-color', to );
        } );
    });    
    
    wp.customize( 'bg_color_header', function( value ) {
        value.bind( function( to ) {
            $( 'header.header' ).css( 'background-color', to );
        } );
    });
        
        
    wp.customize( 'bg_color_sitehead', function( value ) {
        value.bind( function( to ) {
            $( '.lead' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'bg_color_widgets', function( value ) {
        value.bind( function( to ) {
            $( '.footer-widgets' ).css( 'background-color', to );
        } );
    });
    
    
    wp.customize( 'bg_color_wrap', function( value ) {
        value.bind( function( to ) {
            $( '#wrap' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'bg_color_body', function( value ) {
        value.bind( function( to ) {
            $( 'body' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'bg_color_post', function( value ) {
        value.bind( function( to ) {
            $( '.inner' ).css( 'background-color', to );
        } );
    });
    
    
    wp.customize( 'border_color', function( value ) {
        value.bind( function( to ) {
            $( '.pagination, .older-posts' ).css( 'border-color', to );
        } );
    });
    
    wp.customize( 'border_color_blockquote', function( value ) {
        value.bind( function( to ) {
            $( 'blockquote' ).css( 'border-color', to );
        } );
    });
    
    
    
    
    wp.customize( 'button_color', function( value ) {
        value.bind( function( to ) {
            $( 'button, input[type=submit], .form-submit input' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'button_color_hover', function( value ) {
        value.bind( function( to ) {
            $( 'button:hover, input[type=submit]:hover, .form-submit input:hover' ).css( 'background-color', to );
        } );
    });
    
    
    
    
    
   
    
    //
    // Font Options
    //
    var hFont = 'Lato';
    wp.customize( 'font_headings', function( value ) {
        value.bind( function( to ) {
     
            switch( to.toString().toLowerCase() ) {
            
            	case 'LeagueGothicRegular':
            		hFont = 'League Gothic';
            		break;
            
            	case 'Lato':
            	    hFont = 'Lato';
            	    break;
            	    
            	case 'Noto Serif':
            	    hFont = 'Noto Serif';
            	    break;
     
                case 'times':
                    hFont = 'Times New Roman';
                    break;
     
                case 'arial':
                    hFont = 'Arial';
                    break;
                    
  				case 'helvetica':
  				    hFont = 'Helvetica';
  				    break;      
  				    
  				case 'verdana':
  				    hFont = 'Verdana';
  				    break;           
  				    
  				case 'georgia':
  				    hFont = 'Georgia';
  				    break;         
     
                case 'courier':
                    hFont = 'Courier New, Courier';
                    break;
     
                case 'Helvetica Neue':
                    hFont = 'Helvetica Neue';
                    break;
     
                default:
                    hFont = 'Lato';
                    break;
     
            }
     
            $( '.blog-title,.blog-tagline,h1, h2, h3,h4, h5, h6,.more-link,.meta,.pagination,.comment-reply-link,button,input[type=submit],#menu-control,.site-navigation,footer.footer' ).css({
                fontFamily: hFont
            });
     
        });
     
    });
    
    // Main Font Options
    var mFont = 'Noto Serif';
    wp.customize( 'font_main', function( value ) {
        value.bind( function( to ) {
     
            switch( to.toString().toLowerCase() ) {
            
            	case 'LeagueGothicRegular':
            		mFont = 'League Gothic';
            		break;
            
            	case 'Noto Serif':
            	    mFont = 'Noto Serif';
            	    break;
     
                case 'times':
                    mFont = 'Times New Roman';
                    break;
     
                case 'arial':
                    mFont = 'Arial';
                    break;
                    
    				case 'helvetica':
    				    mFont = 'Helvetica';
    				    break;      
    				    
    				case 'verdana':
    				    mFont = 'Verdana';
    				    break;           
    				    
    				case 'georgia':
    				    mFont = 'Georgia';
    				    break;         
     
                case 'courier':
                    mFont = 'Courier New, Courier';
                    break;
     
                case 'Helvetica Neue':
                    mFont = 'Helvetica Neue';
                    break;
     
                default:
                    mFont = 'Noto Serif';
                    break;
     
            }
     
            $( 'body, input[type=text], input[type=email], input[type=tel], input[type=url], input[type=password], textarea, input[type=submit]' ).css({
                fontFamily: mFont
            });
     
        });
        
    }); 

    //
    // Logo images
    //
    
    wp.customize( 'meanthemes_logo_image', function( value ) {
        value.bind( function( to ) {
     
            0 === $.trim( to ).length ?
                $( 'header .logo img' ).remove() :
                $( 'header .logo' ).prepend( '<img src="' + to + '" />' );
     
        });
    });
    
    
    //
    // Background images
    //
    
    wp.customize( 'meanthemes_background_image', function( value ) {
        value.bind( function( to ) {
     
            0 === $.trim( to ).length ?
                $( '.lead-image' ).css( 'background-image', '' ) :
                $( '.lead-image' ).css( 'background-image', 'url( ' + to + ')' );
     
        });
    });
    
    wp.customize( 'body_background_tile_image', function( value ) {
        value.bind( function( to ) {
     
            0 === $.trim( to ).length ?
                $( 'body' ).css( 'background-image', '' ) :
                $( 'body' ).css( 'background-image', 'url( ' + to + ')' );
     
        });
    });
    
    
    // Display Options
    
    wp.customize( 'footer_tagline', function( value ) {
        value.bind( function( to ) {
            $( '#footer-text' ).html( to );
        });
    });
    
    wp.customize( 'home_slab', function( value ) {
        value.bind( function( to ) {
            $( '.home .slab h1' ).html( to );
        });
    });
    
    wp.customize( 'home_slab_404', function( value ) {
        value.bind( function( to ) {
            $( '.error404 .slab h1' ).html( to );
        });
    });
    
    
    wp.customize( 'text_posts', function( value ) {
        value.bind( function( to ) {
            $( '.navigation-posts-text' ).html( to );
        });
    });
    
    wp.customize( 'text_navigation', function( value ) {
        value.bind( function( to ) {
            $( '.navigation-title-text' ).html( to );
        });
    });
    
    
    
    
    
     wp.customize( 'hide_logo_text', function( value ) {
        value.bind( function( to ) {
            true === to ? $( '.blog-title' ).hide() : $( '.blog-title' ).show();
        } );
    } ); 
    
    wp.customize( 'hide_tagline', function( value ) {
        value.bind( function( to ) {
            true === to ? $( '.blog-tagline' ).hide() : $( '.blog-tagline' ).show();
        } );
    } ); 
    
    
   
    
    
    wp.customize( 'hide_slab', function( value ) {
        value.bind( function( to ) {
            true === to ? $( '.home .slab' ).hide() : $( '.home .slab' ).show();
        } );
    } ); 
    
    
    wp.customize( 'hide_navigation_overlay', function( value ) {
        value.bind( function( to ) {
            true === to ? $( '.navigation-title-text' ).hide() : $( '.navigation-title-text' ).show();
        } );
    } ); 
    
    wp.customize( 'hide_recent_posts_overlay', function( value ) {
        value.bind( function( to ) {
            true === to ? $( '.navigation-posts-text' ).hide() : $( '.navigation-posts-text' ).show();
        } );
    } ); 
    
    
    wp.customize( 'hide_menu_icon', function( value ) {
        value.bind( function( to ) {
            true === to ? $( '#menu-control' ).hide() : $( '#menu-control' ).show();
        } );
    } ); 
    
    
    wp.customize( 'hide_sidebar', function( value ) {
        value.bind( function( to ) {
            
            if ( true === to ) {
            
            	$( '.sidebar-hold' ).hide()
            	$( 'html' ).removeClass( '.sidebar-on' );
            
            } else {
            
            	$( '.sidebar-hold' ).show()
            	$( 'html' ).addClass( '.sidebar-on' );

            }
            
            
        } );
    } ); 
    
    
    wp.customize( 'font_uppercase', function( value ) {
            value.bind( function( to ) {
                
                if ( true === to ) {
                
                	$( '.blog-title,article h1, h2, h3,h4, h5, h6,.blog-tagline,.more-link,.meta,.pagination,.comment-reply-link,button,input[type=submit],#menu-control,.site-navigation .sitenav-posts,footer.footer' ).css( 'text-transform' , 'uppercase' );
                
                } else {
                
                	$( '.blog-title,article h1, h2, h3,h4, h5, h6,.blog-tagline,.more-link,.meta,.pagination,.comment-reply-link,button,input[type=submit],#menu-control,.site-navigation .sitenav-posts,footer.footer' ).css( 'text-transform' , 'none' );
    
                }
                
                
            } );
        } ); 
    
  
    
    
    
    
    wp.customize( 'image_center', function( value ) {
        value.bind( function( to ) {
        	
        	if ( true === to ) {
        	
        		$( '.post-image' ).css('width' , '100%'); 
        		$( '.post-image img' ).css('margin-left' , 'auto').css('margin-right' , 'auto'); 
        	
        	} else {
        	
        		$( '.post-image' ).css('width' , 'auto');
        		$( '.post-image img' ).css('margin-left' , '0').css('margin-right' , '0'); 
        	}
        
        } );
    } ); 
    
    
    
    wp.customize( 'center_header', function( value ) {
        value.bind( function( to ) {
        	
        	if ( true === to ) {
        	
        		$( '.center-header header.header .logo, .center-header header.header .blog-tagline, .center-header header.header nav' )
        		.css('text-align' , 'center') 
        		.css('width' , '100%')
        		.css('display' , 'block'); 
        	
        	} else {
	        	
	        	$( '.center-header header.header .logo, .center-header header.header .blog-tagline, .center-header header.header nav' )
	        	.css('text-align' , 'left') 
	        	.css('width' , 'auto')
	        	.css('display' , 'block'); 
        	}
        
        } );
    } ); 
    
 
})( jQuery );