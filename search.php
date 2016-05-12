<?php

/* Modèle pour les résultats de recherche */

global $post;

$query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
$page = isset( $_GET['swppage'] ) ? absint( $_GET['swppage'] ) : 1;

the_post();
get_header(); ?>

      <?php if( !empty( $query ) ) : ?>
        <header class="page-header">
          <h1 class="page-title">Résultats pour : <span><?php echo $query; ?></span></h1>
        </header>
 
	   <div class="liste">
		<?php
			rewind_posts();
			get_template_part('liste', 'archives');
		?>

 	   </div>

 	<?php endif; ?>
      
<?php

  wp_reset_postdata();

  get_footer();
 ?>