<?php get_header(); ?>

		<div id="container" class="af-layout">
			<div id="content" role="main">
			
			<?php 
			// Start the main loop 
		
			$wp_query = new WP_Query();
			$wp_query->query(array(
				'showposts' => get_option('posts_per_page'),
				'post__not_in' => get_option('sticky_posts'),
				'paged' => $paged
			)); 

			/* 
			 * Run the loop to output the autofocus loop.
			 * If you want to overload this in a child theme then include a file
			 * called loop-autofocus.php and that will be used instead.
			 */
			get_template_part( 'content', 'index' );
			?>

			</div><!-- #content -->
			
		</div><!-- #container -->

<?php get_footer(); ?>