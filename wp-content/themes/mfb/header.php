<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Maryland_Food_Bank
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicons/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="Maryland Food Bank"/>
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri(); ?>/favicons/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="<?php echo get_stylesheet_directory_uri(); ?>/favicons/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo get_stylesheet_directory_uri(); ?>/favicons/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo get_stylesheet_directory_uri(); ?>/favicons/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo get_stylesheet_directory_uri(); ?>/favicons/mstile-310x310.png" />

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M7K2TF" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<!-- Google Analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-26451278-1', 'auto');

	  ga( 'require', 'ecommerce', 'ecommerce.js' );


	  ga('send', 'pageview');

	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link visible-for-screen-readers" href="#content"><?php esc_html_e( 'skip to main content', 'mfb' ); ?></a>

	<div class="header">
		<div class="header__utility">
			<?php wp_nav_menu( array( 'theme_location' => 'utility-navigation', 'container' => 'ul', 'menu_class' => 'utility-menu' ) ); ?>
			<div id="mainSearch" class="main-search">
				<form action="<?php echo home_url( '/' ); ?>" class="main-search__form">
					<label for="mainSearchInput" class="visible-for-screen-readers">Search this Site</label>
					<input type="text" class="main-search__input" id="mainSearchInput" placeholder="search" name="s">
					<button type="submit" class="main-search__submit"><span class="visible-for-screen-readers">Submit</span></button>
				</form>
				<a class="silc-offcanvas__trigger" href="#mainSearch"><span class="visible-for-screen-readers">Toggle Search</span></a>
			</div>

		</div>
		<div class="compartment">
			<div class="compartment--inner">
				<div class="header__main">

					<div class="header__logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/_silc/build/img/logo.svg" alt="Maryland Food Bank"></a>
					</div>
					<div class="header__nav">
						<nav class="silc-nav main-menu">
							<?php wp_nav_menu( array( 'theme_location' => 'primary-navigation', 'container' => 'ul' ) ); ?>
						</nav>
					</div>
					<div class="header__donate">
						<nav class="silc-nav">
							<?php wp_nav_menu( array( 'theme_location' => 'donate-navigation', 'container' => 'ul', 'menu_class' => 'donate-menu' ) ); ?>
						</nav>
					</div>
					<div class="header__triggers">
						<a class="silc-offcanvas__trigger main-search__trigger" href="#mainSearch"><span class="visible-for-screen-readers">Open Search</span></a>
						<a class="silc-offcanvas__trigger main-menu__trigger" href="#silc-offcanvas-1"><span class="visible-for-screen-readers">Open Menu</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="content" class="site-content layout-content">
