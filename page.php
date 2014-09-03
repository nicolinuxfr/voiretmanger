<?php

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					<div class="header">
					
					<div class="entry-image">
					<?php echo the_post_thumbnail('full'); ?>
					</div>

					
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</div>

					<div class="entry-content">

						<?php the_content(); ?>
						
						
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-## -->


<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
