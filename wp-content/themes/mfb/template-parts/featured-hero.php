<?php $featured_query = new WP_Query( array( 'category_name' => 'featured', 'posts_per_page' => '1' ) ); ?>
<?php if($featured_query->have_posts()): ?>
	<?php while($featured_query->have_posts()): ?>
		<?php $featured_query->the_post(); ?>
		<?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); ?>
		<div class="post-featured" style="background-image: url(<?php echo $featured_img_url; ?>);">
			<div class="compartment">
				<div class="compartment--inner">
					<div class="post-featured__content">
						<h2 class="post-featured__title"><?php the_title() ?></h2>
						<a class="post-featured__button" href="<?php the_permalink(); ?> ">Read More</a>
					</div>
				</div>
			</div>
			<div class="post-featured__overlay"></div>
		</div>
	<?php endwhile; ?>
<?php endif; ?>