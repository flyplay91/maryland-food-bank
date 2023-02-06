<?php
/**
 * Template part for displaying the content filters / search
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maryland_Food_Bank
 */
// global $wp_query;
// $post_type_obj = $wp_query->get_queried_object();
// print_r($post_type_obj);
global $wp;
	$current_url = home_url( add_query_arg( array(), $wp->request ) );
	// print $current_url;
	// exit;
?>
<form method="get" action="<?php $current_url; ?>">
<fieldset>
<input placeholder="search category" type="text" name="s" value="" maxlength="50" required="required" />
<select name="category_name">
<option value="industrynews">Industry News</option>
<option value="webdesign">Web Design</option>
</select>
<button type="submit">Search</button>
</fieldset>
</form>
<div class="posts-header">
  <h4>Search by Keyword</h4>
  <?php get_search_form(); ?>
  <div class="post-header__categories silc-accordion">
    <section class="silc-accordion__section">
      <header class="silc-accordion__header">
        <h2 class="silc-accordion__label">Browse by Category</h2>
      </header>
      <div class="silc-accordion__content">
        <ul>
          <?php wp_list_categories(array('orderby' => 'name', 'title_li' => '', 'depth' => 1, 'use_desc_for_title' => false, 'show_count' => false, 'exclude' => array(10))); ?>
        </ul>
      </div>
    </section>
  </div>
</div>