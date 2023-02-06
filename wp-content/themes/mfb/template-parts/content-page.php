<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maryland_Food_Bank
 */

?>

<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-result' ); ?>>
		<div class="silc-grid">
			<?php if (has_post_thumbnail()): ?>
			<div class="silc-grid__col silc-grid__col--4-800">
				<?php $img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); ?>
				<a href="<?php the_permalink(); ?>" class="post-result__image">
					<div class="post-result__bg" style="background-image: url('<?php echo $img_url; ?>');">
					</div>
					<img class="post-result__img" src="<?php echo $img_url; ?>" alt="<?php esc_html (get_the_post_thumbnail_caption()); ?>" />
				</a>
			</div>
			<?php endif; ?>

			<div class="silc-grid__col silc-grid__col--<?php if (has_post_thumbnail()): ?>8<?php else: ?>12<?php endif; ?>-800">

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
			</div>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->

<?php else: ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php	wp_link_pages(array('before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mfb' ), 'after'  => '</div>')); ?>
		</div><!-- .entry-content -->

		</article><!-- #post-<?php the_ID(); ?> -->
<?php endif; ?>