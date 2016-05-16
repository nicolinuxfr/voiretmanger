<?php
/**
 * Index du blog
 */
?>


<?php // Début de la boucle
	
	while ($wp_query->have_posts()) : $wp_query->the_post(); 
		
		 if( $wp_query->current_post == 0 ) :
			 $size = "full";
			 else :
			 $size = "large";
		 endif;
		
		$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id(), $size, true);
		?>

		<article id="post-<?php the_ID(); ?>" class="post">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<div class="image" style="background-image: url(<?php echo $featuredImage[0]; ?>); <?php if( get_post_meta($post->ID, 'position', true) ) ?> background-position: <?php echo get_post_meta($post->ID, 'position', true); ?> ;">
				<header><h2 class="post-title"><?php the_title(); ?></h2></header>
			</div>
		</a>
		</article><!-- #post-## -->

<?php endwhile; // Fin de la boucle ?>

<nav id="nav-below" class="navigation">
	<?php if ( !is_paged() ) { ?>
		<div class="nav-home"><a href="https://voiretmanger.fr/page/2/">Les articles suivants</a></div>
	<?php }
	
	else { ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Avant', 'autofocus' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Après <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
	<?php } ?>
</nav><!-- #nav-below -->