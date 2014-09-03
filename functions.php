<?php

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
	
	$args = array('post_type' => 'post','posts_per_page' => -1);
	
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

function custom_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

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
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 */

/**
 * Define Constants
 */


// Set theme constants
define('THEMENAME', $themeData['Title']);
define('THEMEAUTHOR', $themeData['Author']);
define('THEMEURI', $themeData['URI']);
define('VERSION', $version);

// Set child theme constants
define('TEMPLATENAME', $childeThemeData['Title']);
define('TEMPLATEAUTHOR', $childeThemeData['Author']);
define('TEMPLATEURI', $childeThemeData['URI']);
define('TEMPLATEVERSION', $templateversion);

// Path constants
define('TEMPLATE_DIR', get_bloginfo('template_directory'));
define('STYLESHEET_DIR', get_bloginfo('stylesheet_directory'));
define('STYLEURL', get_bloginfo('stylesheet_url'));

/**
 * Load Options Framework: http://wptheming.com/2010/12/options-framework/
 */

if ( !function_exists( 'optionsframework_init' ) ) {

	/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */
	if ( STYLESHEETPATH == TEMPLATEPATH ) { 
		define('OPTIONS_FRAMEWORK_PATH', STYLESHEETPATH . '/inc/options/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('stylesheet_directory') . '/inc/options/');
	} else {
		define('OPTIONS_FRAMEWORK_PATH', TEMPLATEPATH . '/inc/options/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/inc/options/');
	}
	
	require_once (OPTIONS_FRAMEWORK_PATH . 'options-framework.php');
	require_once (OPTIONS_FRAMEWORK_PATH . 'options-functions.php');

}

//	Load AutoFocus Image Functions
//require_once(TEMPLATEPATH . '/inc/autofocus-images.php');

//	Load AutoFocus WP Filters
require_once(TEMPLATEPATH . '/inc/autofocus-filters.php');

//	Load AutoFocus Settings
require_once(TEMPLATEPATH . '/inc/autofocus-shortcodes.php');

//	Load AutoFocus Post Meta Options
//require_once(TEMPLATEPATH . '/inc/autofocus-post-meta.php');

//	Load AutoFocus Shortcode Instructions
//require_once(TEMPLATEPATH . '/inc/autofocus-help.php');

//Load php Flickr and set up Flickr API variable: http://phpflickr.com/
//require_once(TEMPLATEPATH . '/inc/phpFlickr.php' );
//$af_flickr = new phpFlickr( flickrApiKey() );

//	Load AF+ Flickr Functions
//require_once(TEMPLATEPATH . '/inc/autofocus-flickr.php');


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 690;

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
	add_image_size( 'archive-thumbnail', 900, 500, true ); // Archives thumbnail size
	add_image_size( 'bottom-thumbnail', 900, 500, true ); // Images du bas thumbnail size
	//add_image_size( 'fixed-post-thumbnail', 950, 600, true ); // Fixed Single Posts thumbnail size
	add_image_size( 'full-post-thumbnail', 1600, 9999 ); // Full Single Posts thumbnail size


	
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'autofocus', TEMPLATEPATH . '/languages' );

	// Set Up localization
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'autofocus' ),
	) );
}
endif;


/**
 * Template for comments and pingbacks.
 */
if ( ! function_exists( 'autofocus_comment' ) ) :
function autofocus_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'comment' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 50 ); ?>
			<?php printf( __( '%s', 'autofocus' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'autofocus' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'autofocus' ), get_comment_date(),  get_comment_time() ); ?></a>
				<?php edit_comment_link( __( 'Modifier', 'autofocus' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'By', 'autofocus' ); ?> <?php comment_author_link(); ?>
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'autofocus' ), get_comment_date(),  get_comment_time() ); ?>
				<?php edit_comment_link( __('Modifier', 'autofocus'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
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
function af_excerpt($text, $excerpt_length = 25) {
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = strip_tags($text);
	$text = preg_replace("/\[.*?]/", "", $text);
	$words = explode(' ', $text, $excerpt_length + 1);
	if (count($words) > $excerpt_length) {
		array_pop($words);
		array_push($words, '...');
		$text = implode(' ', $words);
	}	
	return apply_filters('the_excerpt', $text);
}

//	Setup AF Post Excerpt
function af_post_excerpt($post) {
	$excerpt = ($post->post_excerpt == '') ? (af_excerpt($post->post_content))
			: (apply_filters('the_excerpt', $post->post_excerpt));
	return $excerpt;
}

//	Setup Previous Post Excerpt
function previous_post_excerpt($in_same_cat = 1, $excluded_categories = '') {
	if ( is_attachment() )
		$post = &get_post($GLOBALS['post']->post_parent);
	else
		$post = get_previous_post($in_same_cat, $excluded_categories);

	if ( !$post )
		return;
	$post = &get_post($post->ID);
	//echo af_post_excerpt($post);
	echo '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( $post->post_title ) . '">';
	echo get_the_post_thumbnail($post->ID, 'bottom-thumbnail');
    echo '</a>';
}

//	Setup Next Post Excerpt
function next_post_excerpt($in_same_cat = 1, $excluded_categories = '') {
	if ( is_attachment() )
		$post = &get_post($GLOBALS['post']->post_parent);
	else
		$post = get_next_post($in_same_cat, $excluded_categories);

	if ( !$post )
		return;
	$post = &get_post($post->ID);
	//echo af_post_excerpt($post);
	echo '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( $post->post_title ) . '">';
	echo get_the_post_thumbnail($post->ID, 'bottom-thumbnail');
	echo '</a>';
}

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

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override autofocus_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 */
function autofocus_widgets_init() {
	// Area 1, located to the right of the content area.
	register_sidebar( array(
		'name' => __( 'Singlular Widget Area', 'autofocus' ),
		'id' => 'singlular-widget-area',
		'description' => __( 'The singlar post/page widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'autofocus' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'autofocus' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'autofocus' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'autofocus' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located above the header.
	register_sidebar( array(
		'name' => __( 'Leaderboard Widget Area', 'autofocus' ),
		'id' => 'leaderboard-widget-area',
		'description' => __( 'Displays a widget area above the header to be used as ad space.', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 7, located below the header.
	register_sidebar( array(
		'name' => __( 'Intro Widget Area', 'autofocus' ),
		'id' => 'intro-widget-area',
		'description' => __( 'Displays a widget area below the header to be used as ad space.', 'autofocus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
/** Register sidebars by running autofocus_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'autofocus_widgets_init' );
