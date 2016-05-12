<?php

// AJOUTS PERSOS
add_action( 'init', 'create_my_taxonomies', 0 );

function create_my_taxonomies() {
	register_taxonomy( 'annee', 'post', array( 'hierarchical' => false, 'label' => 'Ann&eacute;es', 'query_var' => 'annee', 'rewrite' => array( 'slug' => 'annee' )) );
	register_taxonomy( 'pays', 'post', array( 'hierarchical' => false, 'label' => 'Pays', 'query_var' => 'pays', 'rewrite'  => array( 'slug' => 'pays' ) ));
	register_taxonomy( 'createur', 'post', array( 'hierarchical' => false, 'label' => 'Cr&eacute;ateurs', 'query_var' => true, 'rewrite' => array( 'slug' => 'createur' )) );
	register_taxonomy( 'acteur', 'post', array( 'hierarchical' => false, 'label' => 'Acteurs', 'query_var' => 'acteur',  'rewrite' => array( 'slug' => 'acteur' )) );
	register_taxonomy( 'metteurenscene', 'post', array( 'hierarchical' => false, 'label' => 'Metteurs en sc&egrave;ne', 'query_var' => 'metteurenscene',  'rewrite' => array( 'slug' => 'metteurenscene' )) );
	register_taxonomy( 'lieu', 'post', array( 'hierarchical' => false, 'label' => 'Lieux', 'query_var' => 'lieu',  'rewrite' => array( 'slug' => 'lieu' )) );
	register_taxonomy( 'chef', 'post', array( 'hierarchical' => false, 'label' => 'Chefs d\'orchestre', 'query_var' => 'chef',  'rewrite' => array( 'slug' => 'chef' )) );
	register_taxonomy( 'saga', 'post', array( 'hierarchical' => false, 'label' => 'Saga', 'query_var' => 'saga',  'rewrite' => array( 'slug' => 'saga' )) );
	register_taxonomy( 'festival', 'post', array( 'hierarchical' => false, 'label' => 'Festival', 'query_var' => 'festival',  'rewrite' => array( 'slug' => 'festival' )) );
	register_taxonomy( 'original', 'post', array( 'hierarchical' => false, 'label' => 'Original', 'query_var' => 'original',  'rewrite' => array( 'slug' => 'original' ), 'show_in_nav_menus' => false, 'rewrite' => false, 'public' => true ) );

	flush_rewrite_rules();

}

remove_action( 'add_meta_boxes', array( 'Instant_Articles_Meta_Box', 'register_meta_box' ) );
remove_action( 'wp_ajax_instant_articles_meta_box', array( 'Instant_Articles_Meta_Box', 'render_meta_box' ) );

add_action( 'pre_amp_render_post', 'xyz_amp_add_custom_actions' );
function xyz_amp_add_custom_actions() {
    add_filter( 'the_content', 'xyz_amp_add_featured_image' );
}

function xyz_amp_add_featured_image( $content ) {
    if ( has_post_thumbnail() ) {
        // Just add the raw <img /> tag; our sanitizer will take care of it later.
        $image = sprintf( '<p class="xyz-featured-image">%s</p>', get_the_post_thumbnail() );
        $content = $image . $content;
    }
    return $content;
}

add_filter( 'amp_post_template_meta_parts', 'xyz_amp_remove_author_meta' );

function xyz_amp_remove_author_meta( $meta_parts ) {
    foreach ( array_keys( $meta_parts, 'meta-author', true ) as $key ) {
        unset( $meta_parts[ $key ] );
    }
    return $meta_parts;
}


function jeherve_use_custom_colors( $colors_css, $color, $contrast ) {
    $post_id = get_the_ID();

    $tonesque = get_post_meta( $post_id, '_post_colors', true );
    extract( $tonesque );

    $colors_css = ".post a {
        color: #{$color};
    }";

    return $colors_css;
}
add_filter( 'colorposts_css_output', 'jeherve_use_custom_colors', 10, 3 );


// TRI PAR TAXONOMIES
//allows queries to be sorted by taxonomy term name (http://www.jrnielsen.com/wp-query-orderby-taxonomy-term-name/)
add_filter('posts_clauses', 'posts_clauses_with_tax', 10, 2);
function posts_clauses_with_tax( $clauses, $wp_query ) {
    global $wpdb;
    //array of sortable taxonomies
    $taxonomies = array('annee');
    if (isset($wp_query->query['orderby']) && in_array($wp_query->query['orderby'], $taxonomies)) {
        $clauses['join'] .= "
            LEFT OUTER JOIN {$wpdb->term_relationships} AS rel2 ON {$wpdb->posts}.ID = rel2.object_id
            LEFT OUTER JOIN {$wpdb->term_taxonomy} AS tax2 ON rel2.term_taxonomy_id = tax2.term_taxonomy_id
            LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
        ";
        $clauses['where'] .= " AND (taxonomy = '{$wp_query->query['orderby']}' OR taxonomy IS NULL)";
        $clauses['groupby'] = "rel2.object_id";
        $clauses['orderby']  = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
        $clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
    }
    return $clauses;
}

// RECHERCHE INSTANTANÉE
add_action( 'transition_post_status', 'a_new_post', 10, 3 );
 
function a_new_post( $new_status, $old_status, $post )
{
	if ( 'publish' !== $new_status or 'publish' === $old_status )
	{
			return;
	}
	$postsArray = Array(); // un tableau vide
	
	// Liste des sagas
			$taxonomy = 'saga';
			$args = array(
			    'orderby'           => 'name', 
			      'order'             => 'ASC',
			      'hide_empty'        => true, 
			);
	
			$tax_terms = get_terms($taxonomy, $args );
	
			foreach ($tax_terms as $tax_term) {
				$currentPost = Array(); // un tableau vide pour l'article en cours
				$currentPost["title"] = $tax_term->name; // on ajoute le titre
				$currentPost["url"] = get_term_link( $tax_term ); // l'url
				array_push($postsArray, $currentPost); // et on ajoute le tableau de l'article au tableau global
		}
	
	// ********** Liste des articles
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => -1, 
			'no_found_rows' => true, 
			'update_post_meta_cache' => false, 
			'update_post_term_cache' => false, 
			'fields' => 'ids');
	
		$post_query = new WP_Query($args);
		if($post_query->have_posts()) {
			while($post_query->have_posts()) {
				$post_query->the_post();
				$currentPost = Array(); // un tableau vide pour l'article en cours
				$currentPost["title"] = get_the_title(); // on ajoute le titre
				$currentPost["url"] = get_permalink(); // l'url
			
				array_push($postsArray, $currentPost); // et on ajoute le tableau de l'article au tableau global
			
			}
			
			$json = json_encode($postsArray); // on encode tout ça en JSON
		
			if(!file_put_contents(ABSPATH."/search.json", $json)) { // on ecrit tout ca dans un fichier
				throw new Exception("Problème lors de l'écriture du fichier");
			}


	// ********** Liste des créateurs
			$createursArray = Array(); // un tableau vide
		
			//list terms in a given taxonomy
			$taxonomy = 'createur';
			$args = array(
			    'orderby'           => 'name', 
			      'order'             => 'ASC',
			      'hide_empty'        => true, 
			);
	
			$tax_terms = get_terms($taxonomy, $args );
	
			foreach ($tax_terms as $tax_term) {
				$currentPost = Array(); // un tableau vide pour l'article en cours
				$currentPost["title"] = $tax_term->name; // on ajoute le titre
				$currentPost["url"] = get_term_link( $tax_term ); // l'url
				array_push($createursArray, $currentPost); // et on ajoute le tableau de l'article au tableau global
		}
	
		$json = json_encode($createursArray); // on encode tout ça en JSON
	
		if(!file_put_contents(ABSPATH."/createurs.json", $json)) { // on ecrit tout ca dans un fichier
			throw new Exception("Problème lors de l'écriture du fichier");
		}	
	
	// ********** Liste des acteurs
		$acteursArray = Array(); // un tableau vide
	
		//list terms in a given taxonomy
		$taxonomy = 'acteur';
		$args = array(
		    'orderby'           => 'name', 
		      'order'             => 'ASC',
		      'hide_empty'        => true, 
		);

		$tax_terms = get_terms($taxonomy, $args );

		foreach ($tax_terms as $tax_term) {
			$currentPost = Array(); // un tableau vide pour l'article en cours
			$currentPost["title"] = $tax_term->name; // on ajoute le titre
			$currentPost["url"] = get_term_link( $tax_term ); // l'url
			array_push($acteursArray, $currentPost); // et on ajoute le tableau de l'article au tableau global
	}

	$json = json_encode($acteursArray); // on encode tout ça en JSON

	if(!file_put_contents(ABSPATH."/acteurs.json", $json)) { // on ecrit tout ca dans un fichier
	  throw new Exception("Problème lors de l'écriture du fichier");
	}	


	// ********** Liste des annees
		$anneesArray = Array(); // un tableau vide
	
		//list terms in a given taxonomy
		$taxonomy = 'annee';
		$args = array(
		    'orderby'           => 'name', 
		      'order'             => 'ASC',
		      'hide_empty'        => true, 
		);

		$tax_terms = get_terms($taxonomy, $args );

		foreach ($tax_terms as $tax_term) {
			$currentPost = Array(); // un tableau vide pour l'article en cours
			$currentPost["title"] = $tax_term->name; // on ajoute le titre
			$currentPost["url"] = get_term_link( $tax_term ); // l'url
			array_push($anneesArray, $currentPost); // et on ajoute le tableau de l'article au tableau global
	}

	$json = json_encode($anneesArray); // on encode tout ça en JSON

	if(!file_put_contents(ABSPATH."/annees.json", $json)) { // on ecrit tout ca dans un fichier
	  throw new Exception("Problème lors de l'écriture du fichier");
	}	
	
	// ********** Liste des pays
		$paysArray = Array(); // un tableau vide
	
		//list terms in a given taxonomy
		$taxonomy = 'pays';
		$args = array(
		    'orderby'           => 'name', 
		      'order'             => 'ASC',
		      'hide_empty'        => true, 
		);

		$tax_terms = get_terms($taxonomy, $args );

		foreach ($tax_terms as $tax_term) {
			$currentPost = Array(); // un tableau vide pour l'article en cours
			$currentPost["title"] = $tax_term->name; // on ajoute le titre
			$currentPost["url"] = get_term_link( $tax_term ); // l'url
			array_push($paysArray, $currentPost); // et on ajoute le tableau de l'article au tableau global
	}

	$json = json_encode($paysArray); // on encode tout ça en JSON

	if(!file_put_contents(ABSPATH."/nations.json", $json)) { // on ecrit tout ca dans un fichier
	  throw new Exception("Problème lors de l'écriture du fichier");
	}	
	
		}
} 
 
function Unaccent($string)
{
    return preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
}


// AJOUT IMAGE DANS FLUX RSS
function rss_post_thumbnail($content) {
	global $post;

	if(has_post_thumbnail($post->ID)) {
		$content = '<p>' . get_the_post_thumbnail($post->ID, 'full') .
		'</p>' . get_the_content();
}	

return $content;

}


add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');


// Retirer les balises p autour des images (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');


// Retrait CSS taxonomy-images
add_filter( 'taxonomy-images-disable-public-css', '__return_true' );


// Arrêt total pingbacks
add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
function remove_xmlrpc_pingback_ping( $methods ) {
   unset( $methods['pingback.ping'] );
   return $methods;
} ;


// RICG compression accentuée des images
function custom_theme_setup() {
    add_theme_support( 'advanced-image-compression' );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

function jeherve_custom_photon( $args ) {
    $args['quality'] = 80;
    return $args;
}
add_filter( 'jetpack_photon_pre_args', 'jeherve_custom_photon' );

// Retrait de tous les émojis
function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

// Tri dans la colonne des news par dernière modif (source : https://wordpress.org/plugins/sort-by-modified/)

// Register Modified Date Column for both posts & pages
function modified_column_register( $columns ) {
	$columns['date modif'] = __( 'Modification', 'date modified' );
 
	return $columns;
}
add_filter( 'manage_posts_columns', 'modified_column_register' );
add_filter( 'manage_pages_columns', 'modified_column_register' );

// Display the modified date of each post
function modified_column_display( $column_name, $post_id ) {
	global $post; 
	$modified = the_modified_date();
	echo $modified;
}
add_action( 'manage_posts_custom_column', 'modified_column_display', 10, 2 );
add_action( 'manage_pages_custom_column', 'modified_column_display', 10, 2 );

// Register the column as sortable
function modified_column_register_sortable( $columns ) {
	$columns['date modif'] = 'modified';
	return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'modified_column_register_sortable' );
add_filter( 'manage_edit-page_sortable_columns', 'modified_column_register_sortable' );

// FIN DES AJOUTS PERSOS

/**
 * Fonctions de base du blog
 *
 */

/**
 * Define Constants
 */


// Set theme constants
define('THEMENAME', $themeData['Title']);
define('THEMEAUTHOR', $themeData['Author']);
define('THEMEURI', $themeData['URI']);
define('VERSION', $version);

// Path constants
define('TEMPLATE_DIR', get_bloginfo('template_directory'));
define('STYLESHEET_DIR', get_bloginfo('stylesheet_directory'));
define('STYLEURL', get_bloginfo('stylesheet_url'));

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 950;

/** Tell WordPress to run autofocus_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'voiretmanger_setup' );

if ( ! function_exists( 'voiretmanger_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * To override autofocus_setup() in a child theme, add your own autofocus_setup to your child theme's
 * functions.php file.
 */
function voiretmanger_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
    
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script( 'jquery' );	
}
endif;