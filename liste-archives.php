<?php
/**
 * Listes d'articles pour les archives (mois, jours, années…), les taxonomies, et tout le reste
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span>', 'autofocus' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
	</nav><!-- #nav-above -->
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<article id="post-0" class="post single error404 not-found">
		<h1 class="page-title">Oups, cette page n'existe pas</h1>
		<div class="entry-content">
			<p>Désolé, mais vous pouvez effectuer une nouvelle recherche dès maintenant !</p>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->
<?php endif; ?>

<?php /* Start the Loop. */ ?>

<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			</header>
				
		<div class="entry-image">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( "archive-thumbnail" );?></a>
		</div>
		
		<div class="entry-image-small">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( "archive-thumbnail" );?></a>
		</div>
			

		</article><!-- #post-## -->

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<nav id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Plus anciens', 'autofocus' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Plus récents <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
				</nav><!-- #nav-below -->
<?php endif; ?>
