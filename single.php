<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" class="single">
			
		<?php $featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id(), "full", true); ?>		
		
		<header class="post-header" style="background-image: url(<?php echo $featuredImage[0]; ?>); <?php if( get_post_meta($post->ID, 'position', true) ) ?> background-position: <?php echo get_post_meta($post->ID, 'position', true); ?> ;">
		<div class="flou">
			<h2 class="post-title"><?php the_title(); ?></h2>
		</div>
		</header>

		<section class="post-content">
			<?php the_content(); ?>
		</section>

			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>
					
		<footer class="post-footer">
			<?php get_sidebar(); ?>
		</footer>
		
		<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
		
	</article>

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
