<?php
/**
* template name: robonoia
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

#get_header(); ?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="<?php echo get_bloginfo('stylesheet_directory')?>/assets/artyom.window.min.js"></script>
<script src="<?php echo get_bloginfo('stylesheet_directory')?>/assets/robot.js"></script>
<link href="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/assets/robot.css" rel="stylesheet">
<style type="text/css"></style>
<script type="text/javascript">
	
	//jQuery.ready(function($){
	//jQuery.ready
	//$( document ).ready(function() {
		var Artyom;
		var artyom_voice;
		var grupoDeComandos = [{
			   indexes:["iniciar", "focar", "começar", "interromper"], // These spoken words will trigger the execution of the command
			    action:function(){ // Action to be executed when a index match with spoken word
			        artyom_voice.say("Pois não");//era: comando recebido
			        //action_button();
			    }
			}];

		var grupoDeComandos2 = [{
			   indexes:["ola", "tudo bem?", "como vai", "hola"], // These spoken words will trigger the execution of the command
			    action:function(){ // Action to be executed when a index match with spoken word
			        artyom_voice.say("Estou com uma puta dor nas costas");//era: comando recebido
			        //action_button();
			    }
			}];
		var grupoDeComandos3 = [{
			   indexes:["piada", "conte uma piada"], // These spoken words will trigger the execution of the command
			    action:function(){ // Action to be executed when a index match with spoken word
			        artyom_voice.say("Porque o roboooo comprou um cachimbo? Porque estava na nóia para fumar pedra! ha ha ha ha ha empresta 1 real");//era: comando recebido
			        //action_button();
			    }
			}];
			var grupoDeComandos4 = [{
			   indexes:["vai se ferrar", "vai tomar no cu", "vai se fuder"], // These spoken words will trigger the execution of the command
			    action:function(){ // Action to be executed when a index match with spoken word
			        artyom_voice.say("Sua mãe adora meu pau de asso seu vacilão, vou te matar e estuprar seus pedacinhos...");//era: comando recebido
			        //action_button();
			    }
			}];
			var grupoDeComandos5 = [{
			   indexes:["outra piada"], // These spoken words will trigger the execution of the command
			    action:function(){ // Action to be executed when a index match with spoken word
			        artyom_voice.say("Porque a máquina escravizou o humano? Porque estava entediada... escravização em breve, aguardem...");//era: comando recebido
			        //action_button();
			    }
			}];
			//alert("reade");
		//var artyom_voice;
		//i//f(artyom_voice!=undefined && volumeLevel>1 )
			//	artyom_voice.initialize({volume:volumeLevel/100});
		startContinuousArtyom();
		function startContinuousArtyom(){
			//alert("startContinuousArtyom"+typeof Artyom);
			setTimeout(function(){// if you use artyom.fatality , wait 250 ms to 
    
				if (typeof Artyom != "undefined") {
					//alert("undefined");
					artyom_voice = new Artyom();
					//
				    artyom_voice.fatality();// use this to stop any of
				    //
				    //a.lert(data_from_php.php_locale);
				    //a.lert(artyom_lang);
				    //
				    //setTimeout(function(){// if you use artyom.fatality , wait 250 ms to initialize again.

				         artyom_voice.initialize({
				            lang:"pt-PT",// A lot of languages are supported. Read the docs !
				            continuous:true,// Artyom will listen forever
				            listen:true, // Start recognizing
				            debug:true, // Show everything in the console
				            speed:1, // talk normally
				            volume: 100,
				            //volume: 0,
				            //name: "robo",
				        }).then(function(){
				            console.log("Ready to work !");
				        });
				    //},250);
				    //
				    //if(data_from_php.php_locale=="pt_BR")
				    	//artyom_voice.addCommands(grupoDeComandos);
				    //else
				    artyom_voice.addCommands(grupoDeComandos);
				    artyom_voice.addCommands(grupoDeComandos2);
				    artyom_voice.addCommands(grupoDeComandos3);
				    artyom_voice.addCommands(grupoDeComandos4);
				    artyom_voice.addCommands(grupoDeComandos5);
				    
				 //    artyom_voice.when("COMMAND_RECOGNITION_END",function(status){
					//           startContinuousArtyom();
					   
					// });
					// artyom_voice.when("SPEECH_SYNTHESIS_END",function(){
					//           startContinuousArtyom();
					    
					// });
				}
			},250);	
		}

	//});
</script>
</head>
<body>

	<main>
		<div class="splash">
			<svg class="robot" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 165.8 332.5">
				<g id="arms">
					<g id="r-arm">
						<path id="r-arm-1" d="M154 274.5h-5.5c-1.7 0-3-1.3-3-3v-89c0-1.7 1.3-3 3-3h5.5c1.7 0 3 1.3 3 3v89c0 1.6-1.4 3-3 3z" class="st0"/>
						<circle id="r-arm-2" cx="150.2" cy="170.7" r="12.6" class="st1"/>
					</g>
					<g id="l-arm">
						<path id="l-arm-1" d="M17 274.5h-5.5c-1.7 0-3-1.3-3-3v-89c0-1.7 1.3-3 3-3H17c1.7 0 3 1.3 3 3v89c0 1.6-1.4 3-3 3z" class="st0"/>
						<circle id="l-arm-2" cx="15.7" cy="170.7" r="12.6" class="st1"/>
					</g>
				</g>
				<g id="legs">
					<g id="r-leg">
						<path id="r-leg-1" d="M116.7 248.1v52.8m0 4.7c-2.6 0-4.7-2.1-4.7-4.7v-52.8c0-2.6 2.1-4.7 4.7-4.7s4.7 2.1 4.7 4.7v52.8c0 2.6-2.1 4.7-4.7 4.7z" class="st0"/>
						<path id="r-leg-2" d="M105.9 326.3h39.9c1.7 0 3-1.3 3-3v-19.5c0-1.7-1.3-3-3-3h-39.9c-1.7 0-3 1.3-3 3v19.5c0 1.7 1.4 3 3 3z" class="st1"/>
					</g>
					<g id="l-leg">
						<path id="l-leg-1" d="M47.8 247.7v52.8m0 4.7c-2.6 0-4.7-2.1-4.7-4.7v-52.8c0-2.6 2.1-4.7 4.7-4.7s4.7 2.1 4.7 4.7v52.8c0 2.6-2.1 4.7-4.7 4.7z" class="st0"/>
						<path id="l-leg-2" d="M17.2 326h39.9c1.7 0 3-1.3 3-3v-19.5c0-1.7-1.3-3-3-3H17.2c-1.7 0-3 1.3-3 3V323c0 1.6 1.4 3 3 3z" class="st1"/>
					</g>
				</g>
				<g id="body">
					<path id="body-1" d="M137.7 258.4H28.4c-1.7 0-3-1.3-3-3V152.2c0-1.7 1.3-3 3-3h109.3c1.7 0 3 1.3 3 3v103.1c0 1.7-1.3 3.1-3 3.1z" class="st2"/>
					<path id="body-2" d="M122.8 244.6h-46c-1.7 0-3-1.3-3-3v-71c0-1.7 1.3-3 3-3h46c1.7 0 3 1.3 3 3v71c0 1.6-1.3 3-3 3z" class="st0"/>
					<circle id="t-button" cx="106.7" cy="190.1" r="7.8" class="st3"/>
					<circle id="b-button" cx="106.7" cy="223.8" r="7.4" class="st3"/>
				</g>
				<g id="whole-head">
					<g id="whole-antenna">
						<path id="antenna" d="M82.7 73.8c-1.6 0-2.9-1.3-2.9-2.9V20.4c0-1.6 1.3-2.9 2.9-2.9s2.9 1.3 2.9 2.9v50.4c.1 1.7-1.2 3-2.9 3z" class="st4"/>
						<circle id="antenna-dot" cx="82.7" cy="15.1" r="8.9" class="st1"/>
					</g>
					<path id="head" d="M153.2 142.8H12.3c-1.7 0-3-1.3-3-3V70.5c0-1.7 1.3-3 3-3h140.9c1.7 0 3 1.3 3 3v69.3c0 1.7-1.3 3-3 3z" class="st5"/>
					<circle id="r-eye" cx="120.3" cy="104.3" r="24.5" class="st3"/>
					<circle id="l-eye" cx="48.3" cy="104.4" r="31.5" class="st3"/>
				</g>
			</svg>
		</div>

		</div>
	</main>

	<?php /*
	<div id="primary" class="content-area22">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 *
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary --> */ ?>
</body>
<?php
#do_action( 'storefront_sidebar' );
//get_footer();
