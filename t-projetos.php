<?php
/*Template Name: Pomo - Projetos*/
?>
<?php get_header() ?>

<div class="content_nosidebar">
<div>
	<?php
	//all_posts = $wpdb->query('SELECT * FROM `wp_posts` WHERE `post_author` = '.$user_id.' GROUP BY DATE (`post_date`)');
	//$all_posts = query_posts('author=1');
	//$all_posts = $wpdb->query('SELECT `ID` FROM `wp_posts` WHERE `post_author` = '.$user_id.'');
	//echo get_current_user_id();die;
	//$all_posts = $wpdb->get_results('SELECT `ID` FROM `wp_posts` WHERE `post_author` = '.get_current_user_id().'');
	$all_posts = $wpdb->get_results('SELECT `ID`,`post_status`,`post_date`,`post_name` FROM `wp_posts` WHERE `post_author` = '.get_current_user_id().' AND `post_status` = "publish" ORDER BY `post_date` DESC');
	//var_dump($all_posts);die;
	$all_tags = array();
	$post_grouped_by_tags = array();
	foreach ($all_posts as $post) {
		$tag_do_post = wp_get_post_tags($post->ID);
		//$post[]=$tag_do_post;
		$tag_slug = $tag_do_post[0]->slug;
		//$post[]=$tag_do_post;
		//array_push($post, $tag_slug);
		//var_dump($post)." [ ] ";
		//var_dump(!in_array($term_slug, $all_tags));
		//array_push($post_grouped_by_tags, array(term_slug,))
		
		
		if(!in_array($tag_slug, $all_tags)) {
			$all_tags[]=$tag_slug;
			//$post_grouped_by_tags[$tag_slug][] => $post;
			//$post_grouped_by_tags.array_keys($tag_slug);
			//$tag_slug = array();
			//array_push($post_grouped_by_tags, $tag_slug);
		} else {
			//$post_grouped_by_tags[$term_slug] = $post;
			//array_push($post_grouped_by_tags[$term_slug], $post);
		}
		//var_dump($tags[0]->slug);
		/*
		slug
		name
		
		foreach ($tags as $value) {
			echo "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>{$tag->name}</a>";
		}*/
	} 
	var_dump($post_grouped_by_tags);die;
	?>
	<h3>Projetos (<?php echo count($all_tags)-1; ?>)</h3>
	<?php
	//var_dump($all_tags);die;
	?>
	<ul>
		<?php foreach ($all_tags as $slug) {
			echo "<li><a href=".get_bloginfo("url")."/projeto/$slug>{$slug}</a></li>";
		} ?>
	</ul>
	
	<?php
	//override query parameters
	global $query_string;
	$query = query_posts( $query_string . '&posts_per_page=5000000' );
	//var_dump(count($query));
	?>
		<?php
		$projetoNome = single_tag_title("", false);
		$projetoTotalPomodoros = count($query);
		$projetoHorasTrabalhadas = round(count($query)/2);
		//$projetoDiasTrabalhados = query_posts( $query_string . '&tag=apples' );
		//$projetoDiasTrabalhados = $wpdb->query('SELECT * FROM `wp_posts`,`wp_postmeta` WHERE `post_author` = '.get_current_user_id( ).' GROUP BY DATE (`post_date`)');
		/*$projetoDiasTrabalhados = $wpdb->query(
			'
			SELECT $wpdb->terms.term_id, $wpdb->terms.name, $wpdb->terms.slug
			FROM $wpdb->terms
		    	INNER JOIN $wpdb->term_taxonomy ON ($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
		    	INNER JOIN $wpdb->term_relationships ON ($wpdb->terms.term_id = $wpdb->term_relationships.term_taxonomy_id)
		    	INNER JOIN $wpdb->posts ON ($wpdb->term_relationships.object_id = $wpdb->posts.ID)
			WHERE $wpdb->term_taxonomy.taxonomy = "f5sites"
			ORDER BY $wpdb->posts.post_date DESC
			'
		);
		
		$query_by_authors = array();
		$query_by_post_title = array();
		$query_by_post_date = array();

		foreach($query as $entity)
		{
			if(!isset($query_by_authors[$entity->post_author]))
			{
				$query_by_authors[$entity->post_author] = array();
			}

			$query_by_authors[$entity->post_author][] = $entity;
		}
		//var_dump($query);die;
		foreach($query as $entity)
		{
			if(!isset($query_by_post_title[$entity->post_title]))
			{
				$query_by_post_title[$entity->post_title] = array();
			}

			$query_by_post_title[$entity->post_title][] = $entity;
		}
		foreach($query as $entity)
		{
			$dataAglutinadora = substr($entity->post_date,0,10); //data que vai reunir posts
			if(!isset($query_by_post_date[$dataAglutinadora]))
			{
				$query_by_post_date[$dataAglutinadora] = array();
			}
			$query_by_post_date[$dataAglutinadora][] = $entity;
		}
		$projetoColaboradores = count($query_by_authors);
		$projetoInicio  = $query[count($query)-1]->post_date;
		$projetoFinal = $query[0]->post_date;
		$projetoDuracao = ceil((strtotime($projetoFinal) - strtotime($projetoInicio))/60/60/24);
		
		$projetoDiasTrabalhados = count($query_by_post_date);

	
	//var_dump($all_tags);
	//die;

	/*$html = '<div class="post_tags">';
	foreach ( $tags as $tag ) {
		$tag_link = get_tag_link( $tag->term_id );
				
		$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
		$html .= "{$tag->name}</a>";
	}
	$html .= '</div>';*/
	?>
</div>
</div><!-- #content -->
	
<?php get_footer() ?>