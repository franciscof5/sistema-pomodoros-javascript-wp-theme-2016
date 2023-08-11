<?php
/**
* Template Name: Metric Tracker
 */

wp_enqueue_script('jquery');

get_header(); ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script type="text/javascript">
	
	/*
	//$.get( '/wp-json/wp/v2/posts', function( data, status, request ) {
	$.get( 'https://www.cursowp.com.br/wp-json/wp/v2/posts?after=2021-01-01T00:01:00&date_query_column=modified', function( data, status, request ) {
		numPostsCursoWP = request.getResponseHeader('x-wp-total');
		$("#cw2020").text(numPostsCursoWP);
	}).done(
		$.get( 'https://source.f5sites.com/wp-json/wp/v2/posts?after=2021-01-01T00:01:00&date_query_column=modified', function( data, status, request ) {
		numPostsSource = request.getResponseHeader('x-wp-total');
		$("#sf2020").text(numPostsSource);
	})).done(
		$.get( 'https://www.f5sites.com/wp-json/wp/v2/posts?after=2021-01-01T00:01:00&date_query_column=modified', function( data, status, request ) {
		numPostsF5 = request.getResponseHeader('x-wp-total');
		$("#f52020").text(numPostsF5);
	})).done(
		$.get( 'https://portfolio.franciscomat.com/wp-json/wp/v2/posts?after=2021-01-01T00:01:00&date_query_column=modified', function( data, status, request ) {
		numPostsPort = request.getResponseHeader('x-wp-total');
		$("#pf2020").text(numPostsPort);
	})).done(
		$.get( 'https://www.franciscomat.com/wp-json/wp/v2/posts?after=2021-01-01T00:01:00&date_query_column=modified', function( data, status, request ) {
		numPostsFM = request.getResponseHeader('x-wp-total');
		$("#fm2020").text(numPostsFM);
	})).done(
		$.get( 'https://www.franciscomatelli.com.br/wp-json/wp/v2/posts?after=2021-01-01T00:01:00&date_query_column=modified', function( data, status, request ) {
		numPostsFMB = request.getResponseHeader('x-wp-total');
		$("#fmb2020").text(numPostsFMB);
	})).done(
		$.get( 'https://www.treinamentoemfoco.com.br/wp-json/wp/v2/posts?after=2021-01-01T00:01:00&date_query_column=modified', function( data, status, request ) {
		numPostsTF = request.getResponseHeader('x-wp-total');
		$("#tf2020").text(numPostsTF);

		totalTotal = Math.sum(numPostsCursoWP + numPostsSource + numPostsF5 + numPostsPort + numPostsFM + numPostsFMB + numPostsTF);

		meta2020postsDia = 1;
		meta2020postTotal = meta2020postsDia * 365;
		meta2020postAtual = meta2020postsDia*day;
		$("#tot2020").text(totalTotal);
		$("#fal2020").text(meta2020postTotal-meta2020postAtual);
	}));

$(document).ajaxStop(function () {
  // 0 === $.active
});*/
	/****************** POMO ***************/
	var now = new Date();
	var start = new Date(now.getFullYear(), 0, 0);
	var diff = now - start;
	var oneDay = 1000 * 60 * 60 * 24;
	var day = Math.floor(diff / oneDay);
	
	$.get( 'https://www.pomodoros.com.br/wp-json/wp/v2/projectimer_focus?after=2023-01-01T00:01:00&before=2023-12-31T23:59:00&date_query_column=modified', function( data, status, request ) {
		numPostsPomo2023 = request.getResponseHeader('x-wp-total');

		var meta2023dia = 8;
		var meta2023anoTotal = meta2023dia*365;
		var meta2023total = meta2023dia*365;
		var meta2023atual = meta2023dia*day;
		var meta2023feita = numPostsPomo2023/day;
		var meta2023realizadaPorCentagem = numPostsPomo2023/meta2023atual;
		var meta2023realizada = meta2023atual-numPostsPomo2023;
		//var meta2020aRealizarPorDia = (meta2020total-meta2020realizada)/(365-day);
		var meta2023aRealizarDefict = meta2023atual-numPostsPomo2023;
		var meta2023aRealizarPorDia = (meta2023aRealizarDefict/15)+meta2023dia;
		
		$("#metas-2023 .dia_do_ano_agora").text(day);
		$("#metas-2023 .pomodoros_total_no_ano").text(numPostsPomo2023 + "/" + meta2023anoTotal);
		$("#metas-2023 .media_pomodoros_por_dia_atual").text(meta2023feita + "/" + meta2023dia);
		$("#metas-2023 .porcentagem_realizada_da_meta_ate_hoje").text(meta2023realizadaPorCentagem);
		$("#metas-2023 .quanto_falta_para_atingir_a_meta").text(numPostsPomo2023 + "/" + meta2023atual + ", " + "devendo: " + meta2023aRealizarDefict);
		$("#metas-2023 .quanto_pomodoros_por_dia_para_atingir_meta_em_15_dias").text(meta2023aRealizarPorDia + ", para regularizar em dias:" + 15);
	});
	
	$.get( 'https://conteudo.franciscomatelli.com.br/wp-json/wp/v2/posts?after=2023-01-01T00:01:00&before=2023-12-31T23:59:00&date_query_column=modified', function( data, status, request ) {
		$("#metas-2023 .total_posts_escritos").text(request.getResponseHeader('x-wp-total'));
	})
	
	//2022
	$.get( 'https://www.pomodoros.com.br/wp-json/wp/v2/projectimer_focus?after=2022-01-01T00:01:00&before=2022-12-31T23:59:00&date_query_column=modified', function( data, status, request ) {
		numPostsPomo2022 = request.getResponseHeader('x-wp-total');

		var meta2022dia = 8;
		var meta2022anoTotal = meta2022dia*365;
		var meta2022total = meta2022dia*365;
		var meta2022atual = meta2022dia*day;
		var meta2022feita = numPostsPomo2022/day;
		var meta2022realizadaPorCentagem = numPostsPomo2022/meta2022atual;
		var meta2022realizada = meta2022atual-numPostsPomo2022;
		//var meta2020aRealizarPorDia = (meta2020total-meta2020realizada)/(365-day);
		var meta2022aRealizarDefict = meta2022atual-numPostsPomo2022;
		var meta2022aRealizarPorDia = (meta2022aRealizarDefict/15)+meta2022dia;
		
		$("#metas-2022 .dia_do_ano_agora").text(day);
		$("#metas-2022 .pomodoros_total_no_ano").text(numPostsPomo2022 + "/" + meta2022anoTotal);
		$("#metas-2022 .media_pomodoros_por_dia_atual").text(meta2022feita + "/" + meta2022dia);
		$("#metas-2022 .porcentagem_realizada_da_meta_ate_hoje").text(meta2022realizadaPorCentagem);
		$("#metas-2022 .quanto_falta_para_atingir_a_meta").text(numPostsPomo2022 + "/" + meta2022atual + ", " + "devendo: " + meta2022aRealizarDefict);
		$("#metas-2022 .quanto_pomodoros_por_dia_para_atingir_meta_em_15_dias").text(meta2022aRealizarPorDia + ", para regularizar em dias:" + 15);
	});
	
	$.get( 'https://conteudo.franciscomatelli.com.br/wp-json/wp/v2/posts?after=2022-01-01T00:01:00&before=2022-12-31T23:59:00&date_query_column=modified', function( data, status, request ) {
		$("#metas-2022 .total_posts_escritos").text(request.getResponseHeader('x-wp-total'));
	})
	
	//2021
	$.get( 'https://www.pomodoros.com.br/wp-json/wp/v2/projectimer_focus?after=2021-01-01T00:01:00&before=2021-12-31T23:59:00&date_query_column=modified', function( data, status, request ) {
		numPostsPomo2021 = request.getResponseHeader('x-wp-total');

		var meta2021dia = 4;
		var meta2021anoTotal = meta2021dia*365;
		var meta2021total = meta2021dia*365;
		var meta2021atual = meta2021dia*day;
		var meta2021feita = numPostsPomo2021/day;
		var meta2021realizadaPorCentagem = numPostsPomo2021/meta2021atual;
		var meta2021realizada = meta2021atual-numPostsPomo2021;
		//var meta2020aRealizarPorDia = (meta2020total-meta2020realizada)/(365-day);
		var meta2021aRealizarDefict = meta2021atual-numPostsPomo2021;
		var meta2021aRealizarPorDia = (meta2021aRealizarDefict/15)+meta2021dia;
		
		$("#metas-2021 .dia_do_ano_agora").text(day);
		$("#metas-2021 .pomodoros_total_no_ano").text(numPostsPomo2021 + "/" + meta2021anoTotal);
		$("#metas-2021 .media_pomodoros_por_dia_atual").text(meta2021feita + "/" + meta2021dia);
		$("#metas-2021 .porcentagem_realizada_da_meta_ate_hoje").text(meta2021realizadaPorCentagem);
		$("#metas-2021 .quanto_falta_para_atingir_a_meta").text(numPostsPomo2021 + "/" + meta2021atual + ", " + "devendo: " + meta2021aRealizarDefict);
		$("#metas-2021 .quanto_pomodoros_por_dia_para_atingir_meta_em_15_dias").text(meta2021aRealizarPorDia + ", para regularizar em dias:" + 15);
	});
	
	$.get( 'https://conteudo.franciscomatelli.com.br/wp-json/wp/v2/posts?after=2021-01-01T00:01:00&before=2021-12-31T23:59:00&date_query_column=modified', function( data, status, request ) {
		$("#metas-2021 .total_posts_escritos").text(request.getResponseHeader('x-wp-total'));
	})
	
	//2020
	$.get( 'https://www.pomodoros.com.br/wp-json/wp/v2/projectimer_focus?after=2020-01-01T00:01:00&before=2020-12-31T23:59:00&date_query_column=modified', function( data, status, request ) {
		numPostsPomo2020 = request.getResponseHeader('x-wp-total');
		var meta2020dia = 4;
		var meta2020total = meta2020dia*365;
		var meta2020atual = meta2020dia*day;
		var meta2020feita = numPostsPomo2020/day;
		var meta2020realizadaPorCentagem = numPostsPomo2020/meta2020atual;
		var meta2020realizada = meta2020atual-numPostsPomo2020;
		var meta2020aRealizarPorDia = (meta2020total-meta2020realizada)/365;
		

		$("#metas-2020 .pomodoros_total_no_ano").text(numPostsPomo2020);
		$("#metas-2020 .media_pomodoros_por_dia_atual").text(numPostsPomo2020/day);
		$("#metas-2020 .porcentagem_realizada_da_meta_ate_hoje").text(meta2020feita);
		$("#metas-2020 .quanto_falta_para_atingir_a_meta").text(meta2020aRealizarPorDia);
	});
	
	$.get( 'https://conteudo.franciscomatelli.com.br/wp-json/wp/v2/posts?after=2020-01-01T00:01:00&before=2020-12-31T23:59:00&date_query_column=modified', function( data, status, request ) {
		$("#metas-2020 .total_posts_escritos").text(request.getResponseHeader('x-wp-total'));
	})
	</script>

	<section id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main" role="main">
			<h1>Metas por ano</h1>
			
			<div id="metas-2023">
				<h1>Metas 2023</h1>

				<h4>Pomodoros (8/dia):</h4>
				<ul>
					<li>Dia ano: <span class="dia_do_ano_agora"></span></li>
					<li>Pomodoros ano: <span class="pomodoros_total_no_ano"></span></li>
					<li>Situação: <span class="quanto_falta_para_atingir_a_meta"></span></li>
					<li>Pomodoros/dia: <span class="media_pomodoros_por_dia_atual"></span></li>
					<li>Porcentagem da meta: <span class="porcentagem_realizada_da_meta_ate_hoje"></span></li>
					<li>Pomodoros/dia a realizar: <span class="quanto_pomodoros_por_dia_para_atingir_meta_em_15_dias"></span> (dívida + 8/dia)</li>
				</ul>
				
				<h4>Blog post (1/dia)</h4>
				<ul>
					<li>TOTAL: <span class="total_posts_escritos"></span></li>
				</ul>
			</div>
				
			<div id="metas-2022">
				<h1>Metas 2022</h1>

				<h4>Pomodoros (4/dia):</h4>
				<ul>
					<li>Dia ano: <span class="dia_do_ano_agora"></span></li>
					<li>Pomodoros ano: <span class="pomodoros_total_no_ano"></span></li>
					<li>Situação: <span class="quanto_falta_para_atingir_a_meta"></span></li>
					<li>Pomodoros/dia: <span class="media_pomodoros_por_dia_atual"></span></li>
					<li>Porcentagem da meta: <span class="porcentagem_realizada_da_meta_ate_hoje"></span></li>
					<li>Pomodoros/dia a realizar: <span class="quanto_pomodoros_por_dia_para_atingir_meta_em_15_dias"></span></li>
				</ul>
				<h4>Blog post (1/dia)</h4>
				<ul>
					<li>TOTAL: <span class="total_posts_escritos"></span></li>
				</ul>
			</div>
			
			<div id="metas-2021">
				<h1>Metas 2021</h1>

				<h4>Pomodoros (4/dia):</h4>
				<ul>
					<li>Dia ano: <span class="dia_do_ano_agora"></span></li>
					<li>Pomodoros ano: <span class="pomodoros_total_no_ano"></span></li>
					<li>Situação: <span class="quanto_falta_para_atingir_a_meta"></span></li>
					<li>Pomodoros/dia: <span class="media_pomodoros_por_dia_atual"></span></li>
					<li>Porcentagem da meta: <span class="porcentagem_realizada_da_meta_ate_hoje"></span></li>
					<li>Pomodoros/dia a realizar: <span class="quanto_pomodoros_por_dia_para_atingir_meta_em_15_dias"></span></li>
				</ul>
				
				<h4>Blog post (1/dia)</h4>
				<ul>
					<li>TOTAL: <span class="total_posts_escritos"></span></li>
				</ul>
				
				<h4>Escrever 1 livro</h4>
				<ul>
					<li>@vamoslonge - Viajando o Brasil e Uruguai de Moto na Pandemia - 5% (achei redatora)</li>
				</ul>
			</div>
			<hr />
			
			<div id="metas-2020">
				<h1>Metas 2020</h1>

				

				<h4>Pomodoros (4/dia):</h4>
				<ul>
					<li>Pomodoros ano: <span class="pomodoros_total_no_ano"></span></li>
					<li>Pomodoros/dia: <span class="media_pomodoros_por_dia_atual"></span></li>
					<li>Porcentagem da meta: <span class="porcentagem_realizada_da_meta_ate_hoje"></span></li>
					<li>Pomodoros/dia a realizar: <span class="quanto_falta_para_atingir_a_meta"></span></li>
				</ul>
				
				<h4>Blog post (1/dia)</h4>
				<ul>
					<li>TOTAL: <span class="total_posts_escritos"></span></li>
				</ul>
				
				<h4>Social</h4>
				<ul>
					<li>Instagram posts: </li>
				</ul>
			</div>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();

