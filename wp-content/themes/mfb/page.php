<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maryland_Food_Bank
 */

get_header();
?>
	<?php if(!is_front_page()): ?>
		<?php get_template_part('template-parts/page-header'); ?>
	<?php endif; ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php while ( have_posts()): ?>
				<?php the_post(); ?>
				<?php get_template_part('template-parts/content', 'page'); ?>
				<?php if (comments_open() || get_comments_number()): ?>
					<?php comments_template(); ?>
				<?php endif; ?>

			<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
