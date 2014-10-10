<?php
	if ( is_home() ) {
		$nomPage = "À voir et à manger (Chez Nicoflo)";
		$iMage = "http://voiretmanger.fr/blog.png";
		$extrait = "À voir et à manger (Chez Nicoflo)";
	
	} else {
	global $page, $paged;

	$nomPage = wp_title( '|', false, 'right' );

	// Add the blog name.
	$nomPage = $nomPage . get_bloginfo( 'name' );

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$nomPage = ' | ' . sprintf( __( 'Page %s', 'autofocus' ), max( $paged, $page ) );

	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full-post-thumbnail' );
	$iMage = $thumb[0];

	if ( is_single() ){
		$extrait = strip_tags(htmlentities(get_the_excerpt(), ENT_QUOTES, 'UTF-8'));
		$extrait = substr($extrait, 0, strrpos($extrait, '&lt;a'));
	}

	}
?>

<!-- Début du header proprement dit -->

<!DOCTYPE html>
<head>

<meta charset="UTF-8">
<meta name="apple-mobile-web-app-title" content="Nicolinux" />
<meta name="viewport" content="width=950, maximum-scale=1" />

<meta name="description" content="<?php echo substr($extrait, 0, 160); ?>" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@nicolinuxfr" />
<meta name="twitter:title" content="<?php echo substr($nomPage, 0, strrpos($nomPage, '|')); ?>" />
<meta name="twitter:url" content="<?php echo home_url( $wp->request ); ?>" />
<meta name="twitter:image:src" content="<?php echo $iMage; ?>" />
<meta name="twitter:description" content="<?php echo $extrait; ?>" />

<meta name="og:title" content="<?php echo substr($nomPage, 0, strrpos($nomPage, '|')); ?>" />
<meta name="og:url" content="<?php echo home_url( $wp->request ); ?>" />
<meta property="og:image" content="<?php echo $iMage; ?>" />
<meta property="og:description" content="<?php echo $extrait; ?>" />

<link rel="image_src" href="<?php echo $iMage; ?>" />
<link rel="stylesheet" media="all" href="http://voiretmanger.fr/wp-content/themes/voiretmanger/style.css" />
<link rel="pingback" href="http://voiretmanger.fr/xmlrpc.php" />
<link rel="shortcut icon" href="http://voiretmanger.fr/favicon.ico" />

<title><?php echo $nomPage; ?></title>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "url": "https://voiretmanger.fr/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://voiretmanger.fr?s={search_term}",
    "query-input": "required name=search_term"
  }
}
</script>

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
	
	
?>


</head>

<body <?php body_class(); ?>>


<div id="wrapper" class="hfeed">
	<header class="header">
		<section id="masthead">
			<div id="branding" role="banner">		
    <h1 id="site-title"><a href="http://voiretmanger.fr/" title="À voir et à manger" rel="home">À voir et à manger</a>  </h1>
	<h2 id="site-description">Chez Nicoflo</h2>
			</div>
</section><!-- #masthead -->

<div class="menu" id="menu">

	<nav id="access" role="navigation">
    	<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
	</nav>


<div class="recherche">
		<form method="get" id="searchform"  action="<?php bloginfo('home'); ?>/"> 
		<input class="case" type="text" value="Chercher" placeholder="Chercher" id="s" name="s" onblur="if (this.value == '')  {this.value = 'Chercher';}"  onfocus="if (this.value == 'Chercher') {this.value = '';}" /> 
		  <input type="hidden" id="searchsubmit" /> 
		</form>
		<ul id="searchPage" class="search_results">
  
		</ul>
	</div>


 			</header><!-- #header -->

	<div id="main">
