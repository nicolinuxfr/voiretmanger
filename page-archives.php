<?php

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					<div class="header">
					
					<div class="entry-image">
					<?php echo the_post_thumbnail('full'); ?>
					</div>

					
						<h3 class="entry-title" style="font-size: 7em;"><?php the_title(); ?></h3>
					</div>

					<div class="entry-content">

						<?php the_content(); ?>
						
						<div class="searchArchives">
							
						<li>
							<h3>Créateurs</h3>
							<div class="recherche">
									<form method="get" id="searchform"> 
									<input class="case" type="text" value="Recherche" placeholder="Recherche" id="createur" name="createur" onblur="if (this.value == '')  {this.value = 'Recherche';}"  onfocus="if (this.value == 'Recherche') {this.value = '';}" /> 
									  <input type="hidden" id="searchsubmit" /> 
									</form>
									<ul class="resultats createurs_results"></ul>		
							</div>
						</li>
						
						
						<li>					
						<h3>Acteurs</h3>
						<div class="recherche">
								<form method="get" id="searchform"> 
								<input class="case" type="text" value="Recherche" placeholder="Recherche" id="acteur" name="acteur" onblur="if (this.value == '')  {this.value = 'Recherche';}"  onfocus="if (this.value == 'Recherche') {this.value = '';}" /> 
								  <input type="hidden" id="searchsubmit" /> 
								</form>
								<ul id="searchPage" class="acteurs_results resultats"></ul>
								</div>				
							</li>	
							
							<li>	
								<h3>Année</h3>
								<div class="recherche">
										<form method="get" id="searchform"> 
										<input class="case" type="text" value="Recherche" placeholder="Recherche" id="annee" name="annee" onblur="if (this.value == '')  {this.value = 'Recherche';}"  onfocus="if (this.value == 'Recherche') {this.value = '';}" /> 
										  <input type="hidden" id="searchsubmit" /> 
										</form>
										<ul id="searchPage" class="annees_results resultats"></ul>
								</div>				
							</li>
							
							
							<li>
							<h3>Pays</h3>
							<div class="recherche">
									<form method="get" id="searchform"> 
									<input class="case" type="text" value="Recherche" placeholder="Recherche" id="pays" name="pays" onblur="if (this.value == '')  {this.value = 'Recherche';}"  onfocus="if (this.value == 'Recherche') {this.value = '';}" /> 
									  <input type="hidden" id="searchsubmit" /> 
									</form>
									<ul id="searchPage" class="pays_results resultats"></ul>
								</div>
						</li>
						
						</ul><!-- #searchArchives -->
						
						
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'autofocus' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'autofocus' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-## -->


<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
