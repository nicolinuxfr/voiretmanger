<?php
/**
 * The loop that displays images in the AutoFocus format.
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span>', 'autofocus' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
	</nav><!-- #nav-above -->
<?php endif; ?>

	<?php 
	
	$i = 1;
	
	while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			</header>

			<?php 	
				$thumbs_perso = array('1' => 'home-1',
								'2' => 'home-2',
								'3' => 'home-3',
								'4' => 'home-3',
								'5' => 'home-2',
								'6' => 'home-4',
								'7' => 'home-4',
								'8' => 'home-4',
								'9' => 'home-2',
								'10' => 'home-3');			
			?>
				
				
		<div class="entry-image">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( $thumbs_perso[$i] );?></a>
		</div>
			

		</article><!-- #post-## -->

	<?php 
	$i++;

	endwhile; // end of the loop. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<nav id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Plus anciens', 'autofocus' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Plus r&eacute;cents <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
				</nav><!-- #nav-below -->
<?php endif; ?>