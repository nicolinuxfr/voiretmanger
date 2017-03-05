<?php
/**
 * The Sidebar containing the Singlular Sidebar widget areas.
 */
?>

<?php if( in_category('restaurant') ) { ?>

   <section class="post-meta">
   		<span class="resto"><a href="https://voiretmanger.fr/a-manger/">Toutes les critiques de restaurant</a></span>
   </section>
   
 <?php } ?>

<div data-no-instant>
<?php
	if(function_exists('pronamic_google_maps')) {
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




<!-- Fonctions de partage -->
	<?php
		$lien = get_permalink();
		$titre = strip_tags(get_the_title());
		$facebook_link  = 'https://www.facebook.com/sharer/sharer.php?u=' . $lien ;
		$twitter_link  = 'http://twitter.com/share?url=' . $lien . '&text=' . $titre ;
		$mail_link = 'mailto:?subject=' . $titre . '&amp;body=' . $titre . ' - ' . $lien ;
		$contact = 'mailto:nicolinux@gmail.com?subject=Au%20sujet%20de%20' . $titre . ' - ' . $lien ;
	?>
	
<section class="partage">
	<a title="Me contacter" href="<?php echo $contact; ?>" ><h4>Une erreur, une remarque&nbsp;?</h4></a>
		<ul>
			<a title="Envoyer cet article par mail" href="<?php echo $mail_link; ?>"><li>Envoyer par Mail</li></a>
			<a title="Partager cet article sur Twitter" href="<?php echo $twitter_link; ?>"><li>Partager sur Twitter</li></a>
			<a title="Partager cet article sur Facebook" href="<?php echo $facebook_link; ?>"><li>Partager sur Facebook</li></a>
		</ul>
</section>

<section class="post-meta">
<!-- Taxonomie perso, articles liés et autres articles dans la catégorie -->
	<ul>
		<?php echo get_the_term_list( $post->ID, 'festival', '<li><strong>Festival</strong> : ', ', ','</li>');  ?>
		<?php echo get_the_term_list( $post->ID, 'saga', '<li><strong>Saga</strong> : ', ', ','</li>'); ?>
		<?php echo get_the_term_list( $post->ID, 'original', '<li><strong>Titre original</strong> : ', ', ','</li>'); ?>
		<?php
			if( get_post_meta($post->ID, 'original', true) ) { ?>
			<li><strong>Titre original</strong> : <span><em><?php echo get_post_meta($post->ID, 'original', true); ?></em></span></li>
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
			<?php echo get_the_term_list( $post->ID, 'acteur', '<li class="acteurs"><strong>Acteurs</strong> : ', ', ','</li>');  ?>

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
			
			<?php if (! in_category( array('961', '3977'))) :
				echo get_the_tag_list('<li><strong>Tags</strong> : ',', ','</li>');
			endif; ?>
		</ul>
		
		
		<time class="post-date" datetime="<?php echo get_the_date(); ?>">
		<?php
			$u_time = get_the_time('U');
			$u_modified_time = get_the_modified_time('U');
		?>	
		
		Article publi&eacute; le <span style="display:inline;"> <?php echo get_the_date(); ?> <?php 	if ($u_modified_time >= $u_time + 86400) { echo "(derni&egrave;re modification le " .  the_modified_date('', '', '', FALSE) . ")"; } ?></span>
	</time>
		
</section>