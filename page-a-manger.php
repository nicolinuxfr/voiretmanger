<?php get_header(); ?>

<div id="container">
    <div id="content" role="main">
        <article id="post-<?php the_ID(); ?>" class="single">
            <header class="post-header page">
                <h2 class="page-title"><?php the_title(); ?></h2>
            </header>
            
            <section class="post-content">

            
            <?php echo do_shortcode('[googlemapsmashup query="post_type=post&cat=961&nopaging=true" map_type_id="roadmap" width=950 height=800 scrollwheel="false"]'); ?>


            <div class="js-toc"></div>
                
                <div class="azindex">
                    
                <?php 
                    $letter=' '; 
                    query_posts( array(
                        'post_type' => 'post',
                        'category_name' => 'restaurant',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby'     => 'name', 
                        'order'       => 'ASC',
                        'no_found_rows' => true, 
                        'update_post_term_cache' => false,
                        'update_post_meta_cache' => false
                    ) );
                    
                    if ( have_posts() ) : while ( have_posts() ) : the_post(); 

                    $slug=$post->post_name; 
                    $initial=strtoupper(substr($slug,0,1));
                    if (is_numeric($initial)) {
                        $initial="0-9";
                    }
                    
                    if($initial!=$letter)
                    {  ?>
                        </ul>
                        <h2 id="<?php echo $initial ?>"><?php echo $initial ?></h2>
                        <ul>
                            <?php $letter=$initial; } ?>

                            <li>
                                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><span class="head"><?php the_title(); ?></span></a>
                                <span class="desc"><?php the_excerpt(); ?></span>
                            </li>
                    <?php endwhile;  endif; wp_reset_query(); ?>
                    
                    </div> 
                    
                </section>
            </article>
            
        </div><!-- #content -->
    </div><!-- #container -->
    
    <?php get_footer(); ?>
