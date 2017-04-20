<?php get_header(); ?>


<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>


	<?php query_posts($query_string . '&posts_per_page=20&orderby=modified&order=DESC'); ?>

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						Liste des séries
					</h1>
				</header>

	<div class="fukol">
		<?php
			rewind_posts();
			get_template_part('liste', 'archives');
		?>
	</div>
			<?php endif; ?>

<?php get_footer(); ?>
