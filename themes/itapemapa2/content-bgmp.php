<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
//NO FINAL DO ARQUIVO TEM COISA PRA KCT
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php twentyfourteen_post_thumbnail(); ?>

	<header class="entry-header">

		<?php
			//echo do_shortcode('[bgmp-map categories="'.$catAtual.'" width="100%" height="400"]');
			echo do_shortcode('[bgmp-map placemark="'.get_the_ID().'" width="100%" height="200" zoom="16"]');
		?>
		

		<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && twentyfourteen_categorized_blog() ) : ?>
		<div class="entry-meta">
			<span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfourteen' ) ); ?></span>
		</div>
		<?php
			endif;
		?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content single-post-type-bgmp">
		<?php
		$placemarkCategories = wp_get_object_terms( get_the_ID(), 'categoria' );
		$campos_customizados = get_post_custom(get_the_ID());
		$tipo_assinatura = $campos_customizados["tipo_assinatura"][0];
		if(!isset($tipo_assinatura) or $tipo_assinatura=="")
			$tipo_assinatura = "gratuito";
		
		//var_dump($campos_customizados["tipo_assinatura"][0]);die;
		$ar = array();
		$arNames = array();
		foreach( $placemarkCategories as $pc ) {
			if($pc->slug!=="mapa-comercial") {
				array_push($ar, $pc->slug);
				array_push($arNames, $pc->name);
			}
		}

		if(in_array("alimentacao", $ar)) {
			$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/alimentacao/default-marker-alimentacao-'.$tipo_assinatura.'.png';
		} elseif(in_array("beleza", $ar)) {
			$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/beleza/default-marker-beleza-'.$tipo_assinatura.'.png';
		} elseif(in_array("casa", $ar)) {
			$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/casa-e-construcao/default-marker-casa-e-construcao-'.$tipo_assinatura.'.png';
		} elseif(in_array("comercio", $ar)) {
			$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/comercio/default-marker-comercio-'.$tipo_assinatura.'.png';
		} elseif(in_array("industria", $ar)) {
			$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/industria/default-marker-industria-'.$tipo_assinatura.'.png';
		} elseif(in_array("servicos", $ar)) {
			$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/servicos/default-marker-servicos-'.$tipo_assinatura.'.png';
		}
		?>
		
		<img src="<?php echo $iconURL ?>" alt="icone" class="iconURL"/>

		<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
			/*if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			endif;*/
		?>
		
		<?php edit_post_link( __( 'Edit', 'twentyfourteen' ), '<span class="edit-link">', '</span>' ); ?>
		<hr class="separa-titulo" />
		

		<div id="dados-local">
			
				<!--h3>Curta no Facebook</h3-->
				<?php //wp_enqueue_script('facebook'); ?>
				<!--div class="fb-like" data-href="<?php echo esc_url( get_permalink() ); ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div-->
			

			<div class="entry-meta">
				<?php
					/* REMOVER LINK PARA COMENTARIOS
					if ( 'post' == get_post_type() )
						twentyfourteen_posted_on();

					if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
					<!--span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'twentyfourteen' ), __( '1 Comment', 'twentyfourteen' ), __( '% Comments', 'twentyfourteen' ) ); ?></span-->
					*/
					//endif;
				?>
				
			</div><!-- .entry-meta -->
			
			<p>
				<h3>Avalie a qualidade desse local</h3>
				<?php echo do_shortcode('[ratings id="'.get_the_ID().'"]'); ?>
			</p>
			
			<p>

			<?php
			
			$args = array(
				'numberposts' => -1,
				'order'=> 'DESC',
				'post_parent' => get_the_ID(),
			);

			$get_children_array = get_children($args);
			//var_dump($get_children_array);
			if( $get_children_array ) { ?>
				<h3>Locais internos</h3>
				<?php 
				foreach ($get_children_array as $child) {
					//echo $key." l ".$value;
					echo "<a href=/?p=$child->ID>".$child->post_title."</a><br />";
					//var_dump($ar);
				}
				//var_dump($get_children_array);
				?>
			<?php } ?>

			<?php
			$parentID = wp_get_post_parent_id(get_the_ID());
			if($parentID) { ?>
				<h3>Localizado dentro</h3>
				<?php 
				$link = get_the_permalink($parentID);
				echo "<a href=$link>".get_the_title($parentID)."</a>";
			}
			?>

			<h3>Categorias</h3>
				<p>
				<?php foreach ($ar as $key => $value) { 
					/*
					TODO: mostra nome pai e filho nas categoria
					var_dump($placemarkCategories);die;
					if ($key==0) 
						echo "categoria-pai<br/>"; 
					else
						echo "categoria-filho<br/>";*/
					?>
					<a href="<?php bloginfo(url) ?>/categoria/<?php echo $value ?>"><?php echo $arNames[$key] ?></a> <br />
				<?php } ?>
				</p>
			</p>
			
			<p>
				<h3>Telefone</h3>
				<?php
				if($tipo_assinatura=="gratuito") {
					echo "Sem assinatura - sem telefone";
				} else {
					//var_dump($campos_customizados);
					//echo $from = $campos_customizados["telefone"][1];
					//$from = get_post_meta(get_the_ID(), "bgmp_address", true);
					$from = get_field("field_51dc398792d10", get_the_ID());
					//1532726982
					$to = sprintf("(%s) %s-%s",
							substr($from, 0, 2),
							substr($from, 2, 4),
							substr($from, 4, 4));
					echo $to;
					//$from = $campos_customizados["telefone"][2];
					$from = get_field("field_522df2975f033", get_the_ID());
					if($from>0) {
						$to = sprintf("(%s) %s-%s",
								substr($from, 0, 2),
								substr($from, 2, 4),
								substr($from, 4, 4));
						echo "<br />".$to;
					}
				}
				//var_dump($campos_customizados);die;
				?>
			</p>
			
			<p>
				<h3>Endereço</h3>
				<?php
				//Esconde endereco de nao assinantes
				if($tipo_assinatura=="gratuito") {
					echo "Sem assinatura - sem endereço";
				} else {
					echo get_post_meta(get_the_ID(), "bgmp_address", true);
					//echo $campos_customizados["bgmp_address"][1];
				}
				?>
			</p>
			
			<p>
				<h3>Mais informações</h3>
				<?php
					if($tipo_assinatura=="gratuito") {
						echo "Sem assinatura - sem fotos e folhetos";
					} else {
						if($post->post_content == "") {
							echo "Ainda não recebemos fotos ou folhetos deste local";
						} else {
							wp_strip_all_tags(the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyfourteen' ) ) );
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) ) ;
						}
					}
					
				?>
			</p>

			<p>
				<h3>Tipo de assinatura</h3>
				<p>Assinante <?php echo $tipo_assinatura; ?></p>
			</p>

			<!--p>
				<h3>Sou o proprietario</h3>
				<p>Eu sou o proprietario deste local, gostaria de <a href="#">editar as informaçoes dessa pagina.</a></p>
			</p-->
			<p>
				<h3>Local por</h3>
				<?php the_author(); ?>
			</p>
			
			<p>
				<h3>Assinatura</h3>
				<!--p>Sou o proprietário do local e quero administrá-lo</p-->
				<!--p>Você pode editar as informações deste local e até mesmo removê-lo da lista após nossa equipe comprovar as informações</p-->
				<!--p>Primeiro você precisa comprar uma assinatura</p-->
				<?php if($tipo_assinatura=="gratuito")  { ?>
					<div class="aplicar-assinatura">
						<ul class="contem-botao-trocar-assinatura">
					    	<?php  
							$args = array( 'post_type' => 'product', 'posts_per_page' => 0, 'product_cat' => 'divulgar-empresas' );
							$loop = new WP_Query( $args );
							$desabilitado = "";
							while ( $loop->have_posts() ) : $loop->the_post(); 
								global $product; 
								$detalhes = $product->post;
								$qty_atual = get_user_meta(get_current_user_id(), $product->id, true );
								//var_dump($product);
								//var_dump($detalhes);
								if($tipo_assinatura == $detalhes->post_name) {
									$desabilitado = "selecionado";
								}
							?>
							<li class='botao-trocar-assinatura <?php echo $desabilitado; ?>' data-assinatura-id='<?php echo $product->id ?>' data-assinatura-nome='<?php echo $detalhes->post_title ?>' data-assinatura-slug="<?php echo $detalhes->post_name ?>" data-assinatura-quantidade="<?php echo $qty_atual ?>">
								<?php echo woocommerce_get_product_thumbnail(array(40,40)); ?>
								<?php //var_dump($d); ?>
								<span class="assinaturas-disponiveis" >
									<?php echo ($qty_atual=="" ? "0" : $qty_atual); ?>
								</span>
								<?php //var_dump($product); die; //?>
							</li>
							<?php
							//}
							endwhile; 
							wp_reset_query(); 
							?>
						</ul>
					</div>
				<?php } else { ?>
						<p>Assinante desde: <?php echo date('d/m/Y', strtotime(get_post_meta(get_the_ID(), "data_ativacao", true))); ?></p>
				<?php } ?>
				<!--a href="/">Entre em contato com departamento comercial</a-->
			</p>
			<br />

			<hr style="clear:both; margin-top:20px;"/>

			<?php if(get_the_author_id()==get_current_user_id()) { ?>
				<p>
					<h3>Visitas</h3>
					<span>Dia:<?php echo do_shortcode('[post_view time="day"]'); ?></span><br />
					<span>Semana:<?php echo do_shortcode('[post_view time="week"]'); ?></span><br />
					<span>Mês:<?php echo do_shortcode('[post_view time="month"]'); ?></span><br />
					<span><small>Informação restrita para assinante.</small></span>
				</p>
			<?php } ?>
			<p style="clear:both">
				<h3>Informar erro</h3>
				<p><small>Alguma informação errada? Você pode nos <a href="/?p=7154" alt="Informar problema para o suporte">informar um problema</a></small></p>
			</p>
			
		</div><!-- #dados-local -->
		
		<div id="orcamento-contato">
			<h3>Orçamento</h3>
			<?php $current_user = wp_get_current_user(); ?>
			<p>De onde estiver, sem gastar nada, solicite um orçamento agora mesmo!</p>
			<?php //echo (is_user_logged_in() ? "" : "disabled"); ?>
			<?php if(is_user_logged_in()) { ?>
				<a href="<?php echo bloginfo(url) ?>/editar-endereco/billing">editar meus dados</a>
				<p>
					<label for="requerenteNome">Responsável</label><br />
					<input type="text" id="requerenteNome" value='<?php echo $current_user->user_firstname." ".$current_user->user_lastname ?>' disabled>
				</p>
				<p>
					<label for="requerenteTelefone">Telefone</label><br />
					<input type="text" id="requerenteTelefone" value='<?php echo get_user_meta(get_current_user_id(), "billing_phone", true); ?>' disabled>
				</p>
				<p>
					<label for="requerenteEndereco">Endereço</label><br />
					<input type="text" id="requerenteEndereco" value='<?php echo get_user_meta(get_current_user_id(), "billing_address_1", true); ?>' disabled>
				</p>
				<p>
					<label for="requerenteEmail">Email para resposta</label><br />
					<input type="text" id="requerenteEmail" value='<?php echo $current_user->user_email ?>' disabled>
				</p>
				<p>
					<label for="requerenteMensagem">Qual a sua necessidade?</label><br />
					<textarea id="requerenteMensagem" placeholder="Descreva detalhadamente o que precisa"></textarea>
				</p>
				<p>
					<label for="quemProcessa">Quem deve processar o pedido?</label><br />
					<input type="radio" name="quemProcessa" value="equipeItapemapa" checked>Equipe Itapemapa<br />
					<small>Nossa equipe entra em contato com o local</small><br />
					<input type="radio" name="quemProcessa" value="proprietarioLoja" <?php echo ($campos_customizados["email"][1]=="" ? "disabled" : "") ?>>Proprietario do Local<br />
					<?php
					//echo "tipo_assinatura".$tipo_assinatura;die;
					/*if($tipo_assinatura!=="gratuito" && $tipo_assinatura!=="bronze" && $tipo_assinatura!=="")  {
						//echo "<p>Ass:ouro/prata</p>";
						if(get_the_author_id()==get_current_user_id()) {
							echo "<p>Assinante do local</p>";
							if($campos_customizados["email"][1]=="") {
								//$campos_customizados["email"][1]==the_author_meta("user_email", get_the_author_id());
								echo "<br>useremail:".$user_email = get_the_author_meta("user_email", get_the_author_id());
								echo "<br>postid".get_the_ID();
								//$atualizouemail = update_field("field_51dc4390560a6", $user_email, get_the_ID());
								//if($atualizouemail) {
									//echo '<script text="text/javascript">';
									//echo '$("#resposta_servidor").html( "response" );';
									//echo 'alert("Seu email foi cadastrado como email do local")';
									//echo '</script>';
								//}

							}
						}
						//echo the_author_meta("user_email", get_the_author_id());

						//<label for="requerenteMensagem">Qual a sua necessidade?</label><br />
					}*/
					//die;
					?>
					<small><?php echo ($campos_customizados["email"][1]=="" ? "Este local não possui email cadastrado" : "Enviar email diretamente para o local") ?></small><br />
				</p>
				<p><button id="enviaPedido">Solicitar Orçamento</button></p>
				<p><div id="resposta_servidor"></div></p>
				<p>
				<?php
					if($tipo_assinatura!=="gratuito" && $tipo_assinatura!=="bronze" && $tipo_assinatura!=="")  {
						echo '<label for="emailParaOrcamento">Email para orçamento</label><br />';
						echo get_field("field_51dc4390560a6", get_the_ID());
						//echo $campos_customizados["email"][1];
						//echo "dolocal2: ".get_field("field_51dc4390560a6", get_the_ID());
						//echo "<br>douser: ".get_the_author_meta("user_email", get_the_author_id());
					}
				?>
				<br />
				</p>
				
			<?php } else { ?>
				<p>Para solicitar um orçamento <a href="/">crie uma conta e acesse o sistema</a>.</p>
			<?php }?>
			
		</div><!-- #orcamento-contato -->

	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>
</article><!-- #post-## -->

<?php
?>

<?php wp_enqueue_script('modal-plugin'); ?>

<div id="aplicar-assinatura-confirmacao-modal" >
	<span class="button b-close"><span>X</span></span>
	<h3>NOME DO LOCAL</h3>
	<!--p id="assinatura-atual">Atualmente este local possui uma assinatura do tipo: OURO</p-->
	<p id="assinatura-descricao">Voce esta tentando aplicar uma assinatura do tipo: NÃO IDENTIFICADO</p>
	<p id="assinatura-opcao">Essa operacao foi interrompida, contate o suporte	</p>
	<button id="assinatura-acao">Aplicar Assinatura</button>
	<button id="fechar-modal" class="botaoFechar">Fechar</button>
	<p><div id="resposta_servidor"></div></p>
</div>



<script type="text/javascript">
	jQuery( document ).ready(function($) {
		//consertinhos na tela
		$('#reply-title').html("Já esteve neste local? Comente sua experiência");

		//
		var aplicou = false;
		
		//modal.close();
		
		$('.botao-trocar-assinatura').css( 'cursor', 'pointer' );

		$('.botao-trocar-assinatura').bind('click', function(e) {
			e.preventDefault();
			//$('#assinatura-acao').hide();
			// Para recarregar pagina depois de aplicar
			aplicou = false;
			// Dados do local
			//var tipoAssinaturaAtual = $(this).parent().parent().parent().parent().data("tipo-assinatura");
			var tipoAssinaturaAtual = '<?php echo $tipo_assinatura; ?>';
			//var dataUltimaAlteracao = $(this).parent().parent().parent().parent().data("ultima-alteracao");
			
			//na pagina antiga precisa pegar o id de onde clicava, aqui nao pois eh single.php
			//var local_id = $(this).parent().parent().parent().parent().data("local-id");
			var local_id = <?php echo get_the_ID() ?>;
			// Dados do plano a ser aplicado
			var tipoAssinaturaSelecionadaID = $(this).data("assinatura-id");
			var tipoAssinaturaSelecionadaSlug = $(this).data("assinatura-slug");
			var tipoAssinaturaSelecionadaNome = $(this).data("assinatura-nome");
			var tipoAssinaturaSelecionadaQuantidade = $(this).data("assinatura-quantidade");
			// Split timestamp into [ Y, M, D, h, m, s ]
			//var t = dataUltimaAlteracao.split(/[- :]/);
			// Apply each element to the Date function
			//var inicio = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
			//var hoje = new Date();
			//var diff = new Date(hoje - inicio);
			//var diasEmVigor = Math.round(diff/1000/60/60/24);
			var diasEmVigor = 10;
			
			//Muda o titulo do modal para o titulo do local
			//$("#aplicar-assinatura-confirmacao-modal").find("h3").html( "<?php echo get_the_title(); ?>" );
			$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-atual").html(
				"Atualmente este local possui uma assinatura do tipo: <strong>" + 
				tipoAssinaturaAtual +
				"</strong><br/>Em vigor há: <strong>" +
				diasEmVigor + 
				" dias</strong>.<br/>Restando: <strong>" +
				(365-diasEmVigor) +
				"</strong> dias para o vencimento."
			);
			$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-descricao").html(
				"Voce esta aplicando uma assinatura do tipo: <br/><strong>" + tipoAssinaturaSelecionadaNome + "</strong>"
			);
			$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
				"Voce possui <strong>" + tipoAssinaturaSelecionadaQuantidade + "</strong> disponíveis <br/>" +
				"Tem certeza que deseja aplicar esta assinatura?"
			);
			
			if(tipoAssinaturaSelecionadaQuantidade<=0) {
				$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
					'Você precisa comprar uma assinatura deste tipo antes de aplicar'																																			
				);
				$('#assinatura-acao').hide();
			} else {
				$('#assinatura-acao').show();
			}

			var modal = $("#aplicar-assinatura-confirmacao-modal").bPopup({
				onClose: function() {
					if(aplicou) {
						location.reload(true);
					}
				}
			});

			//tipoAssinaturaSelecionadaSlug
			//
			$('#assinatura-acao').bind('click', function(e) {
				e.preventDefault();
				//
				$(this).attr('disabled','disabled');
				$(this).html('aplicando...');
				//
				$("#resposta_servidor").html('<div class="avisoHolder avisoAtencao">Enviado dados para o servidor...</div>');
				
				data = {
					action: 'aplica_assinatura',
					assinaturaSlug: tipoAssinaturaSelecionadaSlug,
					assinaturaID: tipoAssinaturaSelecionadaID,
					assinaturaNome: tipoAssinaturaSelecionadaNome,
					localID: local_id,
				};
				//var ajaxurl = passado por wp_localize_script() em aa-itapemapa-functions.php "<?php echo admin_url('admin-ajax.php') ?>";	
				var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
				$.post( ajaxurl, data, function( response) {
					$("#resposta_servidor").html( "response" );
					aplicou = true;
					$("#fechar-modal").html("fechar e recarregar");
					$('#assinatura-acao').hide();
				});
			});

			
			$("#fechar-modal").bind('click', function(e) {
				e.preventDefault();
				modal.close();
			});
			//Muda a primeira frase, se nao eh assinante nao precisa de mais detalhes
			/*if(tipoAssinaturaAtual=="" || tipoAssinaturaAtual=="gratuito") {
				$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-atual").html(
					"Atualmente este local possui uma assinatura do tipo: <strong>" + tipoAssinaturaAtual
				);
			} else if(tipoAssinaturaAtual=="ouro") {
				//Segunda e terceira frase, com informacoes sobre a operacao e opcoes
				$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-descricao").html(
					"Este ja possui nosso melhor Plano de Assinatura."
				);
				$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
					'Aguarde o vencimento deste plano para aplicar outro.'
				);
			} else {
				if(tipoAssinaturaSelecionadaQuantidade>0) {
					if(tipoAssinaturaAtual=="" || tipoAssinaturaAtual=="gratuito") {
						$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-descricao").html(
							"Voce esta tentando aplicar uma assinaturo do tipo <strong>" + tipoAssinaturaSelecionadaNome + "</strong>"
						);
						$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
							"Voce possui <strong>" + tipoAssinaturaSelecionadaQuantidade + "</strong> disponíveis <br/>" +
							"Tem certeza que deseja aplicar esta assinatura?"
						);
						$('#assinatura-acao').show();
					} else {
						if(tipoAssinaturaAtual==tipoAssinaturaSelecionadaSlug) {
							$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-descricao").html(
								"Este local ja possui este tipo de assinatura."
							);
							$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
								'Esta operaçao nao e permitida.'
							);
						} else {
							$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-descricao").html(
								"Voce esta tentando aplicar uma assinaturo do tipo <strong>" + tipoAssinaturaSelecionadaNome + "</strong>"
							);
							$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
								"Voce possui <strong>" + tipoAssinaturaSelecionadaQuantidade + "</strong> disponíveis <br/>" +
								"Tem certeza que deseja aplicar esta assinatura?"
							);
							$('#assinatura-acao').show();
							if (tipoAssinaturaAtual=="bronze") {
								if(tipoAssinaturaSelecionadaSlug=="comercial") {
									$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-descricao").html(
										//$(this).find("img").attr("alt")
										"Voce esta tentando aplicar uma assinaturo do tipo <strong>" + tipoAssinaturaSelecionadaNome + "</strong>"
									);
									$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
										'Esta operaçao nao e permitida.'
									);
								}
							} else if (tipoAssinaturaAtual=="prata") {
								if(tipoAssinaturaSelecionadaSlug=="comercial" || tipoAssinaturaSelecionadaSlug=="bronze") {
									$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-descricao").html(
										//$(this).find("img").attr("alt")
										"Voce esta tentando aplicar uma assinaturo do tipo <strong>" + tipoAssinaturaSelecionadaNome + "</strong>"
									);
									$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
										'Esta operaçao nao e permitida.'
									);
								}
							}
						}
					}				
				} else {
					$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
						'Voce nao possui nenhuma assinatura deste tipo disponível'
					);
					$("#aplicar-assinatura-confirmacao-modal").find("#assinatura-opcao").html(
						'<a href="#">visite nossa loja e compre uma assinatura agora mesmo</a>'
					);
				}
				
			}*/
			
		
		});
		/* SISTEMA DE ORÇAMENTO */
		$("#enviaPedido").click(function() {
			
			$("#resposta_servidor").html('<div class="avisoHolder avisoAtencao">Enviado orçamento...</div>');
			
			if($("#requerenteMensagem").val()=="") {
				$("#resposta_servidor").html('<div class="avisoHolder avisoErro">Preencha os detalhes</div>');
				$("#requerenteMensagem").focus();
			} else {
				$("#enviaPedido").attr('disabled','disabled');
				$("#enviaPedido").html('enviando...');
				data = {
					action: 'solicita_orcamento',
					nome: $("#requerenteNome").val(),
					endereco: $("#requerenteEndereco").val(),
					telefone: $("#requerenteTelefone").val(),
					email: $("#requerenteEmail").val(),
					msg: $("#requerenteMensagem").val(),
					localNome: $(".entry-title").html(),
					indicadorID: <?php echo get_current_user_id() ?>,
					localID: <?php echo get_the_ID() ?>,
					quemProcessa: $('input[name=quemProcessa]:checked').val(),
				};
				var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
				$.post( ajaxurl, data, function( response) {
					$("#resposta_servidor").html( response );
					$("#enviaPedido").removeAttr('disabled');
					$("#enviaPedido").html('Solicitar Orçamento');
				});
			}
		});
	});
</script>
