<?php
/**
 * Pages d'archives
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>


<?php
	/* Queue the first post, that way we know
	 * what date we're dealing with (if that is the case).
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>
		<header>
	  		<?php print apply_filters( 'taxonomy-images-queried-term-image', '', array(
	   							'after' => '</div>',
	   							'before' => '<div id="taxo-img">',
	   							'image_size' => 'full',
	   							) );
    
	        ?>
			<h2 class="page-title">
<?php if ( is_day() ) : ?>
				<?php printf( __( 'Tous les articles du jour : <span>%s</span>', 'autofocus' ), get_the_date() ); ?>
<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Tous les articles du mois : <span>%s</span>', 'autofocus' ), get_the_date('F Y') ); ?>
<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Tous les articles de l\'ann&eacute;e : <span>%s</span>', 'autofocus' ), get_the_date('Y') ); ?>
<?php elseif ( is_category() ) : ?>
				<?php printf( __( '%s', 'autofocus' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
<?php elseif ( is_tag() ) : ?>
				<?php printf( __( '%s', 'autofocus' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
<?php else : ?>
				<?php _e( 'Archives', 'autofocus' ); ?>
<?php endif; ?>
			</h2>
		</header>


<div class="fukol">
	<?php
		rewind_posts();
		get_template_part('liste', 'archives');
	?>
</div>

<?php get_footer(); ?>
