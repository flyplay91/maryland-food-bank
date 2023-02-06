<?php
/**
 * Template part for displaying the content header
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maryland_Food_Bank
 */

?>
<header class="content-header">
  <div class="compartment">
    <div class="compartment--inner">
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      <?php if (function_exists('yoast_breadcrumb')): ?>
        <?php yoast_breadcrumb('<div class="breadcrumbs">','</div>'); ?>
      <?php endif; ?>
    </div>
  </div>
</header><!-- .entry-header -->


