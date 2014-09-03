<?php get_header(); ?>


<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>


		<div id="container" class="<?php af_layout_class(); ?>">
			<div id="content" role="main">
			
	<?php query_posts($query_string . '&posts_per_page=-1&orderby=annee&order=ASC'); ?>

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
				<?php print apply_filters( 'taxonomy-images-queried-term-image', '', array(
							'after' => '</div>',
							'before' => '<div id="taxo-img">',
							'image_size' => 'full',
							) );
    
     ?>
					<h1 class="page-title">
					<?php printf('<span>' . $term->name . '</span>' ); ?>
					</h1>

					<?php
						$category_description = category_description();
						if ( ! empty( $category_description ) )
							echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
					?>
				</header>
				
			<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	$archive_layout = of_get_option($shortname . '_archive_layout');

	/* Run the loop for the archives page to output the posts. */
	if ($archive_layout == 'images')
		get_template_part( 'content', 'archives' );

	else 
		get_template_part( 'content', 'archives' );

?>
			<?php endif; ?>


			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
