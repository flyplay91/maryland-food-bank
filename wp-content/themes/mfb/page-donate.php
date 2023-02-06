<?php
/*
Template Name: Donate
*/

// get_header('donate');
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
		<?php while ( have_posts()): ?>
		<div class="header header--donate">
			<div class="compartment">
				<div class="compartment--inner">
					<div class="header__main">
						<div class="header__logo">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/_silc/build/img/logo.svg" alt="Maryland Food Bank"></a>
						</div>
						<?php the_title( '<div class="header__title">', '</div>' ); ?>
					</div>
				</div>
			</div>
		</div>

		<div id="content" class="site-content layout-content">

			<?php the_post(); ?>

			<div id="primary" class="content-area">
				<main id="main" class="site-main">
				<?php if(true): ?>
					<header class="content-header">
						<div class="compartment">
							<div class="compartment--inner">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
								<?php if (function_exists('yoast_breadcrumb')): ?>
								<?php endif; ?>
							</div>
						</div>
					</header>
				<?php endif; ?>
				<?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); ?>
				<div class="section section--padded section--donation-wrapper" style="background-image: url('<?php echo $featured_img_url ?>');">
					<div class="compartment">
						<div class="compartment--inner">
							<div class="donation-content">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
					<div class="donation-image" style="background-image: url('<?php echo $featured_img_url ?>');">
						<img src="<?php echo $featured_img_url; ?>" />
					</div>

				</div>
				</main><!-- #main -->
			</div><!-- #primary -->

			<div class="footer">
				<div class="section section--footer section--footer-tier1">
					<div class="compartment">
						<div class="compartment--inner">
							<div class="row silc-grid">
								<div class="silc-grid__col silc-grid__col--6-800">

									<!-- Start Divi -->
									<div class="widget widget_text">
										<div class="textwidget">
											<a href="<?php echo home_url( '/' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/_silc/build/img/logo--white.svg" alt="Maryland Food Bank"></a>
										</div>
									</div>
									<!-- End Divi -->

								</div>
								<div class="silc-grid__col silc-grid__col--6-800 silc-align--center silc-align--right-800">
									<?php dynamic_sidebar( 'ft2-3' );?>
								</div>

							</div>
						</div>
					</div>
				</div>

				<div class="section section--footer section--footer-tier3">
					<div class="compartment">
						<div class="compartment--inner">
							<div class="row silc-grid">
								<div class="silc-grid__col silc-grid__col--12-800">
									<?php dynamic_sidebar( 'ft3' );?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div><!-- #content -->
	</div><!-- #page -->
	<?php endwhile; ?>
	<?php wp_footer(); ?>
</body>
</html>

