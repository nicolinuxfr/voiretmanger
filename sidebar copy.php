<?php
/**
 * The Sidebar containing the Singlular Sidebar widget areas.
 */
?>




<!-- Fonctions de partage -->	

			<?php
					$lien = get_permalink();
					$titre = strip_tags(get_the_title());
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
					$excerpt = htmlentities(get_the_excerpt(), ENT_QUOTES, 'UTF-8');
					$facebook_link  = 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $lien . '&p[images][0]=' . $thumb[0] . '&p[title]=' . $titre . '&p[summary]=' . strip_tags($excerpt) ;
					$twitter_link  = 'http://twitter.com/share?url=' . $lien . '&text=' . $titre ;
					$mail_link = 'mailto:?subject=' . $titre . '&amp;body=' . $titre . ' - '. $lien;
					
					?>
	
		<div class="partage-fond">

			
		<div class="partage">
					
					
			<div class="titre">Partager</div> 
										
					<ul>
						<a title="Envoyer cet article par mail" href="<?php echo $mail_link; ?>"><li>Mail</li></a>

						<a title="Partager cet article sur Twitter" href="<?php echo $twitter_link; ?>"><li>Twitter</li></a>
						<a title="Partager cet article sur Facebook" href="<?php echo $facebook_link; ?>"><li>Facebook</li></a>
					</ul>
									
					</div>

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

<div class="titre"><a href="http://voiretmanger.fr/archives/restaurants/">Autres restaurants</a></div>
		<div class="autre-cat">
		  <?php if (class_exists('RPBC')) {
		        new RPBC(
		        array(
				'orderby' => 'rand',
				'cat' => 'category',
		        'order' => 'DESC',
		        'limit' => 5,
		        'echo' => true,
		        'before' => '',
		        'inside' => '',
		        'outside' => '',
		        'after' => '',
		        'rel' => 'nofollow',
		        'type' => 'post',
		        'image' => 'post-thumbnail',
		        'hidden' => 'title',
		       	'message' => 'Aucun article.')
		      );
		  } ?>
		</div>

</div>


<!-- Cas général -->

<?php } else { ?>



<div class="entry-pers" style="width:25%;margin-right:8px;">
						<div class="titre">Informations</div>
		
								
						
<!-- Taxonomie perso, articles liés et autres articles dans la catégorie -->

	<ul>
			<li><?php echo get_the_term_list( $post->ID, 'festival', 'Festival : ', ', ');  ?></li>	
	</ul>

		<ul>

				
		
		<li><?php echo get_the_term_list( $post->ID, 'saga', 'Saga : ', ', '); ?></li>

			<?php 
				if( get_post_meta($post->ID, 'original', true) ) { ?>
			<li>Titre original : <span style="color:black;display:inline;"><em><?php echo get_post_meta($post->ID, 'original', true); ?></em></span></li> 
			<?php } ?>	



			<?php 
			 if( in_category('cinema') ) { ?>
				<li><?php echo get_the_term_list( $post->ID, 'createur', 'R&eacute;alisateur : ', ', ') ?></li>
			<?php } elseif ( in_category('musique') ) { ?>
				<li><?php echo get_the_term_list( $post->ID, 'createur', 'Artiste : ', ', ') ?></li>
			<?php } elseif ( in_category(array('scenes', 'livres')) ) { ?>
				<li><?php echo get_the_term_list( $post->ID, 'createur', 'Auteur : ', ', ') ?></li>
			<?php } else { ?>
				<li><?php echo get_the_term_list( $post->ID, 'createur', 'Cr&eacute;ateur : ', ', ') ?></li>
			<?php } ?>
			
			<li><?php echo get_the_term_list( $post->ID, 'annee', 'Ann&eacute;e : ', ', '); ?></li>
			<li><?php echo get_the_term_list( $post->ID, 'pays', 'Nationalit&eacute; : ', ', ');  ?></li>
			<li><?php echo get_the_term_list( $post->ID, 'acteur', 'Acteurs : ', ', ');  ?></li>			
			
		</ul>
<?php 
	if( in_category('scenes') )
		echo '<div class="titre">Repr&eacute;sentation</div>'
		?>
	<ul>	
		<?php 
			 if( has_tag('theatre') ) { ?>
				<li><?php echo get_the_term_list( $post->ID, 'lieu', 'Th&eacute;&acirc;tre : ') ?></li>
				<li><?php echo get_the_term_list( $post->ID, 'metteurenscene', 'Metteur en sc&egrave;ne : ', ', ') ?></li>
			<?php } elseif ( has_tag('concert') ) { ?>
				<li><?php echo get_the_term_list( $post->ID, 'lieu', 'Salle : ') ?></li>
			<?php } elseif ( has_tag('opera') ) { ?>
				<li><?php echo get_the_term_list( $post->ID, 'lieu', 'Op&eacute;ra : ') ?></li>
				<li><?php echo get_the_term_list( $post->ID, 'metteurenscene', 'Metteur en sc&egrave;ne : ', ', ') ?></li>
			<?php } else { ?>
				<li><?php echo get_the_term_list( $post->ID, 'lieu', 'Salle : ') ?></li>
			<?php } ?>	
			
			<li><?php echo get_the_term_list( $post->ID, 'chef', 'Chef d\'orchestre : ', ', ') ?></li>
		</ul>

		<ul>
		<?php echo get_the_tag_list('<li>Tags : ',', ','</li>'); ?>
		</ul>
</div>


		



<div class="entry-pers" style="width:74%">
<div class="titre">Dans la m&ecirc;me cat&eacute;gorie :</div>
		<ul class="entry-pers-img">
		  <?php if (class_exists('RPBC')) {
		        new RPBC(
		        array(
				'orderby' => 'rand',
				'cat' => 'category',
		        'order' => 'DESC',
		        'limit' => 4,
		        'echo' => true,
		        'before' => '<li>',
		        'inside' => '',
		        'outside' => '',
		        'after' => '</li>',
		        'rel' => 'nofollow',
		        'type' => 'post',
		        'image' => 'post-thumbnail',
		        'hidden' => 'title',
		       	'message' => 'Aucun article.')
		      );
		  } ?>
		</ul>
</div>


<?php } ?>

				
<!-- Date publication et de dernière modification -->	
						
					<div class="date-perso">Article publi&eacute; le <span style="color:black;display:inline;"> <?php echo get_the_date(); ?></span> 
					
					<?php
	
						$publication = get_the_date();
						$modification = the_modified_date('', '', '', FALSE);
					
					 if ($publication != $modification ) {  
					 echo '(derni&egrave;re modification le ' . $modification . ')';  
					 } ?>
					</div>

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

