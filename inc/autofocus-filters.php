<?php
/**
 * AutoFocus Filters 
 *
 * Filters some of the defualt WordPress functions.
 *
*/

/**
 * Adds a 'singular' class to the array of body classes.
 */
function af_body_classes( $classes ) {
	if ( is_singular() && ! is_home() && ! is_page_template( 'blog-page.php' ) )
		$classes[] = 'singular';
	if ( is_search() )
		$classes[] = 'archive';
	return $classes;
}
add_filter( 'body_class', 'af_body_classes' );

/**
 *	Adds the 'autofocus' class to the BODY for AF animation and displays
 *	Uses these classes to display the Grid and Staggered layouts
 */


/**
 *	Adds post count and sticky classes to post_class
 */
function af_post_classes($classes) {
	global $post, $af_post_alt;

	if ( is_sticky($post->ID) && is_single($post->ID) )
		$classes[] = 'sticky';

	$af_post_alt++;

	// Adds a post number (p1, p2, etc) to the .hentry DIVs
	$classes[] = 'p' . $af_post_alt;
	return $classes;
}
add_filter('post_class', 'af_post_classes');

// Define the num val for 'alt' classes (in post DIV and comment LI)
$af_post_alt = 0;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 */
function autofocus_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'autofocus_page_menu_args' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 */
function autofocus_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( '<span class="liresuite">lire la suite</span> <span class="meta-nav">&rarr;</span>', 'autofocus' ) . '</a>';
}

?>