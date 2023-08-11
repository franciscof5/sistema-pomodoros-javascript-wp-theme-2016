<?php

/**
 * Template Name: Rankings
 */

get_header(); ?>
<style type="text/css">
	/*ul {
		list-style: decimal !important;
	}*/
#content a {
	font-family: 'nexa_boldregular' !important;
	font-size: 20px;
}
#content ul {
	    counter-reset:li; /* Initiate a counter */
	    margin-left:28px; /* Remove the default left margin */
	    padding-left:0; /* Remove the default left padding */
	}
#content	ul > li {
	    position:relative; /* Create a positioning context */
	    margin:0 0 16px 2em; /* Give each list item a left margin to make room for the numbers */
	    padding:4px 8px; /* Add some spacing around the content */
	    list-style:none; /* Disable the normal item numbering */
	    border-top:2px solid #666;
	    background:#f6f6f6;
	}
#content	ul > li:before {
	    content:counter(li); /* Use the counter as content */
	    counter-increment:li; /* Increment the counter by 1 */
	    /* Position and style the number */
	    position:absolute;
	    top:-2px;
	    left:-2em;
	    -moz-box-sizing:border-box;
	    -webkit-box-sizing:border-box;
	    box-sizing:border-box;
	    width:2em;
	    /* Some space between the number and the content in browsers that support
	       generated content but not positioning it (Camino 2 is one example) */
	    margin-right:8px;
	    padding:10px;
	    border-top:2px solid #666;
	    color:#fff;
	    background:#000;
	    font-weight:bold;
	    font-size:30px;
	    font-family:'nexa_boldregular', "Helvetica Neue", Arial, sans-serif;
	    text-align:center;
	}
#content	li ol,
#content	li ul {margin-top:6px;}
#content	ol ol li:last-child {margin-bottom:0;}
/*#content	ol ol li:first-child:before {background-color: "#0F0"}*/
}
/*gambiarras*/
#content ul br {
	display: none !important;
	height: 0;
}
</style>

<script type="text/javascript">
	jQuery('document').ready(function ($) {
		$("#content ul").each(function(i){
			$(this).find("br").remove();
			//selecion o primeiro item da lista pra deixar dourado sei la
			//$(this).find("li:first").css("background-color", "#330");			
		});
	});
</script>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
	
		<div id="content" class="site-content" role="main">
		<h1>Ranking de locais Itapemapa</h1>
		<p>Os clientes e visitantes adoram elogiar bons serviços e também sabem criticar quando se sentem desrespeitados. Descubra os locais mais bem avaliados e os que estão buscando melhorar.</p>
		
		<h3>Melhores locais de hoje</h3>
		<p>Melhores locais avaliados nas últimas 24h</p>
		<?php if (function_exists('get_most_rated_range')): ?>
		    <ul>
		        <?php get_highest_rated_range('1 day','bgmp',5); ?>
		    </ul>
		<?php endif; ?>	

		<h3>Melhores locais desta semana</h3>
		<p>Aqui são os melhores locais avaliados durante esta semana</p>
		<?php if (function_exists('get_most_rated_range')): ?>
		    <ul>
		        <?php get_highest_rated_range('1 week','bgmp',5); ?>
		    </ul>
		<?php endif; ?>
		
		<h3>Melhores locais de todos os tempos</h3>
		<p>As melhores empresas avaliadas desde o início da contagem</p>
		<?php if (function_exists('get_highest_rated')): ?>
		    <ul>
		        <?php get_highest_rated('bgmp',0,5); ?>
		    </ul>
		<?php endif; ?>
		

		<?php
			/*query_posts( array( 
			//
			'post_type' => 'bgmp',
			'meta_key' => 'ratings_average', 
			'orderby' => 'meta_value_num', 
			'order' => 'ASC' ) );
			
			// The Loop
			while ( have_posts() ) : the_post();
				$mylimit=7 * 86400; //days * seconds per day
				$post_age = date('U') - get_post_time('U');
				if ($post_age < $mylimit) {
				    echo '<li>';
				    the_title();
				    echo '</li>';
				}
			endwhile;

			// Reset Query
			wp_reset_query();

			$limit=10;
			$min_time=10000000;
			$category_sql="";
			global $wpdb;
			//$lowest_score = $wpdb->get_results("SELECT COUNT($wpdb->ratings.rating_postid) AS ratings_users, SUM($wpdb->ratings.rating_rating) AS ratings_score, ROUND(((SUM($wpdb->ratings.rating_rating)/COUNT($wpdb->ratings.rating_postid))), 2) AS ratings_average, $wpdb->posts.* FROM $wpdb->posts LEFT JOIN $wpdb->ratings ON $wpdb->ratings.rating_postid = $wpdb->posts.ID INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) WHERE rating_timestamp >= $min_time AND $wpdb->posts.post_password = '' AND $wpdb->posts.post_date < '".current_time('mysql')."'  AND $wpdb->posts.post_status = 'publish' AND $wpdb->term_taxonomy.taxonomy = 'category' AND $category_sql AND $where GROUP BY $wpdb->ratings.rating_postid ORDER BY ratings_score ASC, ratings_average ASC LIMIT $limit");
			var_dump($lowest_score = $wpdb->get_results("SELECT COUNT($wpdb->ratings.rating_postid) AS ratings_users, SUM($wpdb->ratings.rating_rating) AS ratings_score, ROUND(((SUM($wpdb->ratings.rating_rating)/COUNT($wpdb->ratings.rating_postid))), 2) AS ratings_average, $wpdb->posts.* FROM $wpdb->posts LEFT JOIN $wpdb->ratings ON $wpdb->ratings.rating_postid = $wpdb->posts.ID INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) WHERE rating_timestamp >= $min_time AND $wpdb->posts.post_password = '' AND $wpdb->posts.post_date < '".current_time('mysql')."'  AND $wpdb->posts.post_status = 'publish' AND $where GROUP BY $wpdb->ratings.rating_postid ORDER BY ratings_score ASC, ratings_average ASC LIMIT $limit"));
			
			//
			foreach ($lowest_score as $post) {
				var_dump($post);
			}
			echo "DALSKJDLAKSJDLAKSJDASd";*/
		?>
		<h3>Ranking por categoria</h3>
		<p>Conheça os 3 melhores locais por categoria</p>
		<h3>Alimentação</h3>
		<?php if (function_exists('get_lowest_rated_tag')): ?>
		    <ul>
		        <?php get_highest_score_category(23, "bgmp", 0, 3); ?>
		        
		    </ul>
		<?php endif; ?>
		<h3>Beleza</h3>
		<?php if (function_exists('get_lowest_rated_tag')): ?>
		    <ul>
		        <?php get_highest_score_category(19, "bgmp", 0, 3); ?>
		        
		    </ul>
		<?php endif; ?>
		
		<h3>Casa</h3>
		<?php if (function_exists('get_lowest_rated_tag')): ?>
		    <ul>
		        <?php get_highest_score_category(81, "bgmp", 0, 3); ?>
		        
		    </ul>
		<?php endif; ?>
		
		<h3>Comércio</h3>
		<?php if (function_exists('get_lowest_rated_tag')): ?>
		    <ul>
		        <?php get_highest_score_category(190, "bgmp", 0, 3); ?>
		        
		    </ul>
		<?php endif; ?>
		
		<!--h3>Rede</h3-->
		<?php /*if (function_exists('get_lowest_rated_tag')): ?>
		    <ul>
		        <?php get_highest_score_category(176, "bgmp", 0, 3); ?>
		        
		    </ul>
		<?php endif;*/ ?>
		
		<h3>Serviços</h3>
		<?php if (function_exists('get_lowest_rated_tag')): ?>
		    <ul>
		        <?php get_highest_score_category(189, "bgmp", 0, 3); ?>
		        
		    </ul>
		<?php endif; ?>

		<?php //get_lowest_rated_tag(23, "bgmp", 0, 10); ?>
		        <?php //get_lowest_rated_category(23, "both", 0, 10); ?>
		        <?php //get_lowest_rated_tag(23, "both", 0, 10); ?>
		<h3>Buscando a recuperação</h3>
		<p>Os locais que foram mal-avaliados pelos clientes, desde o início da contagem</p>
		<!--h3>Lanterninhas do ranking</h3>
		<p>Os locais com avaliação mais baixa, desde o início da contagem</p-->
		<?php if (function_exists('get_lowest_rated')): ?>
		    <ul>
		        <?php get_lowest_rated('bgmp', 0, 5); ?>
		    </ul>
		<?php endif; ?>
		<p>Aviso: o primeiro critério para ordenar as listas é a pontuação dados pelos consumidores, no caso de empate utiliza-se a ordem alfabética, o que pode excluir empresas com a mesma pontuação do ranking.</p>
		<p>Aviso: o ranking é reiniciado no 1o dia de cada ano, sendo arquivado o histórico anterior.</p>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php if ( is_user_logged_in() ) { ?> 
	<?php //get_sidebar(); ?>
<?php } ?>


<?php
get_footer();
