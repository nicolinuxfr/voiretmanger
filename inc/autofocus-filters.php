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
function af_layout_class($class = '') {
	global $posts, $shortname;
	$home_layout = of_get_option($shortname . '_home_layout');
	$archive_layout = of_get_option($shortname . '_archive_layout');

	// Create classes array
	$af_classes = array();
	
	// Which layout is being used?
	if ( $archive_layout == 'default' && ( is_archive() || is_search() ) ) {
		$af_classes[] = 'normal-layout';
	} else {
		$af_classes[] = 'af-layout';
	}
	
	if ( ( is_home() && $home_layout == 'default' ) )
		$af_classes[] = 'af-default';
	elseif ( ( is_home() && $home_layout == 'grid' ) ) 
		$af_classes[] = 'af-grid';

	if ( $home_layout == 'default' && $archive_layout == 'images' && ( is_archive() || is_search() ) ) 
		$af_classes[] = 'af-default';
	elseif ( $home_layout == 'grid' && $archive_layout == 'images' && ( is_archive() || is_search() ) )	
		$af_classes[] = 'af-grid';

	// Output classes
	$class_str = implode( ' ', $af_classes );
	echo $class_str;
}

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
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function autofocus_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'autofocus_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 */
function autofocus_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( '<span class="liresuite">lire la suite</span> <span class="meta-nav">&rarr;</span>', 'autofocus' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and autofocus_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 */
function autofocus_auto_excerpt_more( $more ) {
	return ' &hellip;' . autofocus_continue_reading_link();
}
add_filter( 'excerpt_more', 'autofocus_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function autofocus_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= autofocus_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'autofocus_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 * Galleries are styled by the theme in AutoFocus’s style.css.
 */
function autofocus_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'autofocus_remove_gallery_css' );

/**
 * Filter the default gallery display to include rel=fancybox-ID
 * Source: http://wordpress.org/support/topic/add-relxyz-to-gallery-link
 */
function add_fancy_box_rel($content) {
	global $post, $shortname;

	if ( is_single() && ( of_get_option($shortname . '_fancybox' ) == TRUE ) ) {
		$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 rel="fancybox-'.$post->ID.'"$6>$7</a>';
		$content = preg_replace($pattern, $replacement, $content);
	}

	return $content;
}
add_filter('the_content', 'add_fancy_box_rel', 12);
add_filter('get_comment_text', 'add_fancy_box_rel');

/**
 * Customise the AutoFocus Two comments fields with HTML5 form elements
 *
 *	Adds support for 	placeholder
 *						required
 *						type="email"
 *						type="url"
 *
 */
function autofocus_comments() {
	global $commenter, $aria_req;
	
	$req = get_option('require_name_email');

	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder = "First and/or last name"' . ( $req ? ' required' : '' ) . '/></p>',
		            
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="xxxxx@xxxxxxxxx.com"' . ( $req ? ' required' : '' ) . ' /></p>',
		            
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
		            '<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="http://www.xxxxxxx.com" /></p>'

	);
	return $fields;
}


function autofocus_commentfield() {	
	$commentArea = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required placeholder="What\'s on your mind?"	></textarea></p>';
	return $commentArea;
}
add_filter('comment_form_default_fields', 'autofocus_comments');
add_filter('comment_form_field_comment', 'autofocus_commentfield');

?>