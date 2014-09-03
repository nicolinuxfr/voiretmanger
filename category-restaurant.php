<?php get_header(); ?>

		<div id="container" class="<?php af_layout_class(); ?>">
			<div id="content" role="main">

<?php
		if ( have_posts() )
		the_post();
?>
		<header>

<?php		
		if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
    pronamic_google_maps_mashup(
        array(
            'post_type' => 'post'
        ),
        array(
            'width'          => '100%',
            'height'         => 600,
            'map_type_id'    => 'roadmap',
            'nopaging'       => true,
            'map_options' => array(
				'navigationControl' => false,
				'scrollwheel' => false,
				'mapTypeControl' => false,
				'scrollwheel' => false
            )
        )
    );
}
?>	<br />
			<h1 class="page-title"><span>À manger</span></h1>
		</header>

<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	$archive_layout = of_get_option($shortname . '_archive_layout');

	/* Run the loop for the archives page to output the posts. */
	if ($archive_layout == 'images')
		get_template_part( 'content', 'autofocus' );

	else 
		get_template_part( 'content', 'index' );

?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
