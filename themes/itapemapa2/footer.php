<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

		</div><!-- #main -->
		<style type="text/css">
			.bubble {
				position: relative;
				width: 250px;
				/*height: 120px;*/
				padding: 0px;
				background: #FFFFFF;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 20px;
				margin: 0 auto;
				color: #000;
				padding: 20px;
				/**
				border: 7px #F00 solid*/
			}
			.bubble:after {
				content: '';
				position: absolute;
				border-style: solid;
				border-width: 20px 20px 0;
				border-color: #FFFFFF transparent;
				display: block;
				width: 0;
				z-index: 1;
				/*bottom: -15px;
				left: 110px;*/
				left: -20px !important;
				top: 150px !important;
			}
			.bubble-left:after {
				left: -15px !important;
				top: 45px !important;
			}
			/**/
			#colophon  {
				font-size: 16px;
			}
			#footer-rodape {
				clear:both;
				text-align:center;
				padding: 10px 0 0 0;
			}

			#footer-rodape a {
				color: #FFF !important;
			}
			#footer-rodape a:hover {
				color: #F33 !important;
			}

		</style>
		<footer id="colophon" class="site-footer" role="contentinfo" style="padding-top:20px;">
			<div style="width:25%; float:left; min-width:300px;">
				<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/atendimento-footer.png" alt="Imagem de uma atendente"/>
			</div>
			<div style="width:30%;float:left;min-width: 300px;"  class="bubble bubble2">
				<p style="font-size:18px;"><strong>Olá <?php global $current_user;get_currentuserinfo();echo $current_user->display_name; ?>, posso ajudar?</strong></p>
				<!--p>WhatsApp: <strong>(11)</strong></p-->
				<p>Escolha uma opção abaixo:</p>
				<ul>
					<li><strong>Comprar assinatura?</strong> <a href="/loja" alt="ir para a página de calendário de vendas">loja virtual de assinatura</a></li>
					<li><strong>Visita de vendedor?</strong> <a href="/?p=7165" alt="ir para a página de calendário de vendas">agendar visita de vendas</a></li>
					<li><strong>Dúvida comercial/financeiro?</strong> - <a href="/?p=7154" alt="ir para página de suporte">abrir ticket comercial</a></li>
					<li><strong>Suporte ao cliente?</strong> <a href="/?p=7154" alt="ir para página de suporte">abrir ticket de suporte</a></li>
				</ul>
				<p>Esse são os nossos canais de <strong>atendimento 24h</strong></p>
				<!--p>Para qualquer outro tipo de dúvida ou problema recomendo <a href="http://wp.me/P27Bpy-1Ro" alt="ir para página de suporte">abrir ticket geral</a>.</p>
				<p><small>Prazo máximo de resposta:24h</small></p-->
			</div>
			<div style="width:25%;float:left;min-width: 300px; padding:0 20px;">
				<h4>Hospedagem <a href="http://www.f5sites.com" alt="Ir para um site externo F5 Sites">F5 Sites</a></h4>
				<p>Hospede seu site ou projeto em nossos servidores</p>
				<h4>Desenvolvimento: <a href="http://www.franciscomat.com" alt="Ir para um site externo F5 Sites">Francisco Mat</a></h4>
				<p>Sites e aplicativos exclusivos</p>
				<h4>Comercialização: <a href="http://www.redemapas.com.br" alt="Ir para um site externo Rede Mapas">Rede Mapas</a></h4>
				<p>Entre na Rede Mapas e tenha seu próprio site de mapas com loja virtual de assinatura</p>
				<?php /*do_action( 'twentyfourteen_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentyfourteen' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentyfourteen' ), 'WordPress' ); ?></a>
				*/ ?>
			</div><!-- .site-info -->
			<?php //get_sidebar( 'footer' ); ?>

			<div id="footer-rodape">
				<!--p>Parceiros: <a href="http://www.saopaulomapa.com.br"><strong>Saopaulo</strong>mapa</a> | <a href="http://www.campinasmapa.com.br"><strong>Campinas</strong>mapa</a> | <a href="http://www.sorocabamapas.com.br"><strong>Sorocaba</strong>mapa</a> | <a href="http://www.itapevamapa.com.br"><strong>Itapeva</strong>mapa</a></p-->
				<!--p> <?php wp_list_pages('include=7220,7218,356,7154,7222'); ?></p-->
				<p><a href="/?p=7220">Termo de Uso</a>  |  <a href="/?p=7218">Contrato de Assinatura</a>  |  <a href="/?p=356">Quem Somos</a>  |  <a href="/?p=7154">Informar problemas no uso</a>  |  <a href="/?p=7222">Assessoria de Imprensa</a> <!-- |  Trabalhe conosco</p-->
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>