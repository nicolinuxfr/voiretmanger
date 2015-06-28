<?php

get_header(); ?>

	<div id="container">
		<div id="content" role="main">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" class="single">
					<header class="post-header page">
						<h2 class="post-title"><?php the_title(); ?></h2>
					</header>

					<section class="post-content">
						<?php the_content(); ?>
					</section>
					
					<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
					
				</article>


<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
