<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 */
?>
	</div><!-- #main -->

	<footer role="contentinfo">


	


		<div id="colophon">

			<div id="site-info">© 2014 <a href="http://voiretmanger.fr" title="À voir et à manger"><strong>À voir et à manger</strong></a>. Tous droits réservés.</div><!-- #site-info -->
			

		</div><!-- #colophon -->
	</footer><!-- #footer -->

</div><!-- #wrapper -->

<script type='text/javascript' src='http://voiretmanger.fr/wp-content/themes/autofocus/js/jquery-1.11.1.min.js'></script>
<script type='text/javascript' src='http://voiretmanger.fr/wp-content/themes/autofocus/js/search.js'></script>


<?php if (is_single()) { ?>
	
	<script type='text/javascript'>var _merchantSettings=_merchantSettings || [];_merchantSettings.push(['AT', '11lwu9']);(function(){var autolink=document.createElement('script');autolink.type='text/javascript';autolink.async=true; autolink.src= ('https:' == document.location.protocol) ? 'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' : 'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(autolink, s);})();</script>

	
<?php } ?>


?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
