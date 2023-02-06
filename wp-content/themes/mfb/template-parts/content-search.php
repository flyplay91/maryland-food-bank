<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maryland_Food_Bank
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-result' ); ?>>
		<header class="post-result__header">
			<!-- <div class="post-result__date"><?php echo get_the_date( '' ); ?></div> -->
			<?php if (is_singular()): ?>
				<?php the_title('<h2 class="post-result__title">', '</h2>'); ?>
			<?php else: ?>
				<?php the_title( '<h2 class="post-result__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="post-result__content">
			<?php
			the_excerpt();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mfb' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

		<footer class="post-result__footer">
			<a class="post-result__button" href="<?php the_permalink(); ?> ">Read More</a>
			<?php // mfb_entry_footer(); ?>
		</footer><!-- .entry-footer -->

	</article><!-- #post-<?php the_ID(); ?> -->
