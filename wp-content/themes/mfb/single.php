<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Maryland_Food_Bank
 */

get_header();
?>
	<?php //get_template_part('template-parts/page-header'); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="section section--padded">
				<div class="compartment">
					<div class="compartment--inner">
						<?php while(have_posts()): ?>
							<?php the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-item' ); ?>>
								<a class="post-item__back" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">Back to News</a>
								<?php the_title('<h1 class="post-item__title">', '</h1>'); ?>
								<div class="post-item__date"><?php echo get_the_date( '' ); ?></div>
								<?php if (has_post_thumbnail()): ?>
									<?php $img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); ?>
									<img class="post-item__img" src="<?php echo $img_url; ?>" alt="<?php esc_html (get_the_post_thumbnail_caption()); ?>" />
								<?php endif; ?>

								<?php the_content(); ?>

							</article><!-- #post-<?php the_ID(); ?> -->

							<?php //the_post_navigation(); ?>

							<?php if (comments_open() || get_comments_number()): ?>
								<?php comments_template(); ?>
							<?php endif; ?>

						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
