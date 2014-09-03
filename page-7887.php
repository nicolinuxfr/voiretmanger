<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header>
						<?php if ( is_front_page() ) { ?>
							<h2 class="entry-title"><?php the_title(); ?></h2>
						<?php } else { ?>
							<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php } ?>
					</header>

					<div class="entry-content">
					
					<!-- #sorties de la semaine -->		

<?php
			$sticky = get_option( 'sticky_posts' );
			rsort( $sticky );
			$sticky = array_slice( $sticky, 0, 5 );
			$argsticky = array( 'post__in' => $sticky, 'caller_get_posts' => 1  );

			if ( $sticky ) { ?>

	 <div class="sorties">
      <div class="titre">Sorties de la semaine</div>
	
	 <ul>
		<?php
			query_posts( $argsticky );
			
			if (have_posts() ) { while ( have_posts() ) : the_post(); ?>
       
			<li class="sortie"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('archive-thumbnail'); ?></a></li>
     	
	 <?php endwhile;
     } 
     }
     ?>
     </ul>
		 </div>		

					
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-utility">
						<?php get_sidebar(); ?>
					</footer>

				</article><!-- #post-## -->

<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
