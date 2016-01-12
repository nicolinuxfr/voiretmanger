<?php Header("Cache-Control: no-transform");?>

<!DOCTYPE html>
<head>

<meta charset="UTF-8">
<meta name="apple-mobile-web-app-title" content="Voir et manger" />
<meta name="viewport" content="initial-scale=1">

<link rel="stylesheet" media="all" href="//voiretmanger.fr/wp-content/themes/voiretmanger/style.css" />
<link href='//fonts.googleapis.com/css?family=Playfair+Display:400,700italic|Roboto:300,300italic,700|Dorsa' rel='stylesheet' type='text/css'>

<?php if (is_single()) { ?>	
<link href='//voiretmanger.fr/wp-content/themes/voiretmanger/css/font.css' rel='stylesheet' type='text/css'>
<?php } ?>

<link rel="pingback" href="//voiretmanger.fr/xmlrpc.php" />
<link rel="shortcut icon" href="//voiretmanger.fr/favicon.ico" />

<?php if (current_user_can( 'manage_options' )) { ?>
	<style>
		.single .post-header{height: calc(100vh - 1em);}
		.single .post-header .page{height:auto;}
	</style>
<?php } ?>

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

<body>
	
		
<?php
	if ( ! is_single() ) { ?>
		<header class="header-site">
			<h1 class="site-title"><a href="//voiretmanger.fr/" title="À voir et à manger" rel="home">À voir et à manger</a></h1>
			
	<?php } else { ?>
		<header class="header-post">
			<a href="http://voiretmanger.fr/" title="Retour à la page d'accueil" rel="home"><span class="dashicons dashicons-arrow-left-alt"></span></a>
	<?php } ?>
	
	
	
	<div class="recherche" id="recherche" onclick="document.getElementById('search').focus();">
		<input type="checkbox" id="op"></input>
	<div class="lower">
		<label id="rechercher" for="op"><span class="dashicons dashicons-search"></span></label>
	</div>

	<div class="overlay overlay-hugeinc">
		<label for="op"><span class="dashicons dashicons-no-alt"</span></label>
		
					<div class="menu" data-instant>
				<span class="dashicons dashicons-editor-justify"></span>
				<ul class="navigation">
				    <li class="nav-item"><a href="http://voiretmanger.fr/">Accueil</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/archives/">Archives</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-voir/">À voir</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-manger/">À manger</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-lire/">À lire</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-ecouter/">À écouter</a></li>
				    <li class="nav-item"><a href="http://voiretmanger.fr/a-propos/">À propos</a></li>
				</ul>
			</div>
		
		<hr />
			
			<?php get_search_form( "true" ); ?>	
	</div>

 			</header><!-- #header -->

	<main <?php body_class(); ?> >