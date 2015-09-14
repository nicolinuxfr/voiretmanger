<?php Header("Cache-Control: no-transform");?>

<!DOCTYPE html>
<head>

<meta charset="UTF-8">
<meta name="apple-mobile-web-app-title" content="Voir et manger" />
<meta name="viewport" content="initial-scale=1">

<link rel="stylesheet" media="all" href="http://voiretmanger.fr/wp-content/themes/voiretmanger/style.css" />
<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700italic|Roboto:300,300italic,700|Dorsa' rel='stylesheet' type='text/css'>	

<link rel="pingback" href="http://voiretmanger.fr/xmlrpc.php" />
<link rel="shortcut icon" href="http://voiretmanger.fr/favicon.ico" />

<?php wp_head(); ?>	
		
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
	
	<?php } ?>


</head>

<body data-no-instant>
	
		
<?php
	if ( ! is_single() ) { ?>
		<header class="header-site" data-instant>
			<h1 class="site-title"><a href="http://voiretmanger.fr/" title="À voir et à manger" rel="home">À voir et à manger</a></h1>
			
	<?php } else { ?>
		<header class="header-post" data-instant>
			<a href="http://voiretmanger.fr/" title="Retour à la page d'accueil" rel="home"><span class="dashicons dashicons-arrow-left-alt"></span></a>
	<?php } ?>
	
	
	
	<div class="recherche" id="recherche" onclick="document.getElementsByTagName('body')[0].className='scroll';">
		<input type="checkbox" id="op"></input>
	<div class="lower">
		<label id="rechercher" for="op"><span class="dashicons dashicons-search"></span></label>
	</div>

	<div class="overlay overlay-hugeinc">
		<label for="op" onclick="$('body').removeClass('noscroll');"><span class="dashicons dashicons-no-alt"</span></label>
		
			<?php get_search_form( "true" ); ?>
							
			<hr />
			<div class="menu" data-instant>
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

	<main <?php body_class(); ?> data-instant>