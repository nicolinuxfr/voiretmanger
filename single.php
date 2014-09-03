<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					
					<div class="header">
					
					<div class="entry-image">
					<div><?php echo the_post_thumbnail('full'); ?></div>
					</div>

					
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</div>

					<div class="entry-content">

						<?php the_content(); ?>
						

					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>
					
					<footer class="entry-utility">
						
						<?php get_sidebar(); ?>
					</footer><!-- .entry-utility -->
					
					</div><!-- .entry-content -->

				</article><!-- #post-## -->

					
				<?php
				
					// Only show the Comments Form if the post has comments open
					if ( comments_open() || get_comments_number() != '0' ) {
						comments_template( '', true ); 
					}
				?>

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
