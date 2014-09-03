<?php

/** 
 * Add Favicon
 */
function af_favicon() {
	global $shortname;
	if (of_get_option( $shortname . '_custom_favicon') != '') {
        echo '<link rel="shortcut icon" href="' . of_get_option($shortname . '_custom_favicon')  . '"/>'."\n";
    }
	else { ?>
		<link rel="shortcut icon" href="<?php echo bloginfo('template_directory') ?>/images/favicon.ico" />
<?php }
}
add_action('wp_head', 'af_favicon');

/** 
 * Add a Custom Logo
 */
function af_branding() {
	global $shortname;
	$the_logo = of_get_option( $shortname . '_logo');
    $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';?>

    <<?php echo $heading_tag; ?> id="site-title">
    
    <?php if ( of_get_option( $shortname . '_logo') != '' ) : ?>
    
		<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
    		<img src="<?php echo $the_logo; ?>" alt="<?php bloginfo('name'); ?>"/>
		</a>
	    </<?php echo $heading_tag; ?>>
    
	<?php else : ?>

		<span>
			<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</span>
	    </<?php echo $heading_tag; ?>>

	<?php endif;

}

/** 
 * Footer text 
 */
function af_display_footer_text() {
	global $shortname;
	$text = of_get_option($shortname . '_footer_text');
	$showtext = stripslashes($text);
	echo $showtext;
}
