<?php
/*
* template name: futmin
*/
?>

<html>
<head>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://kit.fontawesome.com/a2397d07cb.js" crossorigin="anonymous"></script>
	<script src="<?php echo get_stylesheet_directory_uri()?>/assets/artyom.window.min.js"></script>
	<script src="<?php echo get_stylesheet_directory_uri()?>/assets/bootstrap.bundle.min.js"></script>
	<link href="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/assets/bootstrap.min.css" rel="stylesheet">

	<script type="text/javascript">
		jQuery( document ).ready(function($) {
			ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ) ?>";
			var data = {
				action: 'update_session',
				userchallenging: "Fabio de Arake",
			}
			function load_initial_data() {
				$.post(ajaxurl, data, function(responde_returned) {
					response = jQuery.parseJSON(responde_returned.slice( 0, -1 ));
					if(response.challenger) {
						console.log("You were challenged");
						if($("#acceptingChallenge").prop("checked"))
							displayChallenge(response.challenger);
					}
					console.log("response", response.test);
				});
			}
			function displayChallenge(player) {
				if($(".challenge").css("display")=="none") {
					$(".challenge").css("display", "block");
					$(".challenger").text(player);
					chalengeCountdown();
				}
			}
			function rejectChallenge() {
				$("#challenge").hide();
				clearInterval(listen_challenge);
			}

			function chalengeCountdown() {
				miliseconds=10000;
				listen_challenge = setInterval(function() {
					$(".challenteTime").text(miliseconds/10);
					if(miliseconds<=0) {
						rejectChallenge();
					}
					miliseconds-=100;
				}, 100)
			}

			function startGame() {
				$("#challenge-screen").hide();
				$("#logo").hide();
				$("#ingame-screen").show();
				half_height = $(window).height()/2;
				gols_levados=0;
				gols_feitos=0;
				gameTimeSeconds=60000;
				listen_game = setInterval(function() {
					actual_height = $("#teamPosition").height();
					random = (((Math.random()*10)-5)*(half_height/40));
					new_height = actual_height + random;

					if(actual_height<=40) {
						//DEFENDEU https://fontawesome.com/icons/fist-raised?style=solid
						$(".gol-modal").show();
						setTimeout(function() {
							$(".gol-modal").hide();
						}, 2000);
						//
						gols_feitos++;
						new_height = half_height;
					} else if(actual_height>=((half_height*2)-40)) {
						$(".gol-modal").show();
						setTimeout(function() {
							$(".gol-modal").hide();
						}, 2000);
						//
						gols_levados++;
						new_height = half_height;
					}
					$("#teamPosition").height(new_height);
					$("#gols_feitos").text(gols_feitos);
					$("#gols_levados").text(gols_levados);
					$("#gameTimeSeconds").text(gameTimeSeconds);

					if(gameTimeSeconds<=0) {
						endGame();
					}
					//
					gameTimeSeconds-=100;
				}, 100)
			}

			function endGame() {
				$("#challenge-screen").show();
				$("#logo").show();
				$("#ingame-screen").hide();
				clearInterval(listen_game);
			}
			$("#rejectChallenge_btn").click(function() {rejectChallenge()});
			$("#makeChallenge button").click(function() {
				startGame();
			});
			
			listen_changes = setInterval(function() {
				load_initial_data();
			},5000);

			$("#ingame-screen").hide();
			$("#credits").hide();
			$(".challenge-modal").hide();
			$(".gol-modal").hide();
		});
	</script>

	<style type="text/css">		
		html, body {
			height: 100%;
			margin: 0;
		}
		@font-face {
		    font-family: 'lobster';
		    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/lobster/lobster_1.3-webfont.eot');
		    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/lobster/lobster_1.3-webfont.eot?#iefix') format('embedded-opentype'),
		         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/lobster/lobster_1.3-webfont.woff2') format('woff2'),
		         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/lobster/lobster_1.3-webfont.woff') format('woff'),
		         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/lobster/lobster_1.3-webfont.ttf') format('truetype'),
		         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/lobster/lobster_1.3-webfont.svg#lobster_1.3regular') format('svg');
		    font-weight: normal;
		    font-style: normal;
		}	
	</style>
	<title>Futnow - F5 Sites</title>
</head>
<body class="grass">
	<h1 id="logo" class="hglow"><i class="fas fa-futbol"></i> Futnow</h1>
	<div id="challenge-screen" class="col-md-6 offset-md-3 col-sm-12 square-round bg-white">
		<?php 
		global $current_user; wp_get_current_user();
		if(!is_user_logged_in()) {
			wp_login_form();
		} else { ?>
			<h3>Profile</h3>
			<img src="https://dummyimage.com/100x100/007bff/fff&text=<?php echo $current_user->user_login; ?>" class="rounded-circle">
			<hr>
			
			<h3>Challenges</h3>
			<div id="makeChallenge">
				<button id="cpu" class="btn btn-link">
					<img src="https://dummyimage.com/100x100/000/fff&text=cpu" class="rounded-circle">
				</button>
			</div>

			<!--label for="acceptingCheck">Accepting Challenges</label-->
			<div class="card" style="margin:50px 0">
				<ul class="list-group list-group-flush">
					<li class="list-group-item">
						Accepting Challenges
						<label class="switch ">
						<input type="checkbox" class="default" id="acceptingChallenge">
						<span class="slider round"></span>
						</label>
					</li>
				</ul>
			</div>
			
		<?php } ?>
	</div>
	
	<div class="modal challenge-modal">
		<h2 class="hglow">Challenge</h2>
		<div class="col-md-6 offset-md-3 col-sm-12 square-round bg-warning">
			<span class="badge badge-secondary challenteTime">10</span>
			<p class="challenger">Firuouraori</p>
			<button type="button" class="btn btn-danger btn-lg" id="rejectChallenge_btn">
				<i class="fas fa-window-close"></i>
			</button>
			<button type="button" class="btn btn-success btn-lg">
				<i class="fas fa-check-square"></i>
			</button>
		</div>
	</div>

	<div class="gol-modal">
		<h1 class="hglow">GOOOOOL</h1>
	</div>

	<div id="ingame-screen">
		<div id="score">
			<button type="button" class="btn btn-primary">
			  <?php echo $current_user->user_login?> <span class="badge badge-light" id="gols_levados">0</span>
			</button>
			<button type="button" class="btn btn-secondary">
			  <span class="badge badge-light" id="gols_feitos">0</span> CPU
			</button>
			 <span class="badge badge-secondary" id="gameTimeSeconds">60</span>
		</div>

		<div id="teamPosition">
			<i class="fas fa-futbol"></i>
		</div>
	</div>
	<div id="credits">
		Grass CSS https://codepen.io/JoeHastings/pen/wqXdER
		Bootstrap V4 Simple Checkbox Switch - No Js https://bootsnipp.com/snippets/GaxR2
	</div>

<style type="text/css">
	h1, h2, h3, h4, h5 {
		font-family: 'lobster', Arial, Helvetica, sans-serif !important;
		text-align:center;
	}
	.hglow {
		text-shadow: 0 0 5px #FFF, 0 0 10px #FFF, 0 0 15px #FFF, 0 0 20px #49ff18, 0 0 30px #49FF18, 0 0 40px #49FF18, 0 0 55px #49FF18, 0 0 75px #49ff18, 2px 2px 1px rgba(99,92,206,0);
	}
	.square-round {
		text-align: center;
		border-radius: 20px;
		padding: 30px;
		z-index: 99;
	}
	.bg-white {
		background: #FFF;
	}
	.modal {
		padding: 50px;
		position: absolute;
		width: 100%;
		top: 0;
		background: rgba(0,0,0,0.8);
		height: 100%;
	}
	.gol-modal {
		position: absolute;
		top: 48%;
		width: 100%;
		z-index: 999;
	}
	.gol-modal h1 {
		font-size: 50px;
		color: #FFF;
		text-align: center;
	}
	#teamPosition {
		position: absolute;
		width: 100%;
		height: 50%;
		bottom: 0;
		background: #09d;
	}
	#teamPosition .fa-futbol {
		position: absolute;
		left: 50%;
		transform: translate(-50%, -50%);
		color: #FFF;
		font-size: 30px;
		top: 0;
	}
	#score {
		z-index: 99;
	}
	/****************************************************/
	/* The switch - the box around the slider */
	.switch {
	  position: relative;
	  display: inline-block;
	  width: 60px;
	  height: 34px;
	  float:right;
	}

	/* Hide default HTML checkbox */
	.switch input {display:none;}

	/* The slider */
	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #ccc;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	.slider:before {
	  position: absolute;
	  content: "";
	  height: 26px;
	  width: 26px;
	  left: 4px;
	  bottom: 4px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	input.default:checked + .slider {
	  background-color: #444;
	}
	input.primary:checked + .slider {
	  background-color: #2196F3;
	}
	input.success:checked + .slider {
	  background-color: #8bc34a;
	}
	input.info:checked + .slider {
	  background-color: #3de0f5;
	}
	input.warning:checked + .slider {
	  background-color: #FFC107;
	}
	input.danger:checked + .slider {
	  background-color: #f44336;
	}

	input:focus + .slider {
	  box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
	  -webkit-transform: translateX(26px);
	  -ms-transform: translateX(26px);
	  transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
	  border-radius: 34px;
	}

	.slider.round:before {
	  border-radius: 50%;
	}
	/****************************************************/
	.grass2 {
	  width: 100%;
	  height: 100%;
	  background-color: #358626;
	}

	.grass {
	  width: 100%;
	  height: 100%;
	  background-color: #358626;
	}
	.grass:before {
	  content: "";
	  /*position: absolute;*/
	  position: fixed;
	  top: 0;
	  bottom: 0;
	  left: 0;
	  right: 0;
	  z-index: 2;
	  background-image: url('data:image/png;base64, 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');
	}
	.grass:after {
	  content: "";
	  position: fixed;
	  top: 0;
	  bottom: 0;
	  left: 0;
	  right: 0;
	  z-index: 1;
	  background: repeating-linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1) 9.09%, transparent 9.09%, transparent 18.18%);
	}
</style>

</body>
</html>