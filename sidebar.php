<?php
/**
 * The Sidebar containing the Singlular Sidebar widget areas.
 */
?>


<!-- Fonctions de partage -->	
	<?php
		$lien = get_permalink();
		$titre = strip_tags(get_the_title());
		$facebook_link  = 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $lien ;
		$twitter_link  = 'http://twitter.com/share?url=' . $lien . '&text=' . $titre ;
		$mail_link = 'mailto:?subject=' . $titre . '&amp;body=' . $titre . ' - '. $lien ;
	?>
	
<div class="partage">	
	<div class="titre">Partager</div> 			
			<ul>
				<a title="Envoyer cet article par mail" href="<?php echo $mail_link; ?>"><li>Mail</li></a>
				<a title="Partager cet article sur Twitter" href="<?php echo $twitter_link; ?>"><li>Twitter</li></a>
				<a title="Partager cet article sur Facebook" href="<?php echo $facebook_link; ?>"><li>Facebook</li></a>
			</ul>				
</div>

<?php

    $posts_titles = array();
 
    if ( class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) ) {
        $related = Jetpack_RelatedPosts::init_raw()
            -> get_for_post_id(
                get_the_ID(),
                array( 'size' => 3 )
            );
 
        if ( $related ) {
            foreach ( $related as $result ) {
                $related_post = get_post( $result[ 'id' ] );
                $posts_titles[] = $related_post->post_title;
            }
        }
    }
 
   /** return implode( ', ', $posts_titles ); */


?>


		  
<div style="clear:both;">

<!-- Cas particulier des restaurants -->

<?php if( in_category('restaurant') ) { ?>

<div class="entry-pers">


<div>
<?php 
	if(function_exists('pronamic_google_maps')) {
	echo '<div class="titre">Plan d\'accès</div>';
    pronamic_google_maps(array(
        'width' => 900 ,
        'height' => 400 ,
            'map_options' => array(
			'navigationControl' => false,
			'scrollwheel' => false,
			'mapTypeControl' => false,
			'scrollwheel' => false
            ), 
    ));
} ?>

</div>



</div>


<!-- Cas général -->

<?php } else { ?>



<div class="entry-pers">
					
		
								
						
<!-- Taxonomie perso, articles liés et autres articles dans la catégorie -->
<div class="liste">
	<ul>
			<?php echo get_the_term_list( $post->ID, 'festival', '<li><strong>Festival</strong> : ', ', ','</li>');  ?>	
		
			<?php echo get_the_term_list( $post->ID, 'saga', '<li><strong>Saga</strong> : ', ', ','</li>'); ?>

			<?php 
				if( get_post_meta($post->ID, 'original', true) ) { ?>
			<li><strong>Titre original</strong> : <span style="color:black;display:inline;"><em><?php echo get_post_meta($post->ID, 'original', true); ?></em></span></li> 
			<?php } ?>	



			<?php 
			 if( in_category('cinema') ) { ?>
				<?php echo get_the_term_list( $post->ID, 'createur', '<li><strong>R&eacute;alisateur</strong> : ', ', ','</li>') ?>
			<?php } elseif ( in_category('musique') ) { ?>
				<?php echo get_the_term_list( $post->ID, 'createur', '<li><strong>Artiste</strong> : ', ', ','</li>') ?>
			<?php } elseif ( in_category(array('scenes', 'livres')) ) { ?>
				<?php echo get_the_term_list( $post->ID, 'createur', '<li><strong>Auteur</strong> : ', ', ','</li>') ?>
			<?php } else { ?>
				<?php echo get_the_term_list( $post->ID, 'createur', '<li><strong>Cr&eacute;ateur</strong> : ', ', ','</li>') ?>
			<?php } ?>
			
			<?php echo get_the_term_list( $post->ID, 'annee', '<li><strong>Ann&eacute;e</strong> : ', ', ','</li>'); ?>
			<?php echo get_the_term_list( $post->ID, 'pays', '<li><strong>Nationalit&eacute;</strong> : ', ', ','</li>');  ?>
			<?php echo get_the_term_list( $post->ID, 'acteur', '<li><strong>Acteurs</strong> : ', ', ','</li>');  ?>			

		<?php 
			 if( has_tag('theatre') ) { ?>
				<li><?php echo get_the_term_list( $post->ID, 'lieu', '<strong>Th&eacute;&acirc;tre</strong> : ') ?></li>
				<li><?php echo get_the_term_list( $post->ID, 'metteurenscene', '<strong>Metteur en sc&egrave;ne</strong> : ', ', ') ?></li>
			<?php } elseif ( has_tag('concert') ) { ?>
				<li><?php echo get_the_term_list( $post->ID, 'lieu', '<strong>Salle</strong> : ') ?></li>
			<?php } elseif ( has_tag('opera') ) { ?>
				<li><?php echo get_the_term_list( $post->ID, 'lieu', '<strong>Op&eacute;ra</strong> : ') ?></li>
				<li><?php echo get_the_term_list( $post->ID, 'metteurenscene', '<strong>Metteur en sc&egrave;ne</strong> : ', ', ') ?></li>
			<?php } else { ?>
				<?php echo get_the_term_list( $post->ID, 'lieu', '<li><strong>Salle</strong> : ', ', ','</li>') ?>
			<?php } ?>	
			
			<?php echo get_the_term_list( $post->ID, 'chef', '<li><strong>Chef d\'orchestre</strong> : ', ', ','</li>') ?>
			
			<?php echo get_the_tag_list('<li><strong>Tags</strong> : ',', ','</li>'); ?>
		</ul>
</div>
</div>

<?php } ?>
				
<!-- Date publication et de dernière modification -->	
						
					<div class="date-perso">Article publi&eacute; le <span style="display:inline;"> <?php echo get_the_date(); ?> (derni&egrave;re modification le <?php echo the_modified_date('', '', '', FALSE); ?>)</span> </div>

</div>

<!-- Fin des modifs -->			
		

<?php if ( is_active_sidebar( 'singlular-widget-area' ) ) : ?>
	
		<aside id="singlular-sidebar" class="widget-area" role="complementary">
			<ul class="xoxo">

<?php

	if ( ! dynamic_sidebar( 'singlular-widget-area' ) ) : ?>

		<?php dynamic_sidebar( 'singlular-widget-area' ); ?>

<?php endif; // end Singlular Widget Area ?>

			</ul>
			
		</aside><!-- #singlular-sidebar .widget-area -->



<?php endif; // end singlular sidebar check ?>

