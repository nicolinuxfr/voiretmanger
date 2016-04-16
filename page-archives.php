<?php get_header(); ?>

	<div id="container">
			<div id="content" role="main">
				<article id="post-<?php the_ID(); ?>" class="single">
					<header class="post-header page">
						<h2 class="post-title"><?php the_title(); ?></h2>
					</header>

					<section class="post-content" style="max-width: 100%;">
						<ul class="searchArchives">
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
					</section>
				</article>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
