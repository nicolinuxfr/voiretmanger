<?php Header("Cache-Control: no-transform");?>

<!DOCTYPE html>
<head>

<meta charset="UTF-8">
<link rel="alternate" hreflang="fr" href="https://voiretmanger.fr" />
<meta name="apple-mobile-web-app-title" content="Voir et manger" />
<meta name="viewport" content="initial-scale=1">
<meta property="fb:pages" content="384298108368" />

<link href='https://voiretmanger.fr/wp-content/themes/voiretmanger/css/font.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" media="all" href="https://voiretmanger.fr/wp-content/themes/voiretmanger/style.css" />

<link rel="pingback" href="https://voiretmanger.fr/xmlrpc.php" />
<link rel="shortcut icon" href="https://voiretmanger.fr/favicon.ico" />

<?php if (is_single() ) { ?>
	<?php $featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id(), "full", true); ?>
	<link rel="preload" href="<?php echo $featuredImage[0]; ?>" as="image">
	<link rel="preload" href="https://voiretmanger.fr/wp-content/themes/voiretmanger/css/playfair-display-v10-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="https://voiretmanger.fr/wp-content/themes/voiretmanger/css/playfair-display-v10-latin-700italic.woff2" as="font" type="font/woff2" crossorigin>
<?php } ?>

<?php if (current_user_can( 'manage_options' )) { ?>
	<style>
		.single .post-header{height: calc(100vh - 1em);}
		.page .single .post-header{height:auto;}
	</style>
<?php } ?>
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

<?php wp_head(); ?>
</head>

<body>


<?php
	if ( ! is_single() ) { ?>
		<header class="header-site">
			<h1 class="site-title"><a href="https://voiretmanger.fr/" title="À voir et à manger" rel="home">À voir et à manger</a></h1>

	<?php } else { ?>
		<header class="header-post">
			<a href="https://voiretmanger.fr/" title="Retour à la page d'accueil" rel="home"><span class="dashicons dashicons-arrow-left-alt"></span></a>
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
				    <li class="nav-item"><a href="https://voiretmanger.fr/">Accueil</a></li>
				    <li class="nav-item"><a href="https://voiretmanger.fr/archives/">Archives</a></li>
				    <li class="nav-item"><a href="https://voiretmanger.fr/a-voir/">À voir</a></li>
				    <li class="nav-item"><a href="https://voiretmanger.fr/a-manger/">À manger</a></li>
				    <li class="nav-item"><a href="https://voiretmanger.fr/a-lire/">À lire</a></li>
				    <li class="nav-item"><a href="https://voiretmanger.fr/a-ecouter/">À écouter</a></li>
				    <li class="nav-item"><a href="https://voiretmanger.fr/a-propos/">À propos</a></li>
				</ul>
			</div>

		<hr />

			<?php get_search_form( "true" ); ?>
	</div>

 			</header><!-- #header -->

	<main <?php body_class(); ?> >