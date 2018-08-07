<?php 

	// Puisqu'on ne veut pas de page pour afficher les images et autres fichiers, on renvoie automatiquement vers l'article associé. Source : http://www.wpbeginner.com/wp-tutorials/how-to-disable-image-attachment-pages-in-wordpress/
	
	$permalien = get_permalink($post->post_parent);
	if($permalien == get_permalink()){
		wp_redirect(home_url()); 
	}
	else{
		wp_redirect($permalien); 
	}
?>