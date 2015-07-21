<?php Header("Cache-Control: no-transform");?>

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
		$post_object = get_post( $post->ID );
		$content = $post_object->post_content;
		$extrait = wp_trim_words( $content, $num_words = 55, $more = null );
	}

	}
?>

<!-- Début du header proprement dit -->

<!DOCTYPE html>
<head>

<meta charset="UTF-8">
<meta name="apple-mobile-web-app-title" content="Voir et manger" />
<meta name="viewport" content="initial-scale=1">

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
<link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700,400italic,700italic|Playfair+Display:400,700italic|Roboto:300,300italic,700|Dorsa' rel='stylesheet' type='text/css'>

 
<link rel="pingback" href="http://voiretmanger.fr/xmlrpc.php" />
<link rel="shortcut icon" href="http://voiretmanger.fr/favicon.ico" />

<title><?php echo $nomPage; ?></title>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "url": "http://voiretmanger.fr/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://voiretmanger.fr?s={search_term}",
    "query-input": "required name=search_term"
  }
}
</script>

<?php

	wp_head();

	if (is_single()) { ?>
		<script type='text/javascript' src='http://voiretmanger.fr/wp-content/themes/voiretmanger/js/bigfoot.min.js'></script>
		<link rel="stylesheet" media="all" href="http://voiretmanger.fr/wp-content/themes/voiretmanger/css/bigfoot-default.css" />
	
		<script type="text/javascript">
		$ = jQuery.noConflict();
		$.bigfoot({actionOriginalFN: "ignore"});
		</script>
		
		<?php if( get_post_meta($post->ID, 'contraste', true) ) { ?> 
			<style>
				.header-post #rechercher, 
				.header-post a{
					color: rgba(35, 35, 35, 0.7);
				}
				.header-post a:hover,
				.header-post #rechercher:hover{
					color:black;
				}
			</style>
	
	<?php } } 


	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
?>


</head>

<body>
	
		
<?php
	if ( ! is_single() ) { ?>
		<header class="header-site">
			<h1 class="site-title"><a href="http://voiretmanger.fr/" title="À voir et à manger" rel="home">À voir et à manger</a></h1>
			
	<?php } else { ?>
		<header class="header-post">
			<a href="http://voiretmanger.fr/" title="Retour à la page d'accueil" rel="home"><span class="dashicons dashicons-arrow-left-alt"></span></a>
	<?php } ?>
	
	
	
	<div class="recherche" id="recherche" onclick="document.getElementsByTagName('body')[0].className='scroll';">
		<input type="checkbox" id="op"></input>
	<div class="lower">
		<label id="rechercher" for="op"><span class="dashicons dashicons-search"></span></label>
	</div>

	<div class="overlay overlay-hugeinc">
		<label for="op" onclick="$('body').removeClass('noscroll');"><span class="dashicons dashicons-no-alt"</span></label>
		
			<form method="get" id="searchform"  action="<?php bloginfo('home'); ?>/"> 
				<input class="case" type="text" autofocus value="Chercher" placeholder="Chercher" id="search" name="s" onblur="if (this.value == '')  {this.value = 'Chercher';}"  onfocus="if (this.value == 'Chercher') {this.value = '';}" /> 
				<input type="hidden" id="searchsubmit" /> 
			</form>
				
			<nav>
				<ul id="results"></ul>
			</nav>
			
			<hr />
			<div class="menu">
				<span class="dashicons dashicons-editor-justify"></span>
				<ul class="navigation">
				    <li class="nav-item"><a href="http://voiretmanger.fr/">Accueil</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/archives/" data-no-instant>Archives</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-voir/">À voir</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-manger/">À manger</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-lire/">À lire</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-ecouter/">À écouter</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-propos/">À propos</a></li>
				</ul>
			</div>
			
	</div>

 			</header><!-- #header -->

	<main <?php body_class(); ?>>