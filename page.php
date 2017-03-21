<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
	<article id="post-<?php the_ID(); ?>" class="single">
		<header class="post-header page">
			<h2 class="page-title"><?php the_title(); ?></h2>
		</header>
		
		<section class="post-content">
			<?php the_content(); ?>
		</section>					
	</article>

<?php endwhile; ?>

<?php get_footer(); ?>
