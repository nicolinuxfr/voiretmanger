<?php get_header(); ?>

		<div id="container" class="<?php af_layout_class(); ?>">
			<div id="content" role="main">


		<header>
			<h1 class="page-title"><span>À voir</span></h1>
		</header>


		<div class="page-cinema">Dans les salles en ce moment</div>

		<!-- #sorties de la semaine -->		

<?php
			$sticky = get_option( 'sticky_posts' );
			rsort( $sticky );
			$sticky = array_slice( $sticky, 0, 5 );
			$argsticky = array( 'post__in' => $sticky, 'caller_get_posts' => 1  );

			if ( $sticky ) { ?>

	 <div class="sorties">
      <div class="titre">Sorties de la semaine</div>
	
	 <ul>
		<?php
			query_posts( $argsticky );
			
			if (have_posts() ) { while ( have_posts() ) : the_post(); ?>
       
			<li class="sortie"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('archive-thumbnail'); ?></a></li>
     	
	 <?php endwhile;
     } 
     }
     ?>
     </ul>
		 </div>		


		<div class="page-cinema">Les dernières critiques</div>


<?php
		rewind_posts();
			
			
		if ( have_posts() )
		the_post();
	
		get_template_part( 'content', 'index' );
?>


			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
