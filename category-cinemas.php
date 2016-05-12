<?php get_header(); ?>


<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
			
	<?php query_posts($query_string . '&posts_per_page=-1&orderby=name&order=ASC'); ?>

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						Index des critiques de films et séries
					</h1>
				</header>
		
	<div class="liste">	
		<?php
			rewind_posts();
			
			while ( have_posts() ) : the_post(); 
			
			
			?>
				<li id="post-<?php the_ID(); ?>" class="post">
					<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
						<header class="post-title"><?php the_title(); ?></header>
					</a>
				</li><!-- #post-## -->

			<?php endwhile; // Fin de la boucle ?>
			
			
	</ul>	
			<?php endif; ?>

<?php get_footer(); ?>
