<?php

get_header(); ?>

		<div id="container" class="<?php af_layout_class(); ?>">
			<div id="content" role="main">
			
			<?php 
			// Start the main loop 
		    global $paged, $more, $shortname;
			$more = 0;
		    
			$af_blog_category = of_get_option( $shortname . '_blog_cat' );
		
			$temp = $wp_query;
			$wp_query = null;
			$wp_query = new WP_Query();
			$wp_query->query(array(
				'showposts' => get_option('posts_per_page'),
				'category__not_in' => array( $af_blog_category ),
				'post__not_in' => get_option('sticky_posts'),
				'paged' => $paged
			)); 

			/* 
			 * Run the loop to output the autofocus loop.
			 * If you want to overload this in a child theme then include a file
			 * called loop-autofocus.php and that will be used instead.
			 */
			get_template_part( 'content', 'autofocus' );
			?>

			</div><!-- #content -->
			
			<?php
			$sticky = get_option( 'sticky_posts' );
			$args = array(
			'posts_per_page' => 1,
			'post__in'  => $sticky,
			'ignore_sticky_posts' => 1
			);
			query_posts( $args );

			if ( $sticky[0] ) {
				// insert here your stuff...
				echo('oo')
				}
			
			?>
			
		</div><!-- #container -->

<?php get_footer(); ?>