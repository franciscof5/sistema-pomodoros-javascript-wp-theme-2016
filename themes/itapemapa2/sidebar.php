<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<style type="text/css">
	
	.secondary-navigation a:before {
		content: "";
		height: 20px;
		width: 20px;
		float: right;
		background: #FFF;
		border-radius: 7px;
	}
	.cat-item-23 a:before {background: #FF0;}
	.cat-item-19 a:before {background: #ff78be;}
	.cat-item-81 a:before {background: #d45500;}
	.cat-item-190 a:before {background: #447821;}
	.cat-item-176 a:before {background: #a7ac93;}
	.cat-item-189 a:before {background: #216778;}
	
	
	/*
	.cat-item-23 a:before,
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=alimentacao"]:before,
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=alimentacao"] a:before,
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=beleza"]:before,
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=casa-e-construcao"]:before,
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=comercio"]:before,
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=industria"]:before,
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=servicos"]:before {
		content: "";
		height: 20px;
		width: 20px;
		float: right;
		background: #FFF;
	}

	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=alimentacao"]:before {background: #FF0;}
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=beleza"]:before {background: #ff78be;}
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=casa-e-construcao"]:before {background: #d45500;}
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=comercio"]:before {}
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=industria"]:before {}
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=servicos"]:before {}

	/*a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=alimentacao"],
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=alimentacao"] > ul li a  {
		background: #FF0;
	}

	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=beleza"],
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=beleza"] > ul li a  {
		background: #ff78be;
	}

	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=casa-e-construcao"],
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=casa-e-construcao"] > ul li a  {
		background: #d45500;
	}

	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=comercio"],
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=comercio"] > ul li a  {
		background: #ff78be;
	}

	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=industria"],
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=industria"] > ul li a  {
		background: #ff78be;
	}

	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=servicos"],
	a[href="http://localhost/itapemapa/itapemapa.com.br/?bgmp-category=servicos"] > ul li a  {
		background: #ff78be;
	}*/
	
</style>
<div id="secondary">
	<?php
		$description = get_bloginfo( 'description', 'display' );
		if ( ! empty ( $description ) ) :
	?>
	<!--h2 class="site-description"><?php echo esc_html( $description ); ?></h2-->
	
	<?php endif; ?>
	

	<?php /*
	<br />
	<!--style type="text/css">
		#menu-lateral-twenty-fourteen2 li {
			height: 40px;
			line-height: 40px;
			font-size: 16px;
		}
		#menu-lateral-twenty-fourteen2 li:content {
			float:right;
			
		}
		#menu-lateral-twenty-fourteen2 li a{
			float:left;
			line-height: 15px;
			font-size: 14px;
			width: 73%;
			white-space: nowrap;
		}

	</style>
	<script type="text/javascript">
		jQuery( document ).ready(function($) {
			/*jQuery(".cat-item").each(function (i) {
				$(this).css("width", "100%")
			});
			/*jQuery(".cat-item").each(function (i) {
				if($(this).text().length<40) {
					//isso exclui os pais tipo ALIMENTACAO que teria um texto com todos os filhos
					//alert(i + " a " + ($(this).text()));
					//
					$(this).find('a').text($(this).text());
					clonea = $(this).find('a').clone();
					$(this).html(clonea);
					//$(this).find('a').css("width", "100%");
				}
			});


			/*$(".children").each(function(i){
				//alert(i + " a " + $(this).parent().text());
				clonepai = $(this).parent().clone();
				clonepaiul = clonepai.find('ul').clone()
				clonepai.find('ul').remove();
				//alert("clonepai.text():"+clonepai.text());
				clonepai.find('a').text(clonepai.text());
				//alert("clonepai.find('a').text()"+clonepai.find('a').text());
				clonepaia = clonepai.find('a').clone();
				//clonefinal = clonepaia.html() + clonepaiul.html();
				$(this).parent().html(clonepaia);
				//clonepaia.prependTo($(this).parent().parent());
				clonepaiul.insertAfter($(this).find('a'));
				//$(this).parent().append(clonepaiul);
			});*/

			/*$("#menu-lateral-twenty-fourteen2").children(function (i){
				alert(i + " a " + ($(this).text()));
			});*
			//appendTo($(this).parent());
			//alert(jQuery("#menu-lateral-twenty-fourteen2 li:content"));
			//alert(jQuery("#menu-lateral-twenty-fourteen2 li:after").html());
			//alert("12313");
		});
	</script-->
	*/ ?>
	
	<?php if(is_front_page()) { ?>
		<script type="text/javascript">
			jQuery( document ).ready(function($) {
					if($(window).width()>670)
					$("#secondary").height($("#main").height()+800);
			});
		</script>
	<?php } else { ?>
		<script type="text/javascript">
			jQuery( document ).ready(function($) {
					if($(window).width()>670)
					$("#secondary").height($("#main").height());
			});
		</script>
	<?php } ?>
	<?php if ( has_nav_menu( 'secondary' ) ) : ?>
	<h3>Comercial</h3>
	<nav role="navigation" class="navigation site-navigation secondary-navigation">
		<?php /*wp_nav_menu( array( 'theme_location' => 'secondary' ) );*/ ?>
			<ul id="menu-lateral-twenty-fourteen2" class="menu">
			<?php 
				#wp_list_categories( "taxonomy=categoria&child_of=175&hierachical=17&title_li=&show_count=1&echo=1" );
				/*$args = array(
				  'taxonomy'     => "bgmp-category",
				  'parent'     => 175,
				  #'show_count'   => true,
				  'pad_counts'   => true,
				  'hierarchical' => true,
				  'title_li'     => ""
				);
				wp_list_categories( $args );

				$terms = get_terms( array( 
				    'taxonomy' => 'bgmp-category',
				    #'child_of'     => 175,
				    #'parent'   => 175
				) );*/
				#var_dump( $terms );die;
				wp_list_categories( "taxonomy=bgmp-category&child_of=175&hierachical=17&title_li=&show_count=0&echo=1" );
			?>
			</ul>
	</nav>
	<h3>Árvores</h3>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
		
	</div><!-- #primary-sidebar -->
	<?php endif; ?>
</div><!-- #secondary -->
