<?php
/*
Template Name: News
*/
get_header();
?>
<ul class="bycategories">
<?php wp_list_categories('title_li='); ?>
</ul>
<?php
get_footer();
