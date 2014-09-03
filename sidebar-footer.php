<?php
/**
 * The Footer widget areas.
 */
?>

<?php
	/* The footer widget area is triggered if any of the areas
	 * have widgets. So let's check that first.
	 *
	 * If none of the sidebars have widgets, then let's bail early.
	 */
	if (   ! is_active_sidebar( 'first-footer-widget-area'  )
		&& ! is_active_sidebar( 'second-footer-widget-area' )
		&& ! is_active_sidebar( 'third-footer-widget-area'  )
		&& ! is_active_sidebar( 'fourth-footer-widget-area' )
	)
		return;
	// If we get this far, we have widgets. Let do this.
?>

			<section id="footer-widget-area" role="complementary">

<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
				<aside id="first" class="widget-area">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
					</ul>
				</aside><!-- #first .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
				<aside id="second" class="widget-area">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
					</ul>
				</aside><!-- #second .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
				<aside id="third" class="widget-area">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
					</ul>
				</aside><!-- #third .widget-area -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
				<aside id="fourth" class="widget-area">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
					</ul>
				</aside><!-- #fourth .widget-area -->
<?php endif; ?>

			</section><!-- #footer-widget-area -->


<div id="wrapper" class="hfeed">

	<?php if (is_active_sidebar('leaderboard-widget-area')) { ?>

		<aside id="leaderboard-widget-area" class="widget-area" role="complementary">
			<ul class="xoxo">

<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( ! dynamic_sidebar( 'leaderboard-widget-area' ) ) : ?>

		<?php dynamic_sidebar( 'leaderboard-widget-area' ); ?>

<?php endif; // end primary widget area ?>

			</ul>
		</aside><!-- #leaderboard-widget-area .widget-area -->
			<?php } ?>
