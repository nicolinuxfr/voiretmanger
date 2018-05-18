<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 */
?>
</main>

<?php if (is_search()) { ?>

<div class="algolia"><img src="https://voiretmanger.fr/wp-content/files/search-by-algolia.png" alt="" width="260" height="36" /></div>

<?php } ?>

<footer class="site-footer">	
	<section class="menu"><a href="https://voiretmanger.fr/archives/">ARCHIVES</a><a href="https://voiretmanger.fr/a-propos/">À PROPOS</a></section>
	
	<section class="copyright">Publié depuis 2008. <a href="https://voiretmanger.fr/mentions-legales/">Tous droits réservés</a>.</section>
</footer><!-- #footer -->

	<script type='text/javascript' src='//voiretmanger.fr/wp-content/themes/voiretmanger/js/search.js'></script>

<?php if (is_single()) { ?>

	<script type='text/javascript' src='//voiretmanger.fr/wp-content/themes/voiretmanger/js/bigfoot.min.js'></script>
		<link rel="stylesheet" media="all" href="//voiretmanger.fr/wp-content/themes/voiretmanger/css/bigfoot-default.css" />
	<script type="text/javascript">
		$ = jQuery.noConflict();
		$.bigfoot({actionOriginalFN: "ignore"});
	</script>
	
<?php } ?>


<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
