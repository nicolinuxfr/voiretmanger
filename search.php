<?php

/* Template Name: SearchWP Custom Search */

global $post;

$query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
$page = isset( $_GET['swppage'] ) ? absint( $_GET['swppage'] ) : 1;

the_post();
get_header(); ?>

  <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

      <?php if( !empty( $query ) ) : ?>
        <header class="page-header">
          <h1 class="page-title">Résultats pour : <span><?php echo $query; ?></span></h1>
        </header>
      <?php endif; ?>

      
      <?php if( !empty( $query ) ) : ?>

        <?php
          $engine = SearchWP::instance();             // instatiate SearchWP
          $supplementalEngineName = 'complete'; 	// search engine name
         // add_filter( 'searchwp_tax_term_or_logic', '__return_true' ); // Enlever le commentaire pour recherche partielle

          // perform the search
          $posts = $engine->search( $supplementalEngineName, $query, $page );
        ?>

        <?php if( !empty( $posts ) ) : ?>
          <?php foreach( $posts as $post ) : ?>
            <?php if( $post instanceof SearchWPTermResult ) : ?>
              <article>
              <div class="gauche">

    
    <?php
    echo $post->taxonomy;
$terms = apply_filters( 'taxonomy-images-get-terms', '', array(
'taxonomy' => $post->taxonomy,
'term_args' => array(
	'slug' => $post->term->slug,
	)
	) );
foreach( (array) $terms as $term) {
echo wp_get_attachment_image( $term->image_id, '' );
}?>

		
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( "archive-thumbnail" ); ?></a>
		
		</div>
                  <div class="article">

                <header class="entry-header"
                		<div class="entry-content">	

                  <h2 class="entry-title">
                    <a href="<?php echo $post->link; ?>" rel="bookmark"><?php echo $post->name; ?></a>
                  </h2>
                		</div>
                </header><!-- .entry-header -->
                </div>
                    </article>
            <?php else : setup_postdata( $post ); ?>
         
              
              <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="article">
	<div class="gauche">
		
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( "archive-thumbnail" ); ?></a>
		
		</div>
		<div class="centre">

		<div class="entry-content">	
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			
				<?php the_excerpt(); ?>
					<?php edit_post_link( __( 'Modifier', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>

			</div><!-- .entry-content -->
			</div>
		
        </div>
	</article><!-- #post-## -->



            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>

      <?php endif; ?>

    </div><!-- #content -->
  </div><!-- #primary -->

<?php

  wp_reset_postdata();

  get_footer();
 ?>