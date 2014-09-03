<?php
/**
 * Template Name: AF+ Blog Template
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage AutoFocus_Two 
 * @since AutoFocus 2.0
 */

get_header(); ?>

<?php 
	// Start the loop for the Blog Category
    global $paged, $more, $shortname;
	$more = 0;
    
	$af_blog_catid = of_get_option( $shortname . '_blog_cat' );

	$temp = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query();
	$wp_query->query(array(
		'showposts' => get_option('posts_per_page'),
		'category__in' => array( $af_blog_catid ),
		'paged' => $paged
		)); ?>

		<div id="container" class="af-blog-template">
			<div id="content" role="main">

			<h1 class="page-title"><a href="<?php print get_category_feed_link($af_blog_catid, '') ?>" title="<?php _e('Blog Posts RSS feed', 'thematic'); ?>"><?php _e('Subscribe', 'thematic') ?></a><span><?php the_title(); ?></span></h1>

			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
					<nav id="nav-above" class="navigation">
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span>', 'autofocus' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
					</nav><!-- #nav-above -->
			<?php endif; ?>
			
				<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
			
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header>
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<?php af_posted_on(); ?>
						</header>
			
						<div class="entry-content">
							<?php the_content( __( 'Lire la suite <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>
						</div><!-- .entry-content -->
			
						<footer class="entry-utility">
							<?php af_post_meta(); ?>

							<?php comments_popup_link( '<span class="comments-link">' . __( 'Leave a comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '1 Comment', 'autofocus' ) . '</span>', '<span class="comments-link">' . __( '% Comments', 'autofocus' ) . '</span>', '', '' ); ?>

							<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-utility -->
					</article><!-- #post-## -->
			
			<?php endwhile; // end of the loop. ?>
			
			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if (  $wp_query->max_num_pages > 1 ) : ?>
					<nav id="nav-below" class="navigation">
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'autofocus' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
					</nav><!-- #nav-below -->
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #container -->

	<?php $wp_query = null; $wp_query = $temp; ?>

<?php get_footer(); ?>
