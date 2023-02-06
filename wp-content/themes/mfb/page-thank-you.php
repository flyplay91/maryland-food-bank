<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maryland_Food_Bank
 */
// first_name=Brian
// last_name=Albright
// email=eel.darkbrain%40gmail.com
// amount=Other
// other=%245.00
// type=One+Time+Donation
// date=10%2F25%2F2018
// payment=Credit+Card&

// <h3>This is your official receipt:</h3>
// <strong>Name</strong>: [urlparam param="first_name" /] [urlparam param="last_name" /]
// <strong>Email</strong>: [urlparam param="email" /]
// <strong>Amount</strong>: [ifurlparam param="amount" is="Other"][urlparam param="other" /][/ifurlparam][ifurlparam param="other" empty="1"][urlparam param="amount" /][/ifurlparam]
// <strong>Payment Type</strong>: [urlparam param="type" /]
// <strong>Payment Method</strong>: [urlparam param="payment" /]
// <strong>Date</strong>: [urlparam param="date" /]
get_header();
$data = array(
    'id' => get_query_var( 'entry_id' ),
    'amount' => get_query_var( 'amount' ),
    'type' => get_query_var( 'type' ),
    'payment' => get_query_var( 'payment' ),
    'referrer' => wp_get_referer(),
);

if ($data['amount'] == 'Other') {
    $data['other'] = TRUE;
    $data['amount'] = get_query_var( 'other' );
}
?>

<?php //if($data['referrer']): ?>
  <script type="text/javascript">
    // console.log('amount <?php echo $data['amount']; ?>'); // Uncomment for testing purposes
    ga('require', 'ecommerce');
    ga('ecommerce:addTransaction', {
      'id': '<?php echo $data['id']; ?>',
      'revenue': '<?php echo $data['amount']; ?>',
    });

    ga('ecommerce:addItem', {
      'id': '<?php echo $data['id']; ?>',
      'name': '<?php echo $data['payment']; ?> - <?php echo $data['type']; ?>',
      'sku': '<?php echo $data['payment']; ?>',
      'category': '<?php echo $data['type']; ?>',
      'price': '<?php echo $data['amount']; ?>',
      'quantity': '1'
    });
    ga('ecommerce:send');
  </script>
<?php //endif; ?>
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

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
