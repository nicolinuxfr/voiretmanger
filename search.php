<?php

/* Template Name: SearchWP Custom Search */

global $post;

$query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
$page = isset( $_GET['swppage'] ) ? absint( $_GET['swppage'] ) : 1;

the_post();
get_header(); ?>

	<div id="container" class="af-layout">
    <div id="content" class="site-content" role="main">

      <?php if( !empty( $query ) ) : ?>
        <header class="page-header">
          <h1 class="page-title">Résultats pour : <span><?php echo $query; ?></span></h1>
        </header>
 
		<?php
			rewind_posts();
			get_template_part('liste', 'archives');
		?>

 	<?php endif; ?>
      
     
    </div><!-- #content -->
  </div><!-- #primary -->

<?php

  wp_reset_postdata();

  get_footer();
 ?>