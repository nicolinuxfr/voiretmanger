<?php
/**
 * Listes d'articles pour les archives (mois, jours, années…), les taxonomies, et tout le reste
 */
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="container">
		<div id="content" role="main">

				<article id="post-0" class="single error404">
						<h1>Aucun résultat</h1>

					<section class="post-content">
						<p>Désolé, mais vous pouvez effectuer une nouvelle recherche dès maintenant !</p>
						
						<div class="recherche" id="recherche">
							<?php get_search_form( "true" ); ?>							
						</div>
					</section>
					
					
				</article>


	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>
	
	
<?php endif; ?>

<div class="fukol-grid" id="content">
<?php // Début de la boucle
	
	while ( have_posts() ) : the_post(); ?>
		
		<?php $featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id(), "large", true); ?>

		<article id="post-<?php the_ID(); ?>" class="post">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<div class="image" style="background-image: url(<?php echo $featuredImage[0]; ?>); <?php if( get_post_meta($post->ID, 'position', true) ) ?> background-position: <?php echo get_post_meta($post->ID, 'position', true); ?> ;">
				<header><h2 class="post-title"><?php the_title(); ?></h2></header>
			</div>
		</a>
		</article><!-- #post-## -->

<?php endwhile; // Fin de la boucle ?>
</div>
