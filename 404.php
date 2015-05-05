<?php
/**
 * The template for displaying 404 pages (Not Found).
 */


get_header(); ?>

	<div id="container" class="normal-layout">
		<div id="content" role="main">

			<article id="post-0" class="post single error404 not-found">
				<h1 class="page-title">Oups, cette page n'existe pas</h1>
				<div class="entry-content">
					<p>Désolé, mais vous pouvez effectuer une nouvelle recherche dès maintenant !</p>

				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #container -->

	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>