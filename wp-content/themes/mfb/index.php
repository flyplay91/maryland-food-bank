<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maryland_Food_Bank
 */
?>

<?php get_header(); ?>

<header class="content-header">
	<div class="compartment">
		<div class="compartment--inner">
			<h1>Blog
				<?php
						if (is_tag() or is_category()) :
							echo ' - <em>' . single_cat_title( '', false ) . '</em>';
						elseif ( is_day() ) :
							printf( '- <em>Daily Archives: %s', '<span>' . get_the_date() . '</span></em>' );
						elseif ( is_month() ) :
							printf( '- <em>Monthly Archives: %s', '<span>' . get_the_date('F Y') . '</span></em>' );
						elseif ( is_year() ) :
							printf( '- <em>Yearly Archives: %s', '<span>' . get_the_date( 'Y' ) . '</span></em>' );
						elseif ( is_author() ) :
							printf( '- <em>Author: %s', '<span>' . get_the_author() . '</span></em>' );
						else :
							// printf( '- <em>Archives</em>' );
						endif;
					?>
			</h1>
			<?php if (function_exists('yoast_breadcrumb')): ?>
				<?php yoast_breadcrumb('<div class="breadcrumbs">','</div>'); ?>
			<?php endif; ?>
		</div>
  </div>
</header>


<?php get_template_part('template-parts/featured-hero'); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<div class="section section--padded">
			<div class="compartment">
				<div class="compartment--inner">
					<?php //get_template_part( 'template-parts/filter-search' ); ?>

					<div class="posts-header">
						<h4>Search by Keyword</h4>
						<div class="post-header__search">
							<form role="search" method="get" class="search-form" action="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">
								<label>
									<span class="screen-reader-text">Search for:</span>
									<input class="search-field" placeholder="Search …" value="<?php the_search_query(); ?>" name="s" type="search">
								</label>
								<input class="search-submit" value="Search" type="submit">
							</form>
						</div>
						<div class="post-header__categories silc-accordion">
							<section class="silc-accordion__section">
								<header class="silc-accordion__header">
									<h2 class="silc-accordion__label">Browse by Category</h2>
								</header>
								<div class="silc-accordion__content">
									<ul>
										<?php wp_list_categories(array('orderby' => 'name', 'title_li' => '', 'depth' => 1, 'use_desc_for_title' => false, 'show_count' => false, 'exclude' => array(10))); ?>
									</ul>
								</div>
							</section>
						</div>
					</div>

					<?php if (have_posts()): ?>

						<?php if(false): ?>
							<?php if (is_home() && !is_front_page()): ?>
								<header>
									<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
								</header>
							<?php endif; ?>
						<?php endif; ?>

						<div class="posts-results">
							<?php while (have_posts()): ?>
								<?php the_post(); ?>
								<?php
									/*
									* Include the Post-Type-specific template for the content.
									* If you want to override this in a child theme, then include a file
									* called content-___.php (where ___ is the Post Type name) and that will be used instead.
									*/
								?>
								<?php get_template_part('template-parts/content', get_post_type()); ?>
							<?php endwhile; ?>
						</div>
						<div class="pagination-wrapper">
							<?php wp_pagenavi(); ?>
						</div>

					<?php else: ?>
						<?php get_template_part( 'template-parts/content', 'none' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div id="et-boc" class="et-boc">
			<div id="et_builder_outer_content" class="et_builder_outer_content">
				<div class="et_builder_inner_content et_pb_gutters3">
							<?php echo do_shortcode('[et_pb_section global_module="25551"][/et_pb_section]'); ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->


<?php get_footer(); ?>
