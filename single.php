<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" class="single">
			
		<?php // Image mise en avant
		
			$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id(), "full", true); 
			
			if (get_field( "image_focal" )) {
				$focal_point = get_field( "image_focal" );
				$position = "style=\"object-position:" . ($focal_point['focal_point']['left'] * 100) . "% " . ($focal_point['focal_point']['top'] * 100) . "%\"";
			} elseif (get_post_meta($post->ID, 'position', true)) {
				$position = "style=\"object-position:" . get_post_meta($post->ID, 'position', true) . "\"";
			} else {
				$position = false;
			}

		?>		
		
		<header class="post-header">
			<img src="<?php echo $featuredImage[0]; ?>" <?php if( $position ) { echo $position; } ?>> 
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
	</article>

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
