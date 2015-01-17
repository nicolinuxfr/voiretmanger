<?php get_header(); ?>


<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>


		<div id="container" class="normal-layout">
			<div id="content" role="main">
			
	<?php query_posts($query_string . '&posts_per_page=50&orderby=slug&order=ASC'); ?>

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
	rewind_posts();
	get_template_part('liste', 'archives');
?>
			<?php endif; ?>


			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
