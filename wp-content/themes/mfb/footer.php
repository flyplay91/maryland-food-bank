<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Maryland_Food_Bank
 */

?>

		</div><!-- #content -->

		<?php if (false): ?>
		<div class="footer">
			<div class="section section--footer section--footer-tier1">
				<div class="row silc-grid">
					<div class="silc-grid__col silc-grid__col--6-medium silc-grid__col--3-large"><?php dynamic_sidebar( 'ft1-1' );?></div>
					<div class="silc-grid__col silc-grid__col--6-medium silc-grid__col--3-large"><?php dynamic_sidebar( 'ft1-2' );?></div>
					<div class="silc-grid__col silc-grid__col--6-medium silc-grid__col--3-large"><?php dynamic_sidebar( 'ft1-3' );?></div>
					<div class="silc-grid__col silc-grid__col--6-medium silc-grid__col--3-large"><?php dynamic_sidebar( 'ft1-4' );?></div>
				</div>
			</div>
			<div class="section section--footer section--footer-tier2">
				<div class="row silc-grid">
					<div class="silc-grid__col silc-grid__col--6-medium silc-grid__col--3-large"><?php dynamic_sidebar( 'ft2-1' );?></div>
					<div class="silc-grid__col silc-grid__col--6-medium silc-grid__col--3-large"><?php dynamic_sidebar( 'ft2-2' );?></div>
					<div class="silc-grid__col silc-grid__col--6-medium silc-grid__col--3-large"><?php dynamic_sidebar( 'ft2-3' );?></div>
				</div>
			</div>
			<div class="section section--footer section--footer-tier3">
				<div class="row silc-grid">
					<div class="silc-grid__col silc-grid__col--12-large"><?php dynamic_sidebar( 'ft3' );?></div>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="footer">
			<div class="section section--footer section--footer-tier1">
				<div class="compartment">
					<div class="compartment--inner">
						<div class="silc-grid">
							<div class="silc-grid__col silc-grid__col--6-600 silc-grid__col--3-800 silc-align--center silc-align--left-800">

								<!-- Start Divi -->
								<div class="widget widget_text">
									<div class="textwidget">
										<a href="<?php echo home_url( '/' ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/_silc/build/img/logo--white.svg" alt="Maryland Food Bank"></a>
										<?php dynamic_sidebar( 'ft1-1' );?>
									</div>
								</div>
								<!-- End Divi -->

							</div>
							<div class="silc-grid__col silc-grid__col--6-600 silc-grid__col--3-800 silc-display--none silc-display--flex-800">
								<?php dynamic_sidebar( 'ft1-2' );?>
							</div>
							<div class="silc-grid__col silc-grid__col--6-600 silc-grid__col--3-800 silc-display--none silc-display--flex-800">
								<?php dynamic_sidebar( 'ft1-3' );?>
							</div>
							<div class="silc-grid__col silc-grid__col--6-600 silc-grid__col--3-800 silc-display--none silc-display--flex-800">
								<?php dynamic_sidebar( 'ft1-4' );?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="section section--footer section--footer-tier2">
				<div class="compartment">
					<div class="compartment--inner">
						<div class="silc-grid">
							<div class="silc-grid__col silc-grid__col--6-600 silc-grid__col--3-800">
								<?php dynamic_sidebar( 'ft2-1' );?>
							</div>
							<div class="silc-grid__col silc-grid__col--6-600 silc-grid__col--5-800">
								<?php dynamic_sidebar( 'ft2-2' );?>
							</div>
							<div class="silc-grid__col silc-grid__col--6-600 silc-grid__col--4-800">
								<?php dynamic_sidebar( 'ft2-3' );?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="section section--footer section--footer-tier3">
				<div class="compartment">
					<div class="compartment--inner">
						<div class="silc-grid">
							<div class="silc-grid__col silc-grid__col--12-800">
								<?php dynamic_sidebar( 'ft3' );?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="global--buttons"><a href="<?php echo get_permalink(get_page_by_path('find-food')); ?>">Find Food</a><a href="<?php echo get_permalink(get_page_by_path('donate')); ?>">Donate</a></div>

		<div class="silc-offcanvas main-menu__offcanvas" id="silc-offcanvas-1">
			<div class="offc-navs-container">
			<nav class="silc-nav main-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'primary-navigation', 'container' => 'ul' ) ); ?>
			</nav>
			<?php wp_nav_menu( array( 'theme_location' => 'utility-navigation', 'container' => 'ul', 'menu_class' => 'utility-menu' ) ); ?>
			</div>
			<a href="<?php echo get_permalink(get_page_by_path('donate')); ?>" class="donate-button">Donate</a>
		</div>


	</div><!-- #page -->
	<?php wp_footer(); ?>
</body>
</html>
