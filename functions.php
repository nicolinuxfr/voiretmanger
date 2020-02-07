<?php

// AJOUTS PERSOS
add_action( 'init', 'create_my_taxonomies', 0 );

function create_my_taxonomies() {
	register_taxonomy( 'annee', 'post', array( 'hierarchical' => false, 'label' => 'Années', 'query_var' => 'annee', 'rewrite' => array( 'slug' => 'annee' ), 'show_in_rest' => true ));
	register_taxonomy( 'pays', 'post', array( 'hierarchical' => false, 'label' => 'Pays', 'query_var' => 'pays', 'rewrite'  => array( 'slug' => 'pays' ), 'show_in_rest' => true ));
	register_taxonomy( 'createur', 'post', array( 'hierarchical' => false, 'label' => 'Créateurs', 'query_var' => true, 'rewrite' => array( 'slug' => 'createur' ), 'show_in_rest' => true  ));
	register_taxonomy( 'acteur', 'post', array( 'hierarchical' => false, 'label' => 'Acteurs', 'query_var' => 'acteur',  'rewrite' => array( 'slug' => 'acteur' ), 'show_in_rest' => true  ));
	register_taxonomy( 'metteurenscene', 'post', array( 'hierarchical' => false, 'label' => 'Metteurs en scène', 'query_var' => 'metteurenscene',  'rewrite' => array( 'slug' => 'metteurenscene' ), 'show_in_rest' => true  ));
	register_taxonomy( 'lieu', 'post', array( 'hierarchical' => false, 'label' => 'Lieux', 'query_var' => 'lieu',  'rewrite' => array( 'slug' => 'lieu' ), 'show_in_rest' => true  ));
	register_taxonomy( 'chef', 'post', array( 'hierarchical' => false, 'label' => 'Chefs d\'orchestre', 'query_var' => 'chef',  'rewrite' => array( 'slug' => 'chef' ), 'show_in_rest' => true  ));
	register_taxonomy( 'saga', 'post', array( 'hierarchical' => false, 'label' => 'Saga', 'query_var' => 'saga',  'rewrite' => array( 'slug' => 'saga' ), 'show_in_rest' => true  ));
	register_taxonomy( 'festival', 'post', array( 'hierarchical' => false, 'label' => 'Festival', 'query_var' => 'festival',  'rewrite' => array( 'slug' => 'festival' ), 'show_in_rest' => true  ));
	register_taxonomy( 'original', 'post', array( 'hierarchical' => false, 'label' => 'Original', 'query_var' => 'original',  'rewrite' => array( 'slug' => 'original' ), 'show_in_nav_menus' => false, 'rewrite' => false, 'public' => false ) );

	flush_rewrite_rules();

}

// Création Custom Post Type pour les mises à jour d'article
function vm_maj_post_type() {

	$labels = array(
		'name'                  => _x( 'Mises à jour', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Mise à jour', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Mises à jour', 'text_domain' ),
		'name_admin_bar'        => __( 'Mise à jour', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Les mises à jour', 'text_domain' ),
		'add_new_item'          => __( 'Nouvelle mise à jour', 'text_domain' ),
		'add_new'               => __( 'Ajouter', 'text_domain' ),
		'new_item'              => __( 'Nouvelle mise à jour', 'text_domain' ),
		'edit_item'             => __( 'Modifier la mise à jour', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Image mise en avant', 'text_domain' ),
		'set_featured_image'    => __( 'Définir l’image mise en avant', 'text_domain' ),
		'remove_featured_image' => __( 'Retirer l’image mise en avant', 'text_domain' ),
		'use_featured_image'    => __( 'Utiliser comme image mise en avant', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Mise à jour', 'text_domain' ),
		'description'           => __( 'Mises à jour d\'anciens articles', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'publicize', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-upload',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type( 'post_maj', $args );

}
add_action( 'init', 'vm_maj_post_type', 0 );

// Ajout des mises à jour d'articles dans le flux RSS (source : http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-post-types-to-your-main-wordpress-rss-feed/)
function vm_maj_post_type_rss($qv) {
    if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('post', 'post_maj');
    return $qv;
}
add_filter('request', 'vm_maj_post_type_rss');

// Ajout des mises à jour d'articles dans les archives de date (source : https://wordpress.stackexchange.com/questions/179023/adding-custom-post-types-to-archive-php)
add_action('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if($query->is_main_query()
    && ( is_archive() && !is_admin() )) {
        $query->set( 'post_type', array('post','post_maj') );
  }
}

// Retrait des query string pour les ressources statiques.

function _remove_script_version( $src ){
$parts = explode( '?ver', $src );
return $parts[0];
}

add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );


// Prise en charge des sticky posts et pagination corrigée (source http://wordpress.stackexchange.com/questions/180005/include-sticky-post-in-page-posts-count/180021#180021)
add_action( 'pre_get_posts', function ( $q )
{

    if ( $q->is_home() ) {

        $count_stickies = count( get_option( 'sticky_posts' ) );
        $ppp = get_option( 'posts_per_page' );
        $offset = ( $count_stickies <= $ppp ) ? ( $ppp - ( $ppp - $count_stickies ) ) : $ppp;

        if (!$q->is_paged()) {
          $q->set('posts_per_page', ( $ppp - $offset ));
        } else {
          $offset = ( ($q->query_vars['paged']-1) * $ppp ) - $offset;
          $q->set('posts_per_page',$ppp);
          $q->set('offset',$offset);
        }

    }

});

add_filter( 'found_posts', function ( $found_posts, $q )
{

    if( $q->is_home() ) {

        $count_stickies = count( get_option( 'sticky_posts' ) );
        $ppp = get_option( 'posts_per_page' );
        $offset = ( $count_stickies <= $ppp ) ? ( $ppp - ( $ppp - $count_stickies ) ) : $ppp;

        $found_posts = $found_posts + $offset;
    }
    return $found_posts;

}, 10, 2 ); 

// Algolia : pas d’indexation des pages
function exclude_post_types( $should_index, WP_Post $post )
{
    // Add all post types you don't want to make searchable.
    $excluded_post_types = array( 'page', 'post_maj' );
    if ( false === $should_index ) {
        return false;
    }

    return ! in_array( $post->post_type, $excluded_post_types, true );
}
add_filter( 'algolia_should_index_searchable_post', 'exclude_post_types', 10, 2 );

// Algolia : ajout du titre original
function my_post_attributes( array $attributes, WP_Post $post ) {
	if( get_post_meta($post->ID, 'original', true) ){
		$attributes['original'] = get_post_meta( $post->ID, 'original', true );
	}
	return $attributes;
}

add_filter( 'algolia_post_shared_attributes', 'my_post_attributes', 10, 2 );
add_filter( 'algolia_searchable_post_shared_attributes', 'my_post_attributes', 10, 2 );

// Algolia : retrait du nom de l’auteur, puisque je suis le seul auteur.
function my_post_shared_attributes( array $shared_attributes, WP_Post $post) {

  if ( isset( $shared_attributes['post_author'] ) ) {
    unset( $shared_attributes['post_author'] );
  }

  return $shared_attributes;
}
add_filter( 'algolia_post_shared_attributes', 'my_post_shared_attributes', 10, 2 );


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
			'nopaging' => true,
			'no_found_rows' => true,
			'cat' => '-1818',
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

			if(!file_put_contents(ABSPATH."/wp-content/search.json", $json)) { // on ecrit tout ca dans un fichier
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
    return preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '\1', $content);
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


// Code YouTube responsive

// Référence : <div class="video-container"><iframe class="aligncenter" src="URL" frameborder="0" allowfullscreen></iframe></div>

add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);

function wrap_embed_with_div($html, $url, $attr) {
	return "<div class=\"video-container\">".$html."</div>";
}

// RICG compression accentuée des images
function custom_theme_setup() {
    add_theme_support( 'advanced-image-compression' );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );


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

// Retrait de scripts inutiles
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );


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



function voiretmanger_infinite_scroll_init() {
    add_theme_support( 'infinite-scroll', array(
	    'container' => 'content',
	    'footer' => false,
		'render' => 'voiretmanger_infinite_scroll_render',
		'posts_per_page' => 8,
		'wrapper' => false,
    ) );
}
add_action( 'after_setup_theme', 'voiretmanger_infinite_scroll_init' );


function voiretmanger_infinite_scroll_render() {
	get_template_part('liste', 'archives');
}


//Ajout des mises à jour sur l'écran d'accueil de WordPress (source : https://toolset.com/forums/topic/add-custom-post-type-to-dashboard-at-a-glance-box/)
add_action( 'dashboard_glance_items', 'cpad_at_glance_content_table_end' );
function cpad_at_glance_content_table_end() {
    $args = array(
        'public' => true,
        '_builtin' => false
    );
    $output = 'object';
    $operator = 'and';
  
    $post_types = get_post_types( $args, $output, $operator );
    foreach ( $post_types as $post_type ) {
        $num_posts = wp_count_posts( $post_type->name );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );
        if ( current_user_can( 'edit_posts' ) ) {
            $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
            echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
        }
    }
}

// source : https://gist.github.com/douglasanro/2f41b0a198f4822508c4a1694c4e3bf1
add_filter( 'dashboard_recent_posts_query_args', 'add_page_to_dashboard_activity' );
function add_page_to_dashboard_activity( $query_args ) {
	$query_args['post_type'] = array( 'post', 'post_maj' );
	if ( $query_args['post_status'] == 'publish' ) {
		$query_args['posts_per_page'] = 10;
	}
	return $query_args;
}

// Suppression de la fonction de redimensionnement des images de WordPress 5.3 https://make.wordpress.org/core/2019/10/09/introducing-handling-of-big-images-in-wordpress-5-3/
add_filter( 'big_image_size_threshold', '__return_false' );


// FIN DES AJOUTS PERSOS

/**
 * Fonctions de base du blog
 *
 */

/**
 * Define Constants
 */


// Set theme constants
//define('THEMENAME', $themeData['Title']);
//define('THEMEAUTHOR', $themeData['Author']);
//define('THEMEURI', $themeData['URI']);
//define('VERSION', $version);

// Path constants
//define('TEMPLATE_DIR', get_bloginfo('template_directory'));
//define('STYLESHEET_DIR', get_bloginfo('stylesheet_directory'));
//define('STYLEURL', get_bloginfo('stylesheet_url'));

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
