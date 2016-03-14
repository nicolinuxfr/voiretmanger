<?php
/**
 * The template for displaying 404 pages (Not Found).
 */


get_header(); ?>



	<div id="container" class="page">
		<div id="content" role="main">

				<article id="post-0" class="single error404">
					<header class="post-header page">
						<h2 class="post-title">Cette page n'existe pas</h2>
					</header>

					<section class="post-content">
						<p>Désolé, mais vous pouvez effectuer une nouvelle recherche dès maintenant !</p>
						
						<div class="recherche" id="recherche">
							<?php get_search_form( "true" ); ?>							
						</div>
					</section>
					
					
				</article>


	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>