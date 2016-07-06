<?php get_header(); ?>
	<?php 
	// Loop de la page d'accueil
	$args = array (
		'ignore_sticky_posts'    => false,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'paged' => $paged
	);

	$wp_query = new WP_Query( $args );

	get_template_part( 'content', 'index' );
	
	?>
<?php get_footer(); ?>