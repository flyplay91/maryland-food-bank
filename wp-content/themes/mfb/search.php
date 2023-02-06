<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Maryland_Food_Bank
 */

get_header();
?>

<header class="content-header">
	<div class="compartment">
		<div class="compartment--inner">
			<h1>Search</h1>
			<?php if (function_exists('yoast_breadcrumb')): ?>
				<?php yoast_breadcrumb('<div class="breadcrumbs">','</div>'); ?>
			<?php endif; ?>
		</div>
  </div>
</header>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<div class="section section--padded">
			<div class="compartment">
				<div class="compartment--inner">

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
								<?php get_template_part('template-parts/content', 'search'); ?>
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
					<?php echo do_shortcode('[et_pb_section global_module="23271"][/et_pb_section]'); ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
