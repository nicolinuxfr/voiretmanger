<?php
/**
 * Listes d'articles pour les archives (mois, jours, années…), les taxonomies, et tout le reste
 */
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<article id="post-0" class="post single error404 not-found">
		<h1 class="page-title">Oups, cette page n'existe pas</h1>
		<div class="entry-content">
			<p>Désolé, mais vous pouvez effectuer une nouvelle recherche dès maintenant !</p>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->
<?php endif; ?>


<?php // Début de la boucle
	
	while ( have_posts() ) : the_post(); ?>
		
		<?php $featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id(), "large", true); ?>

		<article id="post-<?php the_ID(); ?>" class="post">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<div class="image" style="background-image: url(<?php echo $featuredImage[0]; ?>);">
				<header><h2 class="post-title"><?php the_title(); ?></h2></header>
			</div>
		</a>
		</article><!-- #post-## -->

<?php endwhile; // Fin de la boucle ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<nav id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Plus anciens', 'autofocus' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Plus récents <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
				</nav><!-- #nav-below -->
<?php endif; ?>
