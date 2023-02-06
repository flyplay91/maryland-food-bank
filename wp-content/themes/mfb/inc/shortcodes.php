<?php
/**
 * Custom shortcodes for this theme.
 *
 *
 * @package mfb
 */

function mfb_remove_janky_markup( $string ) {
	$patterns = array(
		'#^\s*</p>#',
		'#<p>\s*$#'
	);
	return preg_replace($patterns, '', $string);
}

function mfb_events_loop($atts, $content = null) {
	$args = array (
		'post_type' => 'tribe_events',
		'posts_per_page' => 1,
	);
	if (isset($atts['limit']) && is_numeric($atts['limit'])) {
		$args['posts_per_page'] = $atts['limit'];
	}
	if (isset($atts['offset']) && is_numeric($atts['offset'])) {
		$args['offset'] = $atts['offset'];
	}
	if (isset($atts['id']) && is_numeric($atts['id'])) {
		$args['p'] = $atts['id'];
	}
	$events_query = new WP_Query ($args);
	// dump everything that happens next into the magical output buffer
	ob_start(); ?>

	<?php if($events_query->have_posts()): ?>
		<?php while($events_query->have_posts()): ?>
			<?php $events_query->the_post(); ?>
			<?php $gpm = get_post_meta( get_the_ID() ); ?>
			<?php	//echo print_r( $gpm, true ); exit;?>
			<?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); ?>
			<a class="event-block" href="<?php the_permalink(); ?>">
				<div class="event-block__header">
					<div class="event-block__image" style="background-image: url(<?php echo $featured_img_url; ?>);"></div>
					<div class="event-block__datetime">
						<span class="event-block__date"><?php echo date('Y-m-d', strtotime($gpm['_EventStartDate'][0])); ?></span>
						<span class="event-block__time"><?php echo date('g:iA', strtotime($gpm['_EventStartDate'][0])); ?></span>
					</div>
				</div>
				<div class="event-block__content">
					<div class="event-block__title"><?php the_title(); ?></div>
					<div class="event-block__text"><?php the_excerpt(); ?></div>
				</div>
			</a>
		<?php endwhile; ?>
		<?php // you need this every time you have a custom query and if you don't, other queries down the page can get borked ?>
		<?php	wp_reset_postdata(); ?>

	<?php endif; ?>

	<?php return ob_get_clean();
}
add_shortcode('events-loop', 'mfb_events_loop');

function mfb_news_latest($atts, $content = null) {
	$args = array (
		'post_type' => 'post',
		'posts_per_page' => 1,
	);
	if (isset($atts['limit']) && is_numeric($atts['limit'])) {
		$args['posts_per_page'] = $atts['limit'];
	}
	if (isset($atts['id']) && is_numeric($atts['id'])) {
		$args['p'] = $atts['id'];
	}
	if (isset($atts['category'])) {
		$args['category_name'] = $atts['category'];
	}
	if (isset($atts['tag'])) {
		$args['tag'] = $atts['tag'];
	}
	$posts_query = new WP_Query ($args);

	// dump everything that happens next into the magical output buffer
	ob_start(); ?>

	<?php if($posts_query->have_posts()): ?>
		<div class="posts-results">
			<?php while($posts_query->have_posts()): ?>
				<?php $posts_query->the_post(); ?>
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
								<div class="post-result__date"><?php echo get_the_date( '' ); ?></div>
								<?php the_title('<h2 class="post-result__title">', '</h2>'); ?>
							</header><!-- .entry-header -->

							<div class="post-result__content">
								<?php the_excerpt(); ?>
							</div><!-- .entry-content -->

							<footer class="post-result__footer">
								<a class="post-result__button" href="<?php the_permalink(); ?> ">Read More</a>
							</footer><!-- .entry-footer -->
						</div>
					</div>
				</article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; ?>
			<?php // you need this every time you have a custom query and if you don't, other queries down the page can get borked ?>
			<?php	wp_reset_postdata(); ?>
		</div>
	<?php endif; ?>

	<?php return ob_get_clean();
}
add_shortcode('news-latest', 'mfb_news_latest');
