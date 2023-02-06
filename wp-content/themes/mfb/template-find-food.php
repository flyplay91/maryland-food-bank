<?php /* Template Name: Find food */ ?>
<?php get_header(); ?>
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
    <div class="section--find-food">
      <?php echo do_shortcode("[gmw form='1' name='form_id_1']"); ?>
    </div>
  </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>