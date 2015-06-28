<?php

add_filter( 'searchwp_debug', '__return_true' );

// AJOUTS PERSOS
add_action( 'init', 'create_my_taxonomies', 0 );

function create_my_taxonomies() {
	register_taxonomy( 'pays', 'post', array( 'hierarchical' => false, 'label' => 'Pays', 'query_var' => true, 'rewrite' => true ) );
	register_taxonomy( 'annee', 'post', array( 'hierarchical' => false, 'label' => 'Ann&eacute;es', 'query_var' => 'annee', 'rewrite' => array( 'slug' => 'annee' )) );
	register_taxonomy( 'createur', 'post', array( 'hierarchical' => false, 'label' => 'Cr&eacute;ateurs', 'query_var' => true, 'rewrite' => true ) );
	register_taxonomy( 'acteur', 'post', array( 'hierarchical' => false, 'label' => 'Acteurs', 'query_var' => 'acteur',  'rewrite' => array( 'slug' => 'acteur' )) );
	register_taxonomy( 'metteurenscene', 'post', array( 'hierarchical' => false, 'label' => 'Metteurs en sc&egrave;ne', 'query_var' => 'metteurenscene',  'rewrite' => array( 'slug' => 'metteurenscene' )) );
	register_taxonomy( 'lieu', 'post', array( 'hierarchical' => false, 'label' => 'Lieux', 'query_var' => 'lieu',  'rewrite' => array( 'slug' => 'lieu' )) );
	register_taxonomy( 'chef', 'post', array( 'hierarchical' => false, 'label' => 'Chefs d\'orchestre', 'query_var' => 'chef',  'rewrite' => array( 'slug' => 'chef' )) );
	register_taxonomy( 'saga', 'post', array( 'hierarchical' => false, 'label' => 'Saga', 'query_var' => 'saga',  'rewrite' => array( 'slug' => 'saga' )) );
	register_taxonomy( 'festival', 'post', array( 'hierarchical' => false, 'label' => 'Festival', 'query_var' => 'festival',  'rewrite' => array( 'slug' => 'festival' )) );
	register_taxonomy( 'original', 'post', array( 'hierarchical' => false, 'label' => 'Original', 'query_var' => 'original',  'rewrite' => array( 'slug' => 'original' )) );


}

 
 
 // RECHERCHE -- Source : http://www.geekpress.fr/wordpress/astuce/modifier-url-page-resultats-recherche-wordpress-560/
// add_action('template_redirect', 'gkp_search_url_rewrite_rule');
/*
function gkp_search_url_rewrite_rule() {
 
    global $wp_rewrite;
	
    if ( is_search() && isset( $_GET['s'] ) ) {
	$s = str_replace( array( ' ', '%20' ), '+', get_query_var( 's' ) );
	wp_redirect( home_url( $wp_rewrite->search_base . '/' . remove_accents ( $s ) ) );
	exit();
    }
}
 
//add_action('init','gkp_change_search_permalinks');
function gkp_change_search_permalinks( ) {
    global $wp_rewrite;
    $wp_rewrite->search_base = 'recherche';
}
*/

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
	// ********** Liste des articles
		$postsArray = Array(); // un tableau vide

		$args = array('post_type' => 'post','posts_per_page' => -1);
	
		$post_query = new WP_Query($args);
		if($post_query->have_posts()) {
			while($post_query->have_posts()) {
				$post_query->the_post();
				$currentPost = Array(); // un tableau vide pour l'article en cours
				$currentPost["title"] = get_the_title(); // on ajoute le titre
				$currentPost["url"] = get_the_ID(); // l'url
			
			
				array_push($postsArray, $currentPost); // et on ajoute le tableau de l'article au tableau global
			

			}
			
			$json = json_encode($postsArray); // on encode tout ça en JSON
		
			if(!file_put_contents(ABSPATH."/search.json", $json)) { // on ecrit tout ca dans un fichier
			  throw new Exception("Probleme lors de l'ecrtiture du fichier");
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
		  throw new Exception("Probleme lors de l'ecrtiture du fichier");
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
	  throw new Exception("Probleme lors de l'ecrtiture du fichier");
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
	  throw new Exception("Probleme lors de l'ecrtiture du fichier");
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

	if(!file_put_contents(ABSPATH."/pays.json", $json)) { // on ecrit tout ca dans un fichier
	  throw new Exception("Probleme lors de l'ecrtiture du fichier");
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


// Articles liés
function jetpackme_move_related_posts_to_top( $options ) {
    $options['enabled'] = true;
    return $options;
}
add_filter( 'jetpack_relatedposts_filter_options', 'jetpackme_move_related_posts_to_top' );
add_filter( 'rocket_htaccess_mod_rewrite', 'patch_jetpack_29' );
function patch_jetpack_29( $rules )
{
	return str_replace( '!.*=.*', '=""', $rules );
}


function no_photon_by_page() {
  if ( ! is_singular() ) {
	 add_filter( 'jetpack_photon_skip_image', '__return_true');
  }
}
 
add_action('wp', 'no_photon_by_page');




// Retirer les balises p autour des images (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');


// Retrait catégorie archive du blog aux articles liés
function jetpackme_filter_exclude_category( $filters ) {
    $filters[] = array( 'not' =>
      array( 'term' => array( 'category.slug' => 'archives-du-blog' ) )
    );
    return $filters;
}
add_filter( 'jetpack_relatedposts_filter_filters', 'jetpackme_filter_exclude_category' );

// Jetpack : Bonne taille d'images
function jetpackchange_image_size ( $thumbnail_size ) {
    $thumbnail_size['width'] = 900;
    $thumbnail_size['height'] = 515;
    return $thumbnail_size;
}
add_filter( 'jetpack_relatedposts_filter_thumbnail_size', 'jetpackchange_image_size' );

// Retrait CSS taxonomy-images
add_filter( 'taxonomy-images-disable-public-css', '__return_true' );


// Arrêt total pingbacks
add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
function remove_xmlrpc_pingback_ping( $methods ) {
   unset( $methods['pingback.ping'] );
   return $methods;
} ;

add_filter( 'show_admin_bar', '__return_false' );



// FIN DES AJOUTS PERSOS

/**
 * AutoFocus functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, autofocus_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
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


//	Load AutoFocus WP Filters
require_once(TEMPLATEPATH . '/inc/autofocus-filters.php');

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 950;

/** Tell WordPress to run autofocus_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'autofocus_setup' );

if ( ! function_exists( 'autofocus_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * To override autofocus_setup() in a child theme, add your own autofocus_setup to your child theme's
 * functions.php file.
 */
function autofocus_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add new Full Gallery & Archive Thumb image sizes for Front Page slider and Archives
	add_image_size( 'home-1', 1200, 600, true ); // Images du bas thumbnail size
	add_image_size( 'home-2', 750, 450, true ); // Images du bas thumbnail size
	add_image_size( 'home-3', 450, 450, true ); // Images du bas thumbnail size
	add_image_size( 'home-4', 400, 450, true ); // Images du bas thumbnail size
	set_post_thumbnail_size( 400, 400, true ); // Default thumbnail size
	add_image_size( 'archive-thumbnail', 1200, 800, true ); // Archives thumbnail size
	add_image_size( 'bottom-thumbnail', 900, 500, true ); // Images du bas thumbnail size
	add_image_size( 'full-post-thumbnail', 1600, 9999 ); // Full Single Posts thumbnail size

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'autofocus' ),
	) );
    
	wp_enqueue_style( 'dashicons' );
}
endif;


/**
 * Prints HTML with meta information for the current post—date/time and author.
 */ 
if ( ! function_exists( 'af_posted_on' ) ) :
function af_posted_on() {
	printf( '<a class="%1$s" href="%2$s" title="%3$s" rel="bookmark"><time datetime="%4$s" pubdate>%5$s</time></a>',
		'entry-date',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date('Y-m-d\TH:i') ),
		esc_attr( get_the_date() )
	);
}
endif;

/**
 * Prints HTML with meta information for the current post (date, author, category, tags and permalink).
 */
if ( ! function_exists( 'af_post_meta' ) ) :
function af_post_meta() { 
		// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', __( ', ', 'autofocus' ) );
	if ( $tag_list ) {
		$posted_in = __( '<span class="entry-cats">Class&eacute; dans %1$s.</span> <span class="entry-tags">Tags : %2$s.</span> <span class="entry-permalink"><a href="%3$s" title="Lien permanent vers %4$s" rel="bookmark">Lien permanent</a></span>', 'autofocus' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( '<span class="entry-cats">Class&eacute; dans %1$s.</span> <span class="entry-permalink"><a href="%3$s" title="Lien permanent vers %4$s" rel="bookmark">Lien permament</a></span>', 'autofocus' );
	} else {
		$posted_in = __( '<span class="entry-permalink"><a href="%3$s" title="Lien permanent vers %4$s" rel="bookmark">Lien permanent</a></span>', 'autofocus' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( __( ', ', 'autofocus' ) ),
		$tag_list,
		esc_url( get_permalink() ),
		the_title_attribute( 'echo=0' )
	);
}
endif;


/**
 * Display Author Avatar
 */
function af_author_info_avatar() {
    global $wp_query; 
    $curauth = $wp_query->get_queried_object();
	
	$email = $curauth->user_email;
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar("$email") );
	echo $avatar;
}


/**
 *	Previous / Next Excerpts
 *	- Thanks very much to Thin & Light (http://thinlight.org/) for this custom function!
 */

/**
 *	AutoFocus Navigation Above
 */
function autofocus_nav_above() {
	global $post, $excluded_categories, $in_same_cat, $shortname;

	// Grab The Blog Category
	$af_blog_catid = of_get_option($shortname . '_blog_cat');

	if ( in_category($af_blog_catid)) : ?>
				<nav id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link('%link', __('<span class="meta-nav">&larr;</span>', 'autofocus'), TRUE) ?></div>
					<div class="nav-next"><?php next_post_link('%link', __('<span class="meta-nav">&rarr;</span>', 'autofocus'), TRUE) ?></div>
				</nav><!-- #nav-above -->
	<?php else : ?>
				<nav id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link('%link', __('<span class="meta-nav">&larr;</span>', 'autofocus'), 0, $af_blog_catid) ?></div>
					<div class="nav-next"><?php next_post_link('%link', __('<span class="meta-nav">&rarr;</span>', 'autofocus'), 0, $af_blog_catid) ?></div>
				</nav><!-- #nav-above -->
	<?php endif; 
}

/**
 *	AutoFocus Navigation Below
 */
function autofocus_nav_below() {
	global $post, $excluded_categories, $in_same_cat, $shortname;
	
	// Grab The Blog Category
	$af_blog_catid = of_get_option($shortname . '_blog_cat');

	if ( in_category($af_blog_catid) ) : ?>
			<nav id="nav-below" class="navigation">
				<h3><?php _e('Naviguer', 'autofocus') ?></h3>
			<?php 
				$previouspost = get_previous_post(TRUE);
				if ($previouspost != null) {
					echo '<div class="nav-previous">';
					echo '<div class="nav-excerpt">';
					previous_post_excerpt(TRUE);
										previous_post_link('<span class="meta-nav">&larr;</span> Older: %link', '%title', TRUE);

					echo '</div></div>';
				 } ?>
	
			<?php 
				$nextpost = get_next_post(TRUE);
				if ($nextpost != null) {
					echo '<div class="nav-next">';
					next_post_link('Newer: %link <span class="meta-nav">&rarr;</span>', '%title', TRUE);
					echo '<div class="nav-excerpt">';
					next_post_excerpt(TRUE);
					echo '</div></div>';
				 } ?>

			</nav><!-- #nav-below -->

	<?php else : ?>

			<nav id="nav-below" class="navigation">
				<h3><?php _e('Naviguer', 'autofocus') ?></h3>
			<?php 
				$previouspost = get_previous_post(FALSE, $af_blog_catid);
				if ($previouspost != null) { 
					echo '<div class="nav-previous">';
					echo '<div class="nav-excerpt">';
					previous_post_excerpt(FALSE, $af_blog_catid);
					previous_post_link('<span class="meta-nav">&larr;</span> Avant : %link', '%title', FALSE, $af_blog_catid);
					echo '</div></div>';
				 } ?>
	
			<?php 
				$nextpost = get_next_post(FALSE, $af_blog_catid);
				if ($nextpost != null) {
					echo '<div class="nav-next">';
					echo '<div class="nav-excerpt">';
					next_post_excerpt(FALSE, $af_blog_catid);
					next_post_link('Apr&egrave;s : %link <span class="meta-nav">&rarr;</span>', '%title', FALSE, $af_blog_catid);
					echo '</div></div>';
				 } ?>

			</nav><!-- #nav-below -->

	<?php endif;
}