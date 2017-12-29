<?php get_header(); ?>

	<div id="container">
			<div id="content" role="main">
				<article id="post-<?php the_ID(); ?>" class="single">
					<header class="post-header page">
						<h2 class="page-title"><?php the_title(); ?></h2>
					</header>

					<section class="post-content archives">
					
					<?php
					global $wpdb;
					$limit = 0;
					$year_prev = null;
					$months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month ,	YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' GROUP BY month , year ORDER BY post_date DESC");
					foreach($months as $month) :
						$year_current = $month->year;
						if ($year_current != $year_prev){
							if ($year_prev != null){?>
		
							<?php } ?>
						</ul>
						<h3 class="archive-year"><a href="<?php bloginfo('url') ?>/<?php echo $month->year; ?>/"><?php echo $month->year; ?></a></h3><ul>
	
						<?php } ?>
						<li><a href="<?php bloginfo('url') ?>/<?php echo $month->year; ?>/<?php echo date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>/"><span class="archive-month"><?php echo ucfirst (date_i18n("F", mktime(0, 0, 0, $month->month, 1, $month->year))); ?> (<?php echo $month->post_count; ?>)</span></a></li>
					<?php $year_prev = $year_current;

					endforeach; ?>
					</ul>

					<hr />
					<h3 class="archive-year">Catégories</h3>
					<?php $args = array(
						'orderby'            => 'name',
						'order'              => 'ASC',
						'show_count'         => 1,
						'title_li'           => 0
					);
					wp_list_categories($args);
					?>
				
					</section>
				</article>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
