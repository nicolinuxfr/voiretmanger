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

	<script type='text/javascript' src='https://voiretmanger.fr/wp-content/themes/voiretmanger/js/search.js'></script>

<?php if (is_single()) { 
	$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id(), "full", true); ?>
	<script type='text/javascript' src='https://voiretmanger.fr/wp-content/themes/voiretmanger/js/color-thief.umd.js'></script>

	<script>
		var imageUrl = "<?php echo $featuredImage[0]; ?>";
		var image = new Image(360, 360);

		image.onload = function(){
   		 	// Récupération de deux couleurs à partir de l'image
    		var colorThief = new ColorThief();          
    		var color = colorThief.getPalette(image, 2);
			
			// comparaison des deux couleurs pour connaître la plus foncée (algorithme via https://stackoverflow.com/a/3732007)
			var color1 = color[0][0] * 2 + color[0][1] * 3 + color[0][2]
			var color2 = color[1][0] * 2 + color[1][1] * 3 + color[1][2]
			
			// création des couleurs CSS en fonction du résultat
			if (color1 > color2)
				{
					var colorStandard = "rgb(" + color[1][0] + "," + color[1][1] + "," + color[1][2] + ")"
					var colorDark = "rgb(" + color[0][0] + "," + color[0][1] + "," + color[0][2] + ")"
				}
			else
				{
					var colorStandard = "rgb(" + color[0][0] + "," + color[0][1] + "," + color[0][2] + ")"
					var colorDark = "rgb(" + color[1][0] + "," + color[1][1] + "," + color[1][2] + ")"
				}
			
			// changement des styles
			// article .post-content a:hover, .post-meta ul a:hover, .post-meta .resto a:hover, .post-meta ul strong {color:  rgb(227,200,179);}
			//.partage ul li, .partage h4 {background-color: rgb(227,200,179);}
			
			var style = document.createElement('style');
			style.innerHTML = '.partage ul li, .partage h4 {background-color:' + colorStandard + ';}' +
				'article .post-content a:hover, .post-meta ul a:hover, .post-meta .resto a:hover, .post-meta ul strong {color: ' + colorStandard + ';}' + '.partage a {color:' + colorDark + ';}' +
				' @media (prefers-color-scheme: dark){' +
					'.partage ul li, .partage h4 {background-color:' + colorDark + ';}' +
					'article .post-content a:hover, .post-meta ul a:hover, .post-meta .resto a:hover, .post-meta ul strong {color: ' + colorDark + ';}' + '.partage a {color:' + colorStandard + ';}'
				'}';
			
			document.getElementsByTagName("head")[0].appendChild( style );

			};
		image.src = imageUrl;

	</script>


	<script type="application/javascript" src="https://voiretmanger.fr/wp-content/themes/voiretmanger/js/bigfoot.min.js"></script>
	<link rel="stylesheet" media="all" href="https://voiretmanger.fr/wp-content/themes/voiretmanger/css/bigfoot-default.css" />
	<script type="application/javascript">
		$ = jQuery.noConflict();
		$.bigfoot({actionOriginalFN: "ignore"});
	</script>
	
<?php } 
	
	if ( is_page( array('a-voir', 'a-ecouter', 'a-lire', 'a-manger' ) ) ) {
		wp_enqueue_script( 'tocbot', get_template_directory_uri() . '/js/tocbot.min.js', false, '4.3.1', true);
	?> 

	<script type="application/javascript">
		$(document).ready(function(){
			tocbot.init({
			// Where to render the table of contents.
			tocSelector: '.js-toc',
			// Where to grab the headings to build the table of contents.
			contentSelector: '.azindex',
			// Which headings to grab inside of the contentSelector element.
			headingSelector: 'h2',
			// For headings inside relative or absolute positioned containers within content.
			hasInnerContainers: true,
			});
		}); 
	</script>


	<?php }	?>




<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
