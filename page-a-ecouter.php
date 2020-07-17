<?php get_header(); ?>

<div id="container">
    <div id="content" role="main">
        <article id="post-<?php the_ID(); ?>" class="single">
            <header class="post-header page">
                <h2 class="page-title"><?php the_title(); ?></h2>
            </header>
            
            <section class="post-content">

            <div class="js-toc"></div>
                
                <div class="azindex">
                    
                <?php 
                    $letter=' '; 
                    query_posts( array(
                        'post_type' => 'post',
                        'category_name' => 'musique',
                        'tag__not_in' => array(291), // pas de top
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
                                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Lien direct vers %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                            </li>
                    <?php endwhile;  endif; wp_reset_query(); ?>
                    
                    </div> 
                    
                </section>
            </article>
            
        </div><!-- #content -->
    </div><!-- #container -->
    
    <?php get_footer(); ?>
