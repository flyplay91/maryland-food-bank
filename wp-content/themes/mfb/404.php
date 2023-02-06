<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Maryland_Food_Bank
 */

get_header();
?>
<header class="content-header">
  <div class="compartment">
    <div class="compartment--inner">
      <h1 class="entry-title">404</h1>
			<div class="breadcrumbs">
				<span><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span class="divider"> &gt; </span> <span class="breadcrumb_last">404</span></span></span>
			</div>
		</div>
  </div>
</header>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<div id="et-boc" class="et-boc">
			<div id="et_builder_outer_content" class="et_builder_outer_content">
				<div class="et_builder_inner_content et_pb_gutters3">
					<?php echo do_shortcode('[et_pb_section global_module="24971"][/et_pb_section]'); ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
